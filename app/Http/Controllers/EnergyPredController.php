<?php

namespace App\Http\Controllers;
use App\Models\energyUsed;
use App\Models\energyPred;
use App\Http\Requests\StoreenergyPredRequest;
use App\Http\Requests\UpdateenergyPredRequest;

class EnergyPredController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $energypred = energyPred::all();
        $energyUsed = energyPred::all()->orderBy('created_at', 'desc')->paginate(10);
        return view('energyconsumption.index', ['energyUsed'=> $energyUsed, 'energyPred'=> $energypred]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreenergyPredRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(energyPred $energyPred)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(energyPred $energyPred)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateenergyPredRequest $request, energyPred $energyPred)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(energyPred $energyPred)
    {
        //
    }
}
