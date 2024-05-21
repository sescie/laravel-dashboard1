<?php

namespace App\Http\Controllers;

use App\Models\Appliance;
use App\Http\Requests\StoreApplianceRequest;
use App\Http\Requests\UpdateApplianceRequest;

class ApplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appliances = Appliance::all();
        return view("appliances.index", ["appliances"=> $appliances]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("appliances.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplianceRequest $request)
    {
        $data = $request->validate([
            "name"=> ["required","string"],
            "Top_Priority"=> ["required","boolean"],
        ]);
        $appliance = Appliance::create($data);
        return to_route('appliances.show', $appliance)->with('Message','appliance Was Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appliance $appliance)
    {
        return view("appliances.show", ['appliance'=>$appliance]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appliance $appliance)
    {
        return view("appliances.edit", ["appliance"=>$appliance]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplianceRequest $request, Appliance $appliance)
    {
        $data = $request->validate([
            "name"=> ["string"],
            "Top_Priority"=> ["boolean"],
                ]);

        if($request->has('turnOn')){
            $appliance->Running=true;
        }
        elseif($request->has("turnOff")){
            $appliance->Running=false;
        }
        $appliance->update($data);
        return to_route('appliances.index')->with('Message','appliance Was Created');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appliance $appliance)
    {
        $appliance->delete();
        return to_route('appliances.index')->with('Message','Note Was Deleted');
    }
    public function turnOnAppliance(UpdateApplianceRequest $request, Appliance $appliance){
        $appliance->Running = true;
        $appliance->save();
        return to_route('appliances.show', $appliance)->with('Message','appliance Was updated');


    }
    public function turnOffAppliance(UpdateApplianceRequest $request, Appliance $appliance){
        $data = $request->validate([
            "name"=> ["string"],
            "Top_Priority"=> ["boolean"],
                ]);
        $appliance = Appliance::update($data);
        return to_route('appliances.show', $appliance)->with('Message','appliance Was Created');
    }
    public function setNoPriority(Appliance $appliance){
        $appliance->Top_Priority = false;
    }
    public function setPriority(Appliance $appliance){
        $appliance->Top_Priority = true;
    }
}
