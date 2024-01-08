<?php

namespace App\Http\Controllers;

use App\Helpers\RestAPIFormatter;
use App\Models\MataPelajaran;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class MapelController extends Controller
{

    public function quizQuestions($id)
    {
        $data = new Collection();
        $questions = DB::table('questions')
            ->where('kuis_id', $id)
            ->get();
        $kuis = DB::table('kuis')->where('id', $id)->first();
        foreach ($questions as $ms) {
            $true = DB::table('options')->selectRaw('option_text')->where('question_id', $ms->id)->where('status', 'true')->value('option_text');
            $false = DB::table('options')->where('question_id', $ms->id)->where('status', 'false')->pluck('option_text');
            $data->push([
                'type' => "multiple",
                'difficulty' => "medium",
                "category" => $kuis->nama_kuis,
                "question" => $ms->question_text,
                'correct_answer' => $true,
                'false_answer' => $false,
            ]);
        }
        if ($data) {
            return RestAPIFormatter::createAPI(200, 'Success', $data);
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mapel = MataPelajaran::all();

        if ($mapel) {
            return RestAPIFormatter::createAPI(200, 'Success', $mapel);
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            $mapel = MataPelajaran::create([
                'name' => $request->name,
            ]);

            $data = MataPelajaran::where('id', '=', $mapel->id)->get();

            if ($data) {
                return RestAPIFormatter::createAPI(200, 'Success', $data);
            } else {
                return RestAPIFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $error) {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MataPelajaran::where('id', '=', $id)->get();

        if ($data) {
            return RestAPIFormatter::createAPI(200, 'Success', $data);
        } else {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $mapel = MataPelajaran::findOrFail($id);

            $mapel->update([
                'name' => $request->name,
            ]);

            $data = MataPelajaran::where('id', '=', $mapel->id)->get();

            if ($data) {
                return RestAPIFormatter::createAPI(200, 'Success', $data);
            } else {
                return RestAPIFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $error) {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $mapel = MataPelajaran::findOrFail($id);

            $data = $mapel->delete();

            if ($data) {
                return RestAPIFormatter::createAPI(200, 'Success Delete Data');
            } else {
                return RestAPIFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $error) {
            return RestAPIFormatter::createAPI(400, 'Failed');
        }
    }
}
