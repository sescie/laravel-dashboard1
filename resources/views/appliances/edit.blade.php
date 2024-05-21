<x-layout>
    <form action="{{ route('appliances.update') }}" method="POST" class="note">
        @csrf
        @method("PUT")
        <label for="name">name</label>
        <input type="text" name="name">
        {{-- <label for="Top_Priority">name</label>
        <input type="text" name="Top_Priority"> --}}
        <label for="Port_Number">Port_Number</label>
        <input type="number" name="name">
        <div class="note-actn-btns">
            <a href="{{ route('appliances.index',)}}" class="note-view-btn">cancel</a>
            <button>Update Appliance</button>
        </div>
    </form>
</x-layout>