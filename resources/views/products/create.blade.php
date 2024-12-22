<x-layout>
    <form 
        method="POST" 
        action="{{url('/products')}}" 
        class="
            flex-1 grid grid-cols-1 sm:grid-cols-2 md:grid-col-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 grid-flow-row-dense
        "
        enctype="multipart/form-data"
    >
        @csrf
        
        <x-input 
            type="text" name="title" id="title" value="{{old('title')}}" 
            class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4 xl:col-span-3 row-span-1"
        >
            Title
        </x-input>

        <x-input 
            type="textarea" 
            name="description" 
            id="description" 
            placeholder="Enter Description..." 
            label="Description" 
            class="col-span-1 row-span-2 sm:col-span-2 md:col-span-3 lg:col-span-4 xl:col-span-3 xl:row-span-4"
        > {{old('description')}}   </x-input>
        
        <x-input type="number" name="min_bid" id="min_bid" value="{{old('min_bid')}}">Min Bid</x-input>
        <x-input type="number" name="bid_step" id="bid_step" value="{{old('bid_step')}}">Bid Step</x-input>
        <x-input type="text" name="location" id="location" value="{{old('location')}}">Location</x-input>
        <x-select name="condition" id="condition" label="Condition" value="{{old('condition')}}">
            <option value="new">New</option>
            <option value="used">Used</option>
        </x-select>
        
        
        <x-input type="datetime-local" name="starting_datetime" id="starting_datetime" value="{{old('starting_datetime')}}">Auction start</x-input>
        <x-input type="datetime-local" name="ending_datetime" id="ending_datetime" value="{{old('ending_datetime')}}">Auction end</x-input>
        <x-input type="file" name="photo" id="photo" class="sm:col-span-3 md:col-span-2">Photo</x-input>
        <img 
            class="sm:col-span-2 md:col-span-3 lg:col-span-1 xl:col-span-2"
            id="photo-preview"
        >
        <x-button 
            type="submit" variant="primary" class="sm:col-span-2 md:col-span-3 lg:col-span-4 xl:col-span-5"
        >Place Product</x-button>
    </form>

    <script src="{{asset('js/previewPhoto.js')}}"></script>

</x-layout>