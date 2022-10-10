<?php

namespace App\Http\Controllers\Backstage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backstage\Campaigns\UpdateRequest;
use App\Models\Campaign;
use App\Models\Game;
use App\Models\Spin;
use Illuminate\Support\Facades\Storage;
use App\Services\Matrix;

class GameController extends Controller
{
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('backstage.games.index');
    }

    public function test(Matrix $matrix)
    {
        $result = $matrix->createMatrix(5,3);

        dump($matrix->calculatePoints($result));
        
        dd($result);
        
        return response($result);
    }

    public function generateMatrix(Matrix $matrix)
    {
        $result = $matrix->createMatrix(5,3);

        $point = $matrix->calculatePoints($result);

        if (session('point')){
            session(['point' => session('point')+$point['point']]);
        }
        else{
            session(['point' => $point['point']]);
        }

        Spin::create([
            'user_id'=>request()->user()->id,
            'spin'=>$result,
            'point'=>$point['point'],
            'campaign_id'=>session('activeCampaign')
        ]);

        return response([
            'matrix'=>$result,
            'point' => $point
        ]);
    }

    public function exportAsCsv()
    {
        $fileName = 'games.csv';

        $games = Game::with(['prize','campaign'])
        ->when(request()->criteria == 'account', function($query){
            $query->where('account', 'like', request()->search.'%');
        })
        ->when(request()->criteria == 'prize', function($query) {
            $query->where('prize_id', request()->search);
        })
        ->when(request()->criteria == 'hour_greater', function($query) {
            $query->whereRaw('HOUR(revealed_at) >= '.request()->search);
        })
        ->when(request()->criteria == 'hour_less', function($query) {
            $query->whereRaw('HOUR(revealed_at) <= '.request()->search);
        })->get();

        $headers = [
                 "Content-type"        => "text/csv",
                 "Content-Disposition" => "attachment; filename=$fileName",
                 "Pragma"              => "no-cache",
                 "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                 "Expires"             => "0"
             ];
     
        $columns = ['Account', 'Campaign', 'Prize', 'Weight', 'Title', 'REVEALED AT'];
     
        $callback = function() use($games, $columns) {
                 $file = fopen('php://output', 'w');
                 fputcsv($file, $columns);
     
                 foreach ($games as $task) {
                     $row['Account']  = $task->account;
                     $row['Campaign']  = $task->campaign->name;
                     $row['Prize']    = $task->prize->name;
                     $row['Weight']    = $task->prize->weight;
                     $row['Title']    = $task->title;
                     $row['REVEALED AT']  = $task->revealed_at;
     
                     fputcsv($file, array($row['Account'], $row['Campaign'], $row['Prize'], $row['Weight'], $row['Title'], $row['REVEALED AT']));
                 }
     
                 fclose($file);
             };
     
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Campaign $campaign
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Campaign $campaign
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
