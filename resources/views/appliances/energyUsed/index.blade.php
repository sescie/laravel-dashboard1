<x-layout>
    <h1>energyUseds for appliance</h1>
    <ul>
        @foreach($energyUsed as $energyUsed)
            <li>{{ $energyUsed->created_at }}-{{$energyUsed->kw}}</li>
        @endforeach

    </ul> </x-layout>