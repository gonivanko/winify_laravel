@php
    function getSelected($filtersArray, $filterName, $optionValue) {
        if (isset($filtersArray[$filterName]) && $filtersArray[$filterName] === $optionValue) {
            return "selected";
        }
    }
    function getValue($filtersArray, $filterName, $default) {
        if (isset($filtersArray[$filterName])) 
            return $filtersArray[$filterName];
        else 
            return $default;
    }
@endphp

<x-layout>
    <form method="GET" action="{{url('/')}}" class="flex lg:flex-row flex-col lg:items-stretch gap-16">
        <div class="flex flex-col  border rounded-lg p-4 gap-6">
            <x-input 
                type="number" name="current_min_bid" id="current_min_bid" min="0" value="{{getValue($filters, 'current_min_bid', '0')}}"
            >Current min bid: </x-input>
            <x-input 
                type="number" name="current_max_bid" id="current_max_bid" min="0" value="{{getValue($filters, 'current_max_bid', '')}}"
            >Current max bid: </x-input>

            <x-select type="select" id="auction_status" name="auction_status" label="Status" value="{{old('condition')}}">
                <option value="">All</option>
                <option value="on_auction" {{getSelected($filters, 'auction_status', 'on_auction')}}>On auction</option>
                <option value="future_auction" {{getSelected($filters, 'auction_status', 'future_auction')}}>Future auction</option>
                <option value="auction_ended" {{getSelected($filters, 'auction_status', 'auction_ended')}}>Auction ended</option>
            </x-select>
            
            <x-select type="select" id="condition" name="condition" label="Condition" value="{{old('condition')}}">
                <option value="">All</option>
                <option value="new" {{getSelected($filters, 'condition', 'new')}}>New</option>
                <option value="used" {{getSelected($filters, 'condition', 'used')}}>Used</option>
            </x-select>
            <x-button type="submit" variant="primary">Show</x-button>
        </div>
        
        <div class="flex-1 flex flex-col gap-5">
            <x-search></x-search>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">

                @unless (count($products) === 0)
                    @foreach ($products as $product)
                        <x-product :product="$product"></x-product>
                    @endforeach
                @else
                    <p class="col-span-1 sm:col-span-2 md:col-span-3">No products found</p>
                @endunless

            </div>
            <div class="mt-6 p-4">
                {{$products->links()}}
            </div>
        </div>

    </form>
    
</x-layout>