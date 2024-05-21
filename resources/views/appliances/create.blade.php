<x-layout>
    <div class="appliance-container">
        <div class="side-menu-headings">Fill In Details</div>
        <form class="create-appliances-form" action="{{ route('appliances.store') }}" method="POST" class="note">
            @csrf
            <div class="input-from">
                <label class="create-appliances-label" for="name">Name</label>
                <input class="create-appliances-label-form" type="text" name="name">
            </div>
            <div class="input-from">
                {{-- <label for="Top_Priority">name</label>
                <input type="text" name="Top_Priority"> --}}
                {{-- <label for="Port_Number">Port Number</label>
                <input type="number" name="name"> --}}
            </div>  
            <div class="app-actn-btns">
                <a href="{{ route('appliances.index',)}}" class="note-view-btn">cancel</a>
                <button class="add-aplnc-btn">Add Appliance</button>
            </div>
        </form>
    </div>
</x-layout>

