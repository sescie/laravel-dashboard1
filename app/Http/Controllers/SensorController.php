<?php

namespace App\Http\Controllers;

use App\Models\sensor;
use App\Http\Requests\StoresensorRequest;
use App\Http\Requests\UpdatesensorRequest;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sensors = Sensor::all();
        return view("sensors.index", ["sensors"=> $sensors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoresensorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(sensor $sensor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sensor $sensor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesensorRequest $request, sensor $sensor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sensor $sensor)
    {
        //
    }
}
