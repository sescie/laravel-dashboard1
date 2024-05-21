<x-layout>
    <div class="main-appliance-container">
        <div class="main-appliance-body">
            <h3>{{$appliance->created_at}}</h3>
            <div class="appliance-actn-btns">
                <a href="{{ route('appliances.edit', $appliance)}}" class="appliance-view-btn">Edit</a>
                <form action="{{route ('appliances.destroy', $appliance)}}" method="POST">
                    @csrf
                    @method("DELETE")
                    <button>Delete</button>
                </form>
            </div>
            <div class="full-appliance">
                {{ $appliance }}
            </div>
        </div>
    </div>
</x-layout>