<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use App\Models\Bot;
use App\Models\ListChat;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        $idUser = auth()->user()->guru_id;
        $dataMapel = DB::table('kelas')->selectRaw('mapel.id as id, nama_mapel, nama_kelas,mapel_id, hari_pelajaran, jam_pelajaran')
            ->join('mapel',  'kelas.id', '=', 'mapel.kelas_id')
            ->rightJoin('guru', 'mapel.guru_id', '=', 'guru.id')
            ->where('guru_id', $idUser)
            ->get();
        $userdata = DB::table('guru')->where('id', $idUser)->first();

        //recently activities
        $activities = new Collection();

        $today = Carbon::now();
        $yesterday = Carbon::now()->subDay(1);

        $thisYear = Carbon::now()->format('Y');
        $nextYear = Carbon::now()->addYear(1)->format('Y');
        $thisDay = $today->format('Y-m-d');
        // dd($thisYear, $nextYear);

        $kuis = DB::table('kuis')
            ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            ->whereBetween('kuis.created_at', [$yesterday, $today])
            ->get();

        $modul = DB::table('modul')
            ->join('mapel', 'modul.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            ->whereBetween('modul.created_at', [$yesterday, $today])
            ->get();

        $task = DB::table('task')
            ->join('mapel', 'task.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            ->whereBetween('task.created_at', [$yesterday, $today])
            ->get();

        foreach ($kuis as $b) {
            if ($activities->where('name', $b->nama_kuis)->count() === 0) {
                $activities->push([
                    'name' => $b->nama_kuis,
                    'category' => 'Kuis',
                    'tanggal_regis' => $b->created_at,
                    'status' => 'Dipublikasikan',
                ]);
            }
        }

        foreach ($task as $b) {
            if ($activities->where('name', $b->nama_tugas)->count() === 0) {
                $activities->push([
                    'name' => $b->nama_tugas,
                    'category' => 'Tugas',
                    'tanggal_regis' => $b->created_at,
                    'status' => 'Dipublikasikan',
                ]);
            }
        }

        foreach ($modul as $b) {
            if ($activities->where('name', $b->nama_modul)->count() === 0) {
                $activities->push([
                    'name' => $b->nama_modul,
                    'category' => 'Materi',
                    'tanggal_regis' => $b->created_at,
                    'status' => 'Dipublikasikan',
                ]);
            }
        }

        View::share('activities', $activities);

        // dd($activities);
        return view('pages.dashboard', compact('dataMapel', 'userdata'));
    }

    public function botRingkas(Request $request){
        $file_contents = File::get(database_path('factories/datamaster.json'));
        $dataRingkasan = new Collection();
        $tokening = new Collection();
        $resultToken = new Collection();
        $data = json_decode($file_contents, true);
        if($data && isset($data['Datamaster'])){
            $sentences  = $data['Datamaster'];
            foreach($sentences as $s){
                $dataRingkasan->push([
                    'data' => $s
                ]);
                $words = explode(' ',$s);
                $tokening->push([
                    'words' => $words
                ]);
            }
            foreach($tokening as $token){
                if(isset($token['words']) && is_array($token['words'])){
                    foreach($token['words'] as $word){
                        $resultToken->push([
                            'data' => $word
                        ]);
                    }

                }
            }
        }
        else {
            echo 'Error data';
        }

        // dd($tokening ,$resultToken);

        return view('pages.botringkas', compact('dataRingkasan', 'tokening', 'resultToken'));
    }

    public function chatbotDashboard(){

        $data = DB::table('mapel')->selectRaw('mapel.id as idMapel, kelas.id as idKelas, nama_mapel, nama_kelas')->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')->orderBy('nama_kelas')->get();


        $dataBot = new Collection();

        $allBot = DB::table('bot')
        ->selectRaw('bot.id as idBot, mapel.id as idMapel, kelas.id as idKelas, nama_kelas, nama_bot, nama_mapel, bot.updated_at as updated_at, bot.created_at as created_at')
        ->join('mapel', 'bot.mapel_id', '=', 'mapel.id')
        ->join('kelas', 'bot.kelas_id', '=', 'kelas.id')
        ->get();

        foreach($allBot as $ab){
            $lastUpdate = Carbon::parse($ab->updated_at);
            $newUpdate = Carbon::now()->diff($lastUpdate)->days;
            $dataBot->push([
                'bot_id' => $ab->idBot,
                'kelas_id' => $ab->idKelas,
                'nama_bot' => $ab->nama_bot,
                'total_data' => 0,
                'last_update' => $newUpdate,

            ]);
        }

        // dd($dataBot);
        return view('pages.chatbot', compact('data', 'dataBot'));
    }

    public function createBot(Request $request){
        $request->validate([
            'nama_bot' => 'required',
            'id_kelasMapel' => 'required',
        ]);

        $newBot = new Bot();
        $newBot->nama_bot = $request->nama_bot;
        $newBot->kelas_id = $request->id_kelasMapel[4];
        $newBot->mapel_id = $request->id_kelasMapel[1];
        $idBot = DB::table('bot')->orderByDesc('id')->pluck('id')->first();
        $codeKelas = str_pad($newBot->kelas_id + 1, 3, '0', STR_PAD_LEFT);
        $codeMapel = str_pad($newBot->mapel_id + 1, 3, '0', STR_PAD_LEFT);
        $newBot->bot_number = 'Bot-' . $idBot . $codeKelas . '-' . $codeMapel;
        $newBot->save();

        // dd($newBot);

        return redirect('/chatbot')->with('success', 'Bot Baru Berhasil Ditambahkan');
    }

    public function createListChatbot(Request $request){
        $request->validate([
            'bot_id' => 'required',
            'kelas_id' => 'required',
        ]);

        $idSiswa = new Collection();
        $dataSiswa = DB::table("siswa")
        ->selectRaw("id, name")
        ->where('kelas_id', $request->kelas_id)
        ->get();

        // dd($dataSiswa, $request->kelas_id, $request->bot_id);
        // foreach($dataSiswa as $ds){
        //     $idSiswa->push([
        //         'id' => $ds->id,
        //         'name' => $ds->name,
        //     ]);
        // }

        foreach($dataSiswa as $dS){
            $ListChat = new ListChat();
            $ListChat->bot_id = $request->bot_id;
            $ListChat->siswa_id = $dS->id;
            $ListChat->save();
            // dd($ListChat);
        }

        // dd($idSiswa);
        // echo $idSiswa;
        return redirect()->back()->with('success', '');
    }

    public function detailChatbot($id){

        $dataBot = DB::table('bot')
                    ->join('kelas', 'bot.kelas_id', '=', 'kelas.id')
                    ->join('mapel', 'bot.mapel_id', '=', 'mapel.id')
                    ->where('bot.id', $id)
                    ->first();

        $listSiswa = DB::table('list_chat')
                        ->join('siswa', 'list_chat.siswa_id', '=', 'siswa.id')
                        ->join('bot', 'list_chat.bot_id', '=', 'bot.id')
                        ->join('kelas', 'bot.kelas_id', '=', 'kelas.id')
                        ->join('mapel', 'bot.mapel_id', '=', 'mapel.id')
                        ->where('bot.id', $id)
                        ->get();
        // dd($listSiswa);
        return view('pages.detailbot',compact('dataBot', 'listSiswa'));
    }
}
