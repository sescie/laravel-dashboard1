<?php

namespace App\Http\Controllers;

use App\Models\energyUsed;
use App\Models\Appliance;
use App\Http\Requests\StoreenergyUsedRequest;
use App\Http\Requests\UpdateenergyUsedRequest;

class EnergyUsedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $energyUsed = energyUsed::all()->orderBy('created_at', 'desc')->paginate(10);
        return view('appliances.energyUsed.index', ['energyUsed'=> $energyUsed]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getUsagebyAppliance(energyUsed $energyUsed, Appliance $appliance)
    {
        return view("appliances.energyUsed.show", ["energyUsed"=> $energyUsed, "appliance"=> $appliance->id]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreenergyUsedRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function showUsageByDay(energyUsed $energyUsed)
    {
        // for every 24 rows, sum up the KW column of the energy used table
    }

    public function showUsageByWeek(energyUsed $energyUsed)
    {
        // for every 24*7 rows, sum up the KW column of the energy used table
    }
    public function showUsageByMonth(energyUsed $energyUsed){
            // for every 24*7*4 rows, sum up the KW column of the energy used table

    }
    public function showUsageByPrevDay(energyUsed $energyUsed){
            // for every 24*7*4 rows, sum up the KW column of the energy used table

    }
    public function showUsageByPrevWeek(energyUsed $energyUsed){
            // for every 24*7*4 rows, sum up the KW column of the energy used table

    }
    public function edit(energyUsed $energyUsed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateenergyUsedRequest $request, energyUsed $energyUsed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(energyUsed $energyUsed)
    {
        //
    }
}
