<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Appliance;
use App\Models\EnergyUsed;
use App\Models\EnergyPred;

class Dashboard extends Controller
{
    public function index()
    {
        $appliances = Appliance::all();
        $energyUsed = EnergyUsed::orderBy('id', 'desc')->limit(1)->get();
        $energyUsedTotal = EnergyUsed::orderBy('id', 'desc')->get();

        $last24 = EnergyUsed::orderBy('id', 'desc')->limit(24)->get()->sum('KW');
        $averageDaily = $last24 / 24;
        $currentUsage = $energyUsed->first()->KW;
        
        // Group data by 24 rows per day
        $dayGraphData = EnergyUsed::orderBy('id', 'desc')->limit(24 * 7)->get()->chunk(24);

        $deviations = (($currentUsage - $averageDaily) / $averageDaily) * 100;
        $lastWeek = EnergyUsed::orderBy('id', 'desc')->limit(168)->get()->sum('KW');
        $lastMonth = EnergyUsed::orderBy('id', 'desc')->limit(24 * 30)->get()->sum('KW');

        return view("dashboard", [
            'energyUsed' => $energyUsed,
            'last24' => $last24,
            'lastWeek' => $lastWeek,
            'lastMonth' => $lastMonth,
            'deviations' => $deviations,
            'averageDaily' => $averageDaily,
            'dayGraphData' => $dayGraphData,
            'energyUsedTotal' => $energyUsedTotal
        ]);
    }
}
