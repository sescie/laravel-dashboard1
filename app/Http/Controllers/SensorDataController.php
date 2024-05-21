<?php

namespace App\Http\Controllers;

use App\Models\sensorData;
use App\Http\Requests\StoresensorDataRequest;
use App\Http\Requests\UpdatesensorDataRequest;

class SensorDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sensors = SensorData::all()->orderBy('created_at', 'desc')->paginate(10);
        return view("sensors.index", ["sensors"=> $sensors]);
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
    public function store(StoresensorDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(sensorData $sensorData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sensorData $sensorData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesensorDataRequest $request, sensorData $sensorData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sensorData $sensorData)
    {
        //
    }
}
