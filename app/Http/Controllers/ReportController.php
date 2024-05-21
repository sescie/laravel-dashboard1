<?php

namespace App\Http\Controllers;

use App\Models\Appliance;
use App\Models\EnergyUsed;
use App\Models\EnergyPred;
use App\Models\Report;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch energy usage data for the last 7 days
        $energyUsageData = EnergyUsed::orderBy('id', 'desc')
            ->limit(24 * 7) // 24 rows for each of the last 7 days
            ->pluck('KW') // Pluck KW value from each row
            ->toArray();
    
        // Fetch predicted energy usage data for the last 7 days (similar approach as energy usage)
        $predictedUsageData = EnergyPred::orderBy('id', 'desc')
            ->limit(24 * 7) // 24 rows for each of the last 7 days
            ->pluck('KW') // Pluck KW value from each row
            ->toArray();
    
        // Fetch peak usage data for the last 7 days (maximum energy usage within each hour)
        $peakUsageData = EnergyUsed::orderBy('KW', 'desc')
            ->limit(24 * 7) // 24 rows for each of the last 7 days
            ->pluck('KW') // Pluck KW value from each row
            ->toArray();
    
        // Get total energy usage for the last week
        $lastWeekUsage = EnergyUsed::orderBy('id', 'desc')
            ->limit(24 * 7) // 24 rows for each of the last 7 days
            ->sum('KW'); // Sum the KW for the last 7 days
    
        // Calculate the current week number
        $weekNumber = ceil(EnergyUsed::count() / (24 * 7)); // Assuming each row represents an hour
        // Fetch the latest 5 reports
        $reports = Report::orderBy('created_at', 'desc')->paginate(5);
    
        return view('reports.index', [
            'reports' => $reports,
            'weekNumber' => $weekNumber,
            'lastWeekUsage' => $lastWeekUsage,
            'energyUsageData' => $energyUsageData,
            'predictedUsageData' => $predictedUsageData,
            'peakUsageData' => $peakUsageData,
        ]);
    }
    


    // Other methods remain unchange

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not needed for now
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        // Sum up the energy usage and predictions for the week
        $energyUsedPerWeek = EnergyUsed::latest()->limit(168)->sum('KW');
        $energyPredPerWeek = EnergyPred::latest()->limit(168)->sum('KW');
        
        // Calculate the difference
        $difference = $energyUsedPerWeek - $energyPredPerWeek;

        // Define the report period (using row numbers instead of dates)
        $startDate = EnergyUsed::latest()->skip(167)->first()->id; // Assuming the id represents the hour
        $endDate = EnergyUsed::latest()->first()->id;

        // Store the report
        Report::create([
            'energy_used' => $energyUsedPerWeek,
            'energy_pred' => $energyPredPerWeek,
            'difference' => $difference,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return redirect()->route('reports.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return view('reports.show', ['report' => $report]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        // Not needed for now
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportRequest $request, Report $report)
    {
        // Not needed for now
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        // Not needed for now
    }

    public function download(Report $report)
    {
        // Implementation for downloading the report
    }
}
