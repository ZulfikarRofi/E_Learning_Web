<?php

namespace App\Http\Controllers;

use App\Helpers\RestAPIFormatter;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaContoller extends Controller
{
    public function getDataSiswa()
    {
        $data = auth()->user();

        return RestApiFormatter::createAPI(200, 'Success', $data);
        //declaration variable
        // $siswa = DB::table('siswa')
        //     ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
        //     ->join('periode', 'kelas.periode_id', '=', 'periode.id')
        //     ->where('siswa.id', 1)
        //     ->first();

        // $dataKelasKu = DB::table('mapel')
        //     ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
        //     ->join('siswa', 'siswa.kelas_id', '=', 'kelas.id')
        //     ->join('periode', 'kelas.periode_id', '=', 'periode.id')
        //     ->where('siswa.id', auth()->user()->siswa_id)
        //     ->get();

        // $value = Carbon::now();
        // $dataTugasKu = DB::table('kuis')
        //     ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
        //     ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
        //     ->join('periode', 'kelas.periode_id', '=', 'periode.id')
        //     ->where('duedate', '<', $value)
        //     ->get();

        // sending messages
        if ($siswa) {
            if ($dataKelasKu) {
                if ($dataTugasKu) {
                    return RestAPIFormatter::createAPI(200, 'Success', [$siswa, $dataKelasKu, $dataTugasKu]);
                } else {
                    return RestAPIFormatter::createAPI(400, 'Failed');
                }
                return RestAPIFormatter::createAPI(200, 'Not Complete', [$siswa, $dataKelasKu]);
            } else {
                return RestAPIFormatter::createAPI(400, 'Not Complete', $siswa);
            }
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    public function getDataMapelSiswa($id){
        $data = DB::table('mapel')
            ->selectRaw('mapel.id as id, mapel.id as id_mapel, nama_mapel, nama_kelas, nama_guru, guru.id as guru_id, kelas.id as kelas_id')
            ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
            ->join('guru', 'mapel.guru_id', '=', 'guru.id')
            ->join('siswa', 'siswa.kelas_id', '=', 'kelas.id')
            // ->join('modul', 'modul.mapel_id', '=', 'mapel.id')
            ->where('siswa.id', $id)
            // ->groupBy('mapel.id', 'nama_mapel', 'nama_kelas', 'nama_guru', 'guru.id', 'kelas.id')
            ->get();
        if($data){
            return RestAPIFormatter::createAPI(200, 'Success', $data);
        }
        else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    public function getTugasKu($id) {
        $result = new Collection();
        $tugasku = DB::table('task')
        ->selectRaw('task.id as id, nama_tugas, nama_kelas, nama_mapel, due_date')
        ->join('mapel', 'task.mapel_id', '=', 'mapel.id')
        ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
        ->join('guru', 'mapel.guru_id', '=', 'guru.id')
        ->join('siswa', 'siswa.kelas_id', '=', 'kelas.id')
        ->where('siswa.id', $id)
        ->get();

        foreach($tugasku as $t){
        //format penanggalan
            $setTanggal = Carbon::parse($t->due_date);
            $dayDatePart = $setTanggal->format('l, d-m-y');
            $timePart = $setTanggal->format('H:i');
            list($day, $datePart) = explode(', ', $dayDatePart, 2);
            $toIndonesian = [
                'Monday'    => 'Sen',
                'Tuesday'   => 'Sel',
                'Wednesday' => 'Rab',
                'Thursday'  => 'Kam',
                'Friday'    => 'Jum',
                'Saturday'  => 'Sab',
                'Sunday'    => 'Min',
            ];
            $getHari = $toIndonesian[$day];
            $dueDateFix = $getHari . ', ' . $datePart;
            $result->push([
                'id' => $t->id,
                'nama_tugas' => $t->nama_tugas,
                'nama_kelas' => $t->nama_kelas,
                'nama_mapel' => $t->nama_mapel,
                'due_date' => $dueDateFix,
            ]);
        }

        if($tugasku){
            return RestAPIFormatter::createAPI(200, 'Success', $result);
        }
        else{
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    public function detailKuis($id){
        $dataKuis = DB::table('mapel')
        ->join('kuis', 'kuis.mapel_id', '=', 'mapel.id')
        ->where('kuis.id', $id)
        ->first();

        if($dataKuis){
            return RestAPIFormatter::createAPI(200, 'Success', $dataKuis);
        }
        else{
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    public function detailTugas($id){
        $result = new Collection();
        $dataTugas = DB::table('task')
        // ->selectRaw('task.id as id, nama_tugas, nama_kelas, nama_mapel, nama_guru, deskripsi_tugas, ')
        ->join('mapel', 'task.mapel_id', '=', 'mapel.id')
        ->join('guru', 'mapel.guru_id', '=', 'guru.id')
        ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
        ->where('task.id', $id)
        ->first();

        $setTanggal = Carbon::parse($dataTugas->due_date);
        $dayDatePart = $setTanggal->format('l, d-m-y');
        $timePart = $setTanggal->format('H:i');
        list($day, $datePart) = explode(', ', $dayDatePart, 2);
        $toIndonesian = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];
        $getHari = $toIndonesian[$day];
        $dueDateFix = $getHari . ', ' . $datePart;

        $result->push([
            'id' => $dataTugas->id,
            'nama_tugas' => $dataTugas->nama_tugas,
            'nama_mapel' => $dataTugas->nama_mapel,
            'nama_kelas' => $dataTugas->nama_kelas,
            'nama_guru' => $dataTugas->nama_guru,
            'deskripsi_tugas' => $dataTugas->deskripsi_tugas,
            'due_date' => $dueDateFix,
        ]);

        if($dataTugas){
            return RestAPIFormatter::createAPI(200, 'Success', $result);
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    public function detailMapel($id)
    {
        //declaration variables
        $dataMapel = DB::table('mapel')
            ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
            ->join('guru', 'mapel.guru_id', '=', 'guru.id')
            ->where('mapel.id', $id)
            ->first();
        //sending messages
        if ($dataMapel) {
            return RestAPIFormatter::createAPI(200, 'Success', $dataMapel);
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    public function materiMapel($id){
        $dataMateri = new Collection();
        $materiMapel = DB::table('mapel')
        ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
        ->join('guru', 'mapel.guru_id', '=', 'guru.id')
        ->join('modul', 'modul.mapel_id', '=', 'mapel.id')
        ->where('mapel.id', $id)
        ->get();
        foreach($materiMapel as $mm){
            $setTanggal = Carbon::parse($mm->tanggal_regis);
            $dayDatePart = $setTanggal->format('l, d-m-y');
            $timePart = $setTanggal->format('H:i');
            list($day, $datePart) = explode(', ', $dayDatePart, 2);
            $toIndonesian = [
                'Monday'    => 'Senin',
                'Tuesday'   => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday'  => 'Kamis',
                'Friday'    => 'Jumat',
                'Saturday'  => 'Sabtu',
                'Sunday'    => 'Minggu',
            ];
            $getHari = $toIndonesian[$day];
            $dueDateFix = $getHari . ', ' . $datePart;

            $dataMateri->push([
                'id' => $mm->id,
                'mapel_id' => $mm->mapel_id,
                'kelas_id' => $mm->kelas_id,
                'nama_mapel' => $mm->nama_mapel,
                'nama_kelas' => $mm->nama_kelas,
                'nama_guru' => $mm->nama_guru,
                'nama_modul' => $mm->nama_modul,
                'modul_number' => $mm->modul_number,
                'tanggal_regis' => $dueDateFix,
                'jam_regis' => $timePart,
            ]);
        }

        if ($materiMapel) {
            return RestAPIFormatter::createAPI(200, 'Success', $dataMateri);
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    public function daftarKuis($id)
    {
        $dataKuis = DB::table('kuis')
            ->selectRaw('kuis.id as id_kuis, kuis.mapel_id as mapel_id, mapel.kelas_id as kelas_id, nama_mapel, nama_kelas, nama_kuis, duedate')
            ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
            ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
            ->join('periode', 'kelas.periode_id', '=', 'periode.id')
            ->join('siswa', 'siswa.kelas_id', '=', 'kelas.id')
            ->where('siswa.id', $id)
            ->get();

        if ($dataKuis) {
            return RestAPIFormatter::createAPI(200, 'Success', $dataKuis);
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    public function getTugasSiswa($id){
        $result = new Collection();
        $dataTugas = DB::table('task')
        ->selectRaw('task.id as id, nama_tugas, nama_kelas, nama_mapel, due_date, task.mapel_id as mapel_id, mapel.kelas_id as kelas_id')
        ->join('mapel', 'task.mapel_id', '=', 'mapel.id')
        ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
        ->join('periode', 'kelas.periode_id', '=', 'periode.id')
        ->join('siswa', 'siswa.kelas_id', '=', 'kelas.id')
        ->where('siswa.id', $id)
        ->get();


        foreach($dataTugas as $t){
            //format penanggalan
                $setTanggal = Carbon::parse($t->due_date);
                $dayDatePart = $setTanggal->format('l, d-m-y');
                $timePart = $setTanggal->format('H:i');
                list($day, $datePart) = explode(', ', $dayDatePart, 2);
                $toIndonesian = [
                    'Monday'    => 'Sen',
                    'Tuesday'   => 'Sel',
                    'Wednesday' => 'Rab',
                    'Thursday'  => 'Kam',
                    'Friday'    => 'Jum',
                    'Saturday'  => 'Sab',
                    'Sunday'    => 'Min',
                ];
                $getHari = $toIndonesian[$day];
                $dueDateFix = $getHari . ', ' . $datePart;
                $result->push([
                    'id' => $t->id,
                    'nama_tugas' => $t->nama_tugas,
                    'nama_kelas' => $t->nama_kelas,
                    'nama_mapel' => $t->nama_mapel,
                    'due_date' => $dueDateFix,
                ]);
            }


        if($dataTugas){
            return RestAPIFormatter::createAPI(200, 'Success', $result);
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    public function dateRange(){
        $today = Carbon::parse(Carbon::now());
        $lastWeek = Carbon::parse(Carbon::now()->subDays(7));
        $dateRange = $today->copy()->addWeek();

        while ($today <= $dateRange){
            $today->format('l jS');
            $today->addDay();
            if($today){
                return RestAPIFormatter::createAPI(200, 'Success', $today);
            }
            else {
                return RestAPIFormatter::createAPI(400, 'Failed');
            }
        }
    }

    public function jadwalku($id)
    {
        $jamMasuk = null;
        $jamAkhir = null;
        $jadwal = new Collection();
        $today = Carbon::parse(Carbon::now());
        $dataMapelHarian = DB::table('mapel')
        ->selectRaw('task.id as id, nama_kelas, nama_guru, nama_mapel, nama_tugas, jam_pelajaran')
            ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
            ->join('task', 'task.mapel_id', '=', 'mapel.id')
            ->join('guru', 'mapel.guru_id', '=', 'guru.id')
            ->join('siswa', 'siswa.kelas_id', '=', 'kelas.id')
            ->where('siswa.id', $id)
            // ->where('hari_pelajaran', $today->day())
            ->get();

        foreach($dataMapelHarian as $dm){
            $jamPelajaran = json_decode($dm->jam_pelajaran, true);
            if($jamPelajaran){
                $jamMasuk = $jamPelajaran[0];
                $jamAkhir = $jamPelajaran[1];
            }
            else {
                echo "The 'jam_pelajaran' key does not exist or the array is empty.";
            }

            $jadwal->push([
                'id' => $dm->id,
                'nama_mapel' => $dm->nama_mapel,
                'nama_guru' => $dm->nama_guru,
                'nama_tugas' => $dm->nama_tugas,
                'nama_kelas' => $dm->nama_kelas,
                'jam_masuk' => $jamMasuk,
                'jam_akhir' => $jamAkhir,
            ]);
        }

        if ($dataMapelHarian) {
            return RestAPIFormatter::createAPI(200, 'Success', $jadwal);
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    public function detailMateri($id)
    {
        $materi = DB::table('mapel')
            ->join('guru', 'mapel.guru_id', '=', 'guru.id')
            ->join('modul', 'modul.mapel_id', '=', 'mapel.id')
            ->where('modul.id', $id)
            ->first();

        if ($materi) {
            return RestAPIFormatter::createAPI(200, 'Success', $materi);
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    public function daftarSiswa()
    {
        $dataSiswa = DB::table('kelas')
            ->join('periode', 'kelas.periode_id', '=', 'periode.id')
            ->join('siswa', 'siswa.kelas_id', '=', 'kelas.id')
            ->where('kelas.id', 2)
            ->get();

        if ($dataSiswa) {
            return RestAPIFormatter::createAPI(200, 'Success', $dataSiswa);
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    public function listChatbot($id){

        $data = new Collection();
        $listBot = DB::table('list_chat')
                    ->selectRaw('list_chat.id as id, siswa.name as name, bot.nama_bot as nama_bot, message_fill, chat.created_at as created_at')
                    ->join('chat', 'chat.list_id', '=', 'list_chat.id')
                    ->join('siswa', 'list_chat.siswa_id', '=', 'siswa.id')
                    ->join('bot', 'list_chat.bot_id', '=', 'bot.id')
                    ->where('list_chat.siswa_id', $id)
                    ->orderBy('list_chat.created_at', 'Desc')
                    ->first();
            $send_time = Carbon::parse($listBot->created_at);
            $gap = Carbon::now()->diffInDays($send_time);
            if($gap == 1){
                $send_time = 'Kemarin';
            } else if($gap > 1){
                $send_time = Carbon::parse($listBot->created_at)->format('Y/m/d');
            }
            else{
                $send_time = $send_time->format('H:i');
            }
            $data->push([
                'id' => $listBot->id,
                'name' => $listBot->name,
                'bot_name' => $listBot->nama_bot,
                'last_chat' => $listBot->message_fill,
                'time' => $send_time,
                'gap' => $gap,
            ]);
        if ($data) {
            return RestAPIFormatter::createAPI(200, 'Success', $data);
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }
}
