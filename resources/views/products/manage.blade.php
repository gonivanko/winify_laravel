<x-layout items="items-stretch text-center sm:text-start">
    <div class="flex flex-col gap-2">
        <h2 class="font-semibold text-2xl">Manage Products</h2>
        <h4 class="text-xl text-neutral-500">Manage the products you are selling</h4>
    </div>
    <div class="flex flex-col items-stretch gap-6">
        @unless ($products->isEmpty())
        
        @foreach ($products as $product)
            
        <div class="flex flex-col sm:flex-row items-center p-6 gap-6 border rounded-lg">
            <img 
                src="{{$product->photo ? asset('storage/' . $product->photo) : asset('images/logo.png')}}" 
                class="h-40 w-40 object-cover"
            >
            <div class="flex-1 flex flex-col gap-4">
                <a href="{{url('/products/' . $product->id)}}" class="flex flex-col gap-2">
                    <h2 class="font-semibold text-lg">{{$product->title}}</h2>
                    @if ($product->current_bid)
                        <h1 class="font-semibold text-2xl">${{$product->current_bid}}</h1> 
                    @else
                        <h1 class="font-semibold text-2xl">Not sold</h1> 
                    @endif
                </a>
                <div class="flex flex-col md:flex-row items-center justify-center md:justify-start gap-4">

                    @switch($product->getStatus())
                        @case('on_auction')
                            <x-tag variant="green"><x-svg-icon type="time"/> On auction till {{$product->ending_datetime}}</x-tag>
                            @break
                        @case('future_auction')
                            <x-tag variant="purple"><x-svg-icon type="time"/>Auction starts on {{$product->starting_datetime}}</x-tag>
                            @break
                        @case('auction_ended')
                            @if ($product->current_bid && Auth::user()->is_admin)
                                <x-tag variant="green"><x-svg-icon type="time"/>Auction ended on {{$product->ending_datetime}}</x-tag>
                            @else
                                <x-tag variant="red"><x-svg-icon type="time"/>Auction ended on {{$product->ending_datetime}}</x-tag>
                            @endif
                            @break                            
                    @endswitch

                    @php
                        $mytime = Carbon\Carbon::now();
                    @endphp

                    @if ($mytime > $product->ending_datetime && $product->is_paid)
                        <x-tag variant="green"><x-svg-icon type="check"/>Paid</x-tag>
                    @endif

                    @if ($mytime > $product->ending_datetime && $product->is_received)
                        <x-tag variant="green"><x-svg-icon type="check"/>Received</x-tag>
                    @endif
                </div>
                <div class="flex items-center justify-center sm:justify-start gap-4">
                    @if ($mytime > $product->ending_datetime && $product->is_paid && !$product->is_received && Auth::user()->is_admin)
                    <form 
                        method="POST" 
                        action="{{url('/products' . '/' . $product->id . '/received')}}" 
                        class="flex items-center"
                    >
                        @csrf
                        <x-button type="submit" class="flex-1 gap-1 font-semibold">
                            <x-svg-icon type="received"/>
                            Mark as received
                        </x-button>
                    </form>
                    @endif
                    <x-button 
                        href="{{url('products/' . $product->id . '/edit')}}" 
                        {{-- href="{{url('/products/' . )}}" --}}
                        class="gap-1"
                    >
                        <x-svg-icon type="edit"/>
                        Edit
                    </x-button>
                    <form 
                        method="POST" 
                        action="{{url('/products' . '/' . $product->id)}}" 
                        class="flex"
                    >
                        @csrf
                        @method('DELETE')
                        <x-button type="submit" class="flex-1 gap-1 text-textRed">
                            <x-svg-icon type="delete"/>
                            Delete
                        </x-button>
                    </form>
                </div>
            </div>
        </div>

        @endforeach

        @else
        <div class="flex justify-center items-center">
            <h2 class="font-semibold text-2xl">You don't have products yet</h2>
        </div>
            


        @endunless
    </div>
</x-layout>





