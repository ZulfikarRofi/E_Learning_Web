<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\MataPelajaran;
use App\Models\Modul;
use App\Models\Periode;
use App\Models\Report;
use App\Models\Siswa;
use App\Models\Task;
use Carbon\Carbon;
use FontLib\TrueType\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class PelajaranController extends Controller
{
    //Fungsi Get Periode

    public function getAllData()
    {
        $kelas = DB::table('periode')
            ->join('kelas', 'periode.id', '=', 'kelas.periode_id')
            // ->groupBy('kelas.periode_id')
            ->get();
        $period = Periode::all();

        $guru = Guru::all();
        $dataMapel = DB::table('mapel')->selectRaw('mapel.id as id, nama_kelas, nama_mapel, mapel_id, hari_pelajaran, jam_pelajaran, nama_guru, status, jenis_kelamin')
            ->join('guru', 'mapel.guru_id', '=', 'guru.id')
            ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
            ->join('periode', 'kelas.periode_id', '=', 'periode.id')
            ->get();
        // dd($dataMapel);

        return view('pages.kelas', compact('period', 'kelas', 'guru', 'dataMapel'));
    }

    //Fungsi Store Periode
    public function addPeriod(Request $request)
    {
        //
        $request->validate(
            [
                'tanggal_mulai' => 'required',
                'tanggal_akhir' => 'required',
                'tipe' => 'required'
            ]
        );

        $period = new Periode();
        $period->tanggal_mulai =  Carbon::parse($request->tanggal_mulai);
        $period->tanggal_akhir = Carbon::parse($request->tanggal_akhir);
        $period->tipe = $request->tipe;
        $period->tahun_ajaran = $period->tanggal_mulai->format('Y') . '/' . $period->tanggal_akhir->format('Y');
        $period->save();
        // dd($period);

        return redirect('/manajemenPelajaran')->with('success', 'Data Periode Baru Sukses Ditambahkan');
    }

    //Edit Status Periode
    public function editStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ]);

        $model = Periode::find($id);
        $model->status = $request->status;
        $model->update();
        // dd($model);

        return redirect('/manajemenPelajaran')->with('success', 'Status Berhasil Diganti');
    }

    public function addKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required',
            'periode_id' => 'required',
        ]);

        $kelas = new Kelas();
        $kelas->nama_kelas = $request->nama_kelas;
        $kelas->periode_id = $request->periode_id;
        $kelas->save();
        // dd($kelas);

        return redirect('/manajemenPelajaran')->with('success', 'Data Kelas Baru Berhasil Ditambahkan');
    }

    public function getSelectionClass($id)
    {
        $data = DB::table('periode')
            ->join('kelas', 'periode.id', '=', 'kelas.periode_id')
            ->where('kelas.id', $id)
            // ->groupBy('kelas.periode_id')
            ->get();

        $classParticipate = DB::table('kelas')
            ->join('siswa', 'siswa.kelas_id', '=', 'kelas.id')
            ->where('kelas_id', $id)
            ->orderBy('nis')
            ->get();

        $notParticipate = DB::table('kelas')
            ->join('siswa', 'siswa.kelas_id', '=', 'kelas.id')
            ->where('kelas_id', 1)
            ->orderBy('nis')
            ->get();

        // dd($notParticipate);
        // dd($classParticipate);
        // dd($data);
        // echo $data;

        return view('pages.detailkelas', compact('data', 'classParticipate', 'notParticipate'));
    }

    public function kickOutStudent($id)
    {
        $siswa = Siswa::find($id);
        $siswa->kelas_id = 1;
        $siswa->update();
        // dd($siswa);

        return redirect()->back();
    }

    public function updateKelas(Request $request)
    {

        $kelasId = $request->input('kelas');
        $arr = $request->input('siswa');
        foreach ($arr as $d) {
            Siswa::where('id', $d)->update(['kelas_id' => $kelasId]);
        }

        return redirect()->back();
    }


    public function addMapel(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required',
            'guru_id' => 'required',
            'deskripsi' => 'required',
            'kelas_id' => 'required',
            'hari_pelajaran' => 'required',
            'jam_masuk' => 'required',
            'jam_selesai' => 'required',
        ]);

        $new = new MataPelajaran();
        $new->nama_mapel = $request->nama_mapel;
        $getlastId = DB::table('mapel')->count();
        //Format Mapel ID
        $new->mapel_id = 'mp' . '-' . str_pad($getlastId + 1, 3, '0', STR_PAD_LEFT);
        //End Format Mapel ID
        $new->deskripsi = $request->deskripsi;
        $new->guru_id = $request->guru_id;
        $new->kelas_id = $request->kelas_id;
        $new->hari_pelajaran = $request->hari_pelajaran;
        $jam_masuk = $request->input('jam_masuk');
        $jam_selesai = $request->input('jam_selesai');
        $new->jam_pelajaran = json_encode(array($jam_masuk, $jam_selesai));
        $new->progress = 0;
        // dd($new);
        $new->save();

        return redirect()->back()->with('success', 'Mata Pelajaran Baru Telah Ditambahkan');
    }

    public function getPersonalMapel()
    {
        $personalmapel = DB::table('guru')->get();
        dd($personalmapel);


        return view('pages.materi', compact(''));
    }

    public function getSelectedMapel($id)
    {
        $dataMapel = DB::table('guru')
            ->selectRaw('mapel.id as id, nama_mapel, nama_kelas, deskripsi, jenis_kelamin, nama_guru, progress')
            ->join('mapel', 'mapel.guru_id', '=', 'guru.id')
            ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
            ->where('mapel.id', $id)
            ->orderBy('nip')
            ->get();
        // dd($dataMapel, $id);

        $modul = DB::table('modul')
            ->where('mapel_id', $id)
            ->get();
        // dd($modul);

        $kuis = DB::table('kuis')
            ->selectRaw('kuis.id as id, nama_kuis')
            ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
            // ->where('kuis.mapel_id', $id)
            ->get();
        // dd($kuis);

        $totalKuis = DB::table('kuis')
            ->where('kuis.mapel_id', $id)
            ->count();
        // ->get();
        // dd($totalKuis);

        $totalModul = DB::table('modul')
            ->where('mapel_id', $id)
            ->count();
        // dd($totalModul);

        $totalTask = DB::table('task')
            ->where('mapel_id', $id)
            ->count();

        //recently activities
        $activities = new EloquentCollection();

        $today = Carbon::now();
        $yesterday = Carbon::now()->subDay(1);

        $thisYear = Carbon::now()->format('Y');
        $nextYear = Carbon::now()->addYear(1)->format('Y');
        $thisDay = $today->format('Y-m-d');
        // dd($thisYear, $nextYear);

        $allKuis = DB::table('kuis')->selectRaw('kuis.id as id, nama_kuis')
            ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            ->where('kuis.mapel_id', $id)
            // ->whereBetween('kuis.created_at', [$yesterday, $today])
            ->get();

        $kuis = DB::table('kuis')
            ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            ->whereBetween('kuis.created_at', [$yesterday, $today])
            ->get();

        $modul2 = DB::table('modul')
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

        foreach ($modul2 as $b) {
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

        // dd($dataMapel, $id, $kuis);
        return view('pages.detailMapel', compact('dataMapel', 'id', 'modul', 'totalModul', 'kuis', 'totalKuis', 'totalTask', 'allKuis'));
    }

    public function setProgressMapel(Request $request, $id){

        $request->validate([
                'progress_range' => 'required',
            ]);

        $mapel = MataPelajaran::find($id);
        $mapel->progress = $request->progress_range;
        // dd($mapel);
        $mapel->update();

        return redirect()->back()->with('success', 'Progress Telah Diperbarui');
    }

    public function getAllModul()
    {
        $idUser = auth()->user()->guru_id;
        $modul = DB::table('modul')->selectRaw('modul.id, nama_modul, nama_mapel, modul_number, tanggal_regis, judul')
            ->join('mapel', 'modul.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', $idUser)
            ->get();
        $a = Carbon::now();
        $b = Carbon::now()->subMonth(1);
        $tM = DB::table('modul')
            ->join('mapel', 'modul.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', $idUser)
            ->count();

        //recently activities
        $activities = new EloquentCollection();

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

        $modul2 = DB::table('modul')
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

        foreach ($modul2 as $b) {
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

        // dd($modul);
        return view('pages.materi', compact('modul', 'tM'));
    }

    public function getAddModul($id)
    {
        $mapel = DB::table('guru')
            ->join('mapel', 'mapel.guru_id', '=', 'guru.id')
            ->where('mapel.id', $id)
            ->get();

        //recently activities
        $activities = new EloquentCollection();

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

        $modul2 = DB::table('modul')
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

        foreach ($modul2 as $b) {
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

        return view('pages.addmodul', compact('mapel', 'id'));
    }

    public function storeAddModul(Request $request, $id)
    {
        // $request->validate([
        //     // 'guru_id' => 'required',
        //     'mapel_id' => 'required',
        //     'nama_modul' => 'required',
        //     'judul' => 'required',
        //     'tanggal_regis' => 'required',
        //     'deskripsi' => 'required',
        // ]);

        $modul = new Modul();
        $modul->guru_id = auth()->user()->guru_id;
        $modul->mapel_id = $id;
        $getlastId = DB::table('modul')->count();
        $modul->judul = $request->judul;
        $modul->modul_number = 'md-' . str_pad($getlastId + 1, 3, '0', STR_PAD_LEFT) . '-' . $modul->mapel_id;
        $modul->nama_modul = $request->nama_modul;
        $modul->tanggal_regis = Carbon::now($request->input('tanggal_regis'));
        $modul->deskripsi = $request->deskripsi;
        $modul->save();

        // dd($modul);
        return redirect('/materi')->with('success', 'Modul Baru Berhasil Ditambahkan');
    }

    public function getSelectedModul($id)
    {
        $selectedModul = DB::table('guru')
            ->join('modul', 'modul.guru_id', '=', 'guru.id')
            ->where('modul.id', $id)
            ->get();

        // dd($selectedModul);

        return view('pages.detailmateri', compact('selectedModul'));
    }

    public function deleteModul($id)
    {
        $modul = Modul::find($id);
        $modul->delete();

        return redirect('/')->with('success', 'Data materi berhasil dihapus');
    }

    public function getKuis()
    {
        $allKuis = Kuis::all();
        // $getIdBefore = DB::table('kuis')->orderByDesc('id')->pluck('id')->first();
        // dd($getIdBefore);
        $totalKuis = DB::table('kuis')
        ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
        ->join('guru', 'mapel.guru_id', '=', 'guru.id')
        ->where('guru.id', auth()->user()->guru_id)
        ->count();
        // dd($kuis, $totalKuis);



        //recently activities
        $activities = new EloquentCollection();

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

        $modul2 = DB::table('modul')
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

        foreach ($modul2 as $b) {
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

        return view('pages.kuis', compact('allKuis', 'totalKuis'));
    }

    public function getSelectedKuis($id)
    {
        $allKuis = DB::table('kuis')
            // ->selectRaw('kuis.id as id, nama_mapel, description, duedate, tanggal_regis, nama_kelas, nama_guru, tahun_ajaran, nama_kuis, kuis_number')
            ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
            ->join('guru', 'mapel.guru_id', '=', 'guru.id')
            ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
            ->join('periode', 'kelas.periode_id', '=', 'periode.id')
            ->where('kuis.id', $id)
            ->first();
        // dd($allKuis);

        $reportId = DB::table('report')->selectRaw('report.id as id, kuis.id as kuis_id')
            ->join('kuis', 'report.kuis_id', '=', 'kuis.id')
            ->where('kuis.id', $id)
            ->first();

        //recently activities
        $activities = new EloquentCollection();

        $today = Carbon::now();
        $yesterday = Carbon::now()->subDay(1);

        $thisYear = Carbon::now()->format('Y');
        $nextYear = Carbon::now()->addYear(1)->format('Y');
        $thisDay = $today->format('Y-m-d');
        // dd($thisYear, $nextYear);

        $kuis = DB::table('kuis')
            ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
            ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            ->whereBetween('kuis.created_at', [$yesterday, $today])
            ->get();
        // dd($kuis);
        $modul2 = DB::table('modul')
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

        foreach ($modul2 as $b) {
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

        // dd($reportId);
        return view('pages.detailkuis', compact('kuis', 'reportId', 'allKuis'));
    }

    public function addQuiz(Request $request, $id)
    {
        $modul = Modul::find($id);


        //recently activities
        $activities = new EloquentCollection();

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

        $modul2 = DB::table('modul')
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

        foreach ($modul2 as $b) {
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

        // dd($modul);
        return view('pages.addquiz', compact('modul', 'id'));
    }

    public function storeAddKuis(Request $request, $id)
    {
        $request->validate([
            'nama_kuis' => 'required',
            'description' => 'required',
            'duedate' => 'required',
        ]);

        $kuis = new Kuis();
        $kuis->nama_kuis = $request->nama_kuis;
        $kuis->mapel_id = $id;
        $kuis->description = $request->description;
        $kuis->duedate = $request->duedate;
        $kuis->tanggal_regis = Carbon::now();
        $getIdBefore = DB::table('kuis')->orderByDesc('id')->pluck('id')->first();
        $kuis->kuis_number = 'Qz' . '-' . $getIdBefore + 1 . Carbon::parse($kuis->tanggal_regis)->format('Ymd');
        $kuis->save();

        $report = new Report();
        $report->kuis_id = DB::table('kuis')->orderByDesc('id')->pluck('id')->first();
        $report->registered_date = Carbon::now();
        $getIdBeforeRp = DB::table('report')->orderByDesc('id')->pluck('id')->first();
        $getfirstmapel = DB::table('mapel')->selectRaw('nama_mapel')->where('id', $id)->first();
        $codeMapel = explode(' ', $getfirstmapel->nama_mapel);
        $fixCode = '';
        foreach ($codeMapel as $cM) {
            $fixCode .= strtoupper(substr($cM, 0, 1));
        }
        $report->report_number = 'Rp' . '-' . str_pad($getIdBeforeRp, 3, '0', STR_PAD_LEFT) . '-' . $fixCode;
        $report->save();
        // dd($kuis, $report);        return redirect('/kuis')->with('success', 'Kuis Baru Telah Ditambahkan');
    }

    public function deleteKuis($id)
    {
        $kuis = Kuis::find($id);
        $kuis->delete();

        return redirect('/manajemenPelajaran')->with('success', 'Kuis Telah Berhasil Dihapus');
    }

    public function getAddIsiKuis(Request $request, $id)
    {
        //recently activities
        $activities = new EloquentCollection();

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

        $modul2 = DB::table('modul')
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

        foreach ($modul2 as $b) {
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


        $request->validate([]);

        return view('pages.addquizz');
    }

    public function getTaskData()
    {
        $task = DB::table('task')
            ->selectRaw('task.id as id, nama_tugas, number_tugas, nama_mapel, nama_kelas, status')
            ->join('mapel', 'task.mapel_id', '=', 'mapel.id')
            ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
            ->join('periode', 'kelas.periode_id', '=', 'periode.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            ->get();

        $total_task = DB::table('task')
            ->join('mapel', 'task.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            ->count();
        // dd($task);
        return view('pages.task', compact('task', 'total_task'));
    }

    public function addTask(Request $request, $id)
    {
        $mapel = DB::table('mapel')
            ->where('id', $id)
            ->first();


        return view('pages.addtask', compact('mapel', 'id'));
    }

    public function storeAddTugas(Request $request, $id)
    {
        $request->validate([
            'nama_tugas' => 'required',
            'mapel_id' => 'required',
            'deskripsi_tugas' => 'required',
            'due_date' => 'required',
        ]);

        $getIdBefore = DB::table('task')->orderByDesc('id')->pluck('id')->first();
        $getGuruName = DB::table('guru')->where('id', $id)->first();
        $fixMapelId = strtoupper(substr($getGuruName->nama_guru, 0, 3));

        $task = new Task();
        $task->mapel_id = $id;
        $task->nama_tugas = $request->nama_tugas;
        $task->number_tugas = 'TSK' . '-' . $fixMapelId . '-' . str_pad($getIdBefore + 1, 3, '0', STR_PAD_LEFT);
        $task->deskripsi_tugas = $request->deskripsi_tugas;
        $task->tanggal_regis = Carbon::now();
        $task->due_date = $request->due_date;
        $task->guru_id = auth()->user()->guru_id;
        if ($request->file('file')) {
            $file = $request->file('file');
            $file_name = time() . str_replace(" ", "", $file->getClientOriginalName());
            $file->move('file', $file_name);
            $task->file = $file_name;
        }


        // dd($task);
        $task->save();

        return redirect()->back()->with('success', 'Tugas Baru Berhasil Ditambahkan');
    }

    public function getSelectedTask(Request $request, $id)
    {
        $task = DB::table('task')
            ->join('guru', 'task.guru_id', '=', 'guru.id')
            ->where('task.id', $id)
            ->first();

        // dd($task);

        return view('pages.detailtugas', compact('task'));
    }

    public function getSelectedReport($id)
    {
        $dataReport = DB::table('report')
            ->join('kuis', 'report.kuis_id', '=', 'kuis.id')
            ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
            ->join('kelas', 'mapel.kelas_id', '=', 'kelas.id')
            ->where('report.id', $id)
            ->first();

        $dataNilai = DB::table('nilai_siswa')
            ->join('penilaian', 'nilai_siswa.penilaian_id', '=', 'penilaian.id')
            ->join('siswa', 'nilai_siswa.siswa_id', '=', 'siswa.id')
            ->join('report', 'penilaian.report_id', '=', 'report.id')
            ->where('penilaian.report_id', $id)
            ->get();

        // dd($dataReport, $dataNilai);
        return view('pages.detailreport', compact('dataReport', 'dataNilai'));
    }

    public function getAllActivities()
    {
        $activities = new EloquentCollection();

        $today = Carbon::now();
        $yesterday = Carbon::now()->subDay(1);

        $thisYear = Carbon::now()->format('Y');
        $nextYear = Carbon::now()->addYear(1)->format('Y');
        $thisDay = $today->format('Y-m-d');


        $kuis = DB::table('kuis')
            ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            // ->whereBetween('kuis.created_at', [$yesterday, $today])
            ->get();

        $modul = DB::table('modul')
            ->join('mapel', 'modul.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            // ->whereBetween('modul.created_at', [$yesterday, $today])
            ->get();

        $task = DB::table('task')
            ->join('mapel', 'task.mapel_id', '=', 'mapel.id')
            ->where('mapel.guru_id', auth()->user()->guru_id)
            // ->whereBetween('task.created_at', [$yesterday, $today])
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
        // dd($activities[3], $thisDay);
        return view('layout.master', compact('periode', 'activities', 'today', 'yesterday'));
    }
}
