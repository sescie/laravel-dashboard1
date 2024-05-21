<?php

namespace App\Http\Controllers;
use Phec\Pickle\Pickle;
use Illuminate\Http\Request;
use App\Models\energyUsed;
use App\Models\EnergyPred;
use PhpMl\PhpMlModel;
class PredictionController extends Controller
{
    public function index()
    {
        $predictions = EnergyPred::orderBy('id', 'desc')->limit(24)->get();
        $actual = energyUsed::orderBy('id', 'desc')->limit(24)->get();
        return view("predictions.index", ["predictions"=> $predictions, 'actual'=>$actual]);
    }
}