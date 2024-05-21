<x-layout>
    <div class="appliance-container">
        <div class="side-menu-headings">Appliances Management</div>
         <a href="{{ route('appliances.create')}}" class="new-appliance-btn">New appliance</a>
         {{-- <a href="{{ route('appliances.energyUsed.index')}}">View Total Energy Used</a> --}}
         @foreach ($appliances as $appliance)
             <div class="appliances">
                 <div class="appliance-name">
                     {{ $appliance->name }}
                     @if ($appliance->Running == 0)
                     <form action="{{route ('appliances.update', $appliance)}}" method="POST">
                        @csrf
                        @method("PUT")
                        <input type="hidden" name="turnOn" value="1">
                        <button class="appliance-on-btn">Turn On Appliance</button>
                    </form>
                    @else
                    <form action="{{route ('appliances.update', $appliance)}}" method="POST">
                        @csrf
                        @method("PUT")
                        <input type="hidden" name="turnOff" value="0">
                        <button class="appliance-off-btn">Turn Off Appliance</button>
                    </form>
                     @endif
                     
                    
                 </div>
                 
                 <div class="appliance-actn-btns">
                     <a href="{{ route('appliances.show', $appliance)}}" class="appliance-view-btn">View Details</a>
                     {{-- <a href="{{ route('appliances.energyUsed.index', $appliance->id) }}">Energy Used</a> --}}
                     <a href="{{ route('appliances.edit', $appliance)}}" class="appliance-view-btn">Edit</a>
                     <form action="{{route ('appliances.destroy', $appliance)}}" method="POST">
                         @csrf
                         @method("DELETE")
                         <button class="appliance-btn">Delete Appliance</button>
                     </form>
                    </form>
                 </div>
             </div>
         @endforeach      
    </div>
 
 </x-layout>