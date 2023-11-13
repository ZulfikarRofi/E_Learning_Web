<?php

namespace App\Providers;

use Carbon\Carbon;
use Facade\FlareClient\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View as FacadesView;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // FacadesView::composer('*', function ($view) {
        //     $activities = new Collection();

        //     $today = Carbon::now();
        //     $yesterday = Carbon::now()->subDay(1);

        //     $thisYear = Carbon::now()->format('Y');
        //     $nextYear = Carbon::now()->addYear(1)->format('Y');
        //     $thisDay = $today->format('Y-m-d');

        //     $kuis = DB::table('kuis')
        //         ->join('mapel', 'kuis.mapel_id', '=', 'mapel.id')
        //         // ->where('mapel.guru_id', auth()->user()->guru_id)
        //         // ->whereBetween('kuis.created_at', [$yesterday, $today])
        //         ->get();

        //     $modul = DB::table('modul')
        //         ->join('mapel', 'modul.mapel_id', '=', 'mapel.id')
        //         ->where('mapel.guru_id', auth()->user()->guru_id)
        //         // ->whereBetween('modul.created_at', [$yesterday, $today])
        //         ->get();

        //     $task = DB::table('task')
        //         ->join('mapel', 'task.mapel_id', '=', 'mapel.id')
        //         ->where('mapel.guru_id', auth()->user()->guru_id)
        //         // ->whereBetween('task.created_at', [$yesterday, $today])
        //         ->get();

        //     foreach ($kuis as $b) {
        //         if ($activities->where('name', $b->nama_kuis)->count() === 0) {
        //             $activities->push([
        //                 'name' => $b->nama_kuis,
        //                 'category' => 'Kuis',
        //                 'tanggal_regis' => $b->created_at,
        //                 'status' => 'Dipublikasikan',
        //             ]);
        //         }
        //     }

        //     foreach ($task as $b) {
        //         if ($activities->where('name', $b->nama_tugas)->count() === 0) {
        //             $activities->push([
        //                 'name' => $b->nama_tugas,
        //                 'category' => 'Tugas',
        //                 'tanggal_regis' => $b->created_at,
        //                 'status' => 'Dipublikasikan',
        //             ]);
        //         }
        //     }

        //     foreach ($modul as $b) {
        //         if ($activities->where('name', $b->nama_modul)->count() === 0) {
        //             $activities->push([
        //                 'name' => $b->nama_modul,
        //                 'category' => 'Materi',
        //                 'tanggal_regis' => $b->created_at,
        //                 'status' => 'Dipublikasikan',
        //             ]);
        //         }
        //     }

        //     $view->with('today', 'yesterday', 'activities', 'thisYear', 'nextYear', 'thisDay', $today, $yesterday, $activities, $thisYear, $nextYear, $thisDay);
        // });
    }
}
