<x-layout>
    <div class="flex flex-col md:flex-row gap-16">
        <div class="flex-1">
            <img 
                src="{{$product->photo ? asset('storage/' . $product->photo) : asset('images/logo.png')}}"
            >
        </div>
        <div class="flex-1 flex flex-col text-start gap-4">
            <h2 class="text-2xl font-semibold">{{$product->title}}</h2>
            <div class="flex gap-4">
                @switch($product->condition)
                    @case('new')
                        <x-tag variant="green">New</x-tag>
                        @break
                    @case('used')
                        <x-tag variant="yellow">Used</x-tag>
                        @break
                    @default
                        
                @endswitch
                @switch($product->getStatus())
                @case('on_auction')
                    <x-tag variant="green"><x-svg-icon type="time"/> On auction till {{$product->ending_datetime}}</x-tag>
                    @break
                @case('future_auction')
                    <x-tag variant="purple"><x-svg-icon type="time"/>Auction starts on {{$product->starting_datetime}}</x-tag>
                    @break
                @case('auction_ended')
                    @if ($product->bidder_id === Auth::id())
                        <x-tag variant="green"><x-svg-icon type="check"/>Auction won {{$product->ending_datetime}}</x-tag>
                    @else
                        <x-tag variant="red"><x-svg-icon type="time"/>Auction ended on {{$product->ending_datetime}}</x-tag>
                    @endif
                    @break                    
            @endswitch
            
            </div>
            
            <div class="flex justify-between items-center">
                <div class="flex flex-row items-start">
                    <div class="text-2xl font-bold">$</div>
                    <div class="text-5xl font-bold">{{$product->current_bid ? $product->current_bid : $product->min_bid}}</div>
                </div>
                <div class="flex items-center gap-1"><x-svg-icon type="location"/><div>{{$product->location}}</div></div>
            </div>
            
            
            <p>{{$product->description}}</p>
            

            @if ($product->getStatus() === "on_auction")            
                <form method="POST" action="{{url('/products/' . $product->id . '/bid')}}" class="flex flex-col gap-6">
                    @csrf
                    <x-input 
                        type="number" 
                        name="bid" 
                        id="bid" 
                        min="{{$product->current_bid ? $product->current_bid + $product->bid_step : $product->min_bid}}" 
                        value="{{$product->current_bid ? $product->current_bid + $product->bid_step : $product->min_bid}}"
                    >Bid</x-input>
                    <x-button type="submit" variant="primary">Place Bid</x-button>
                </form>
            @endif
            @auth
                @if (($product->seller_id === Auth::id() || Auth::user()->is_admin) && ($product->getStatus() !== "auction_ended" || !$product->current_bid))
                    <x-button href="{{url('products/' . $product->id . '/edit')}}" class="gap-1">
                        <x-svg-icon type="edit"/>
                        Edit
                    </x-button>
                    <form method="POST" action="{{url('/products' . '/' . $product->id)}}" class="flex">
                        @csrf
                        @method('DELETE')
                        <x-button type="submit" class="flex-1 gap-1 text-textRed">
                            <x-svg-icon type="delete"/>
                            Delete
                        </x-button>
                    </form> 
                @endif
            @endauth
            
            

        </div>
    </div>
</x-layout>



