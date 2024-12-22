<div
    {{-- action="{{url('/')}}" 
    method="GET"  --}}
    class="flex items-center gap-2 border rounded-full py-3 px-4"
>
    <input 
        type="search" 
        placeholder="Search" 
        name="search"
        class="flex-1 text-neutral-400 font-normal text-base"
    >
    <button type="submit" class="flex items-center"><img src="{{asset('icons/search.svg')}}" class="w-4 h-4"></button>
</div>