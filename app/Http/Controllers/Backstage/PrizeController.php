<?php

namespace App\Http\Controllers\Backstage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backstage\Prizes\UpdateRequest;
use App\Models\Prize;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class PrizeController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backstage.prizes.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $prize = new Prize();
        // Return the view
        return view('backstage.prizes.create', compact('prize'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        // Validation
        $data = $this->validate(request(), [
            'name' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'sometimes',
            'weight' => 'required|numeric|between:0.01,99.99',
            'starts_at' => 'required|date_format:d-m-Y H:i:s',
            'ends_at' => 'required|date_format:d-m-Y H:i:s',
            'level' => 'required|in:low,med,high',
        ]);

        // Add the campaign id to the data array.
        $data['campaign_id'] = session('activeCampaign');

        // Create the prize
        Prize::create($data);

        // Redirect with success message
        session()->flash('success', 'The prize has been created!');

        return redirect('/backstage/prizes');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $prize = Prize::with('prizes')->where('id', $id)->first();
        //dd($prize);
        return view('backstage.prizes.show', [
            'prize' => $prize,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Prize $prize)
    {
        // Return the view
        return view('backstage.prizes.edit', compact('prize'));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Prize $prize
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Prize $prize)
    {
        // Validation
        $data = $this->validate(request(), [
            'title' => 'required|max:255',
            'weight' => 'required|numeric|between:0.01,99.99',
            'startsAt' => 'required|date_format:Y-m-d H:i:s',
            'endsAt' => 'required|date_format:Y-m-d H:i:s',
            'description' => 'sometimes',
            'level' => 'required|in:low,med,high',
        ]);

        // Add the currentPeriod to the data array.
        $data['campaign_id'] = session('currentCampaign');

        // Create the prize
        $prize->update($data);

        // Redirect with success message
        session()->flash('success', 'The prize has been updated!');

        return redirect('/backstage/prizes/'.$prize->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Prize $prize)
    {
        $prize->forceDelete();

        if (request()->ajax()) {
            return response()->json(['status' => 'success']);
        }

        session()->flash('success', 'The prize has been removed!');

        return redirect(route('backstage.prizes.index'));
    }
}
