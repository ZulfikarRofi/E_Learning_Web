<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\Users;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    public function getPengguna()
    {
        $guru = Guru::all();
        $murid = Siswa::all();
        $admin = Admin::all();

        foreach($guru as $g)
        {
            $data = DB::table('guru')->join('mapel', 'mapel.guru_id', '=', 'guru.id')->get();

        }

        // dd($data);

        return view('pages.pengguna', compact('guru', 'murid', 'admin'));
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required',
            'nip' => 'required',
            'email' => 'required|email:unique',
            'jabatan' => 'required',
            'jenis_kelamin' => 'required',
            'ttl' => 'required',
        ]);

        $model = new Guru();
        $model->nama_guru = $request->nama_guru;
        $model->nip = $request->nip;
        $model->email = $request->email;
        $model->jabatan = $request->jabatan;
        $model->ttl = $request->ttl;
        $model->jenis_kelamin = $request->jenis_kelamin;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $photo_name = time() . str_replace(" ", "", $file->getClientOriginalName());
            $file->move('photo', $photo_name);
            $model->photo = $photo_name;
        }
        // dd($model);
        $model->save();

        return redirect('/pengguna')->with('success', 'Data guru baru berhasil ditambahkan');
    }
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'admin_id' => 'required',
            'email' => 'required|email:unique',
            'level' => 'required'
        ]);

        $model = new Admin();
        $model->name = $request->name;
        $model->admin_id = $request->admin_id;
        $model->email = $request->email;
        $model->level = $request->level;
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $photo_name = time() . str_replace(" ", "", $file->getClientOriginalName());
            $file->move('photo', $photo_name);
            $model->photo = $photo_name;
        }
        // dd($model);
        $model->save();

        return redirect('/pengguna')->with('success', 'Data admin baru berhasil ditambahkan');
    }
}
