<x-layout>
    <div class="report-container">
        <div class="report-head">
            <h3>Weekly Report ({{ $report->start_date->format('d M') }} - {{ $report->end_date->format('d M Y') }})</h3>
            <div class="report-scope">From {{ $report->start_date->format('d M Y') }} to {{ $report->end_date->format('d M Y') }}</div>
        </div>

        <div class="profit-or-loss-container">
            <p>You have used {{ $report->difference > 0 ? 'more' : 'less' }} energy compared to the predicted usage by {{ abs($report->difference) }} KW.</p>
        </div>

        <div class="graphs-section">
            <div class="daily-usage-container">
                <div class="graph-header">
                    <h3>{{ round(array_sum($energyUsage) / 7, 2) }} KW</h3>
                    <h5>Daily Average Usage</h5>
                </div>
                <div class="daily-usage-graph">
                    <!-- Graph for daily usage goes here -->
                </div>
            </div>
            <div class="peak-usage-map-container">
                <div class="graph-header">
                    <h3>{{ max($energyUsage) }} KW</h3>
                    <h5>Peak Usage Times</h5>
                </div>
                <div class="peak-usage-map">
                    <!-- Heat map for peak usage times goes here -->
                </div>
            </div>
        </div>

        <div class="daily-usage-container">
            <div class="graph-header">
                <h3>{{ round($report->energy_pred / 7, 2) }} KW</h3>
                <h5>Predicted Daily Average Usage</h5>
            </div>
            <div class="daily-usage-graph">
                <!-- Graph for predicted daily usage goes here -->
            </div>
        </div>

        <div class="most-used-appliances-container">
            <h2>Most Used Appliances</h2>
            @foreach($appliances as $appliance)
                <div class="appliance">
                    <strong>{{ $appliance->name }}</strong>: 
                    {{ $appliance->energyUsed->sum('KW') }} KW
                </div>
            @endforeach
        </div>
    </div>
</x-layout>
