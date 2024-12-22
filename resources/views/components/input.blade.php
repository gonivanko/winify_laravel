@unless ($attributes->has('type'))
    $type = "text";
@endunless

@if ($type === "checkbox")

    <div class="flex items-center gap-2">
        <input type="{{$type}}" name="{{$name}}" id="{{$id}}" class="w-4 h-4 rounded">
        <label for="{{$id}}">{{$slot}}</label>
        @error($name)
                <p class="text-red-500 text-xs">{{$message}}</p>
        @enderror
    </div>

@elseif ($type === "textarea")

    <div class="flex flex-col items-stretch text-start gap-2 {{ $attributes->get('class') }}">
        <label for="{{$name}}">{{$label}}</label>
        <textarea 
            name="{{$name}}"
            id="{{$id}}"
            placeholder="{{$placeholder}}" 
            class="flex-1 flex items-center py-3 pr-3 pl-4 gap-2 border rounded-lg isolate"
        >{{$slot}}</textarea>
        @error($name)
                <p class="text-red-500 text-xs">{{$message}}</p>
        @enderror
    </div>

@else

    <div class="flex flex-col items-stretch text-start gap-2 {{ $attributes->get('class') }}">
        <label for="{{$id}}">{{$slot}}</label>
        <input 
            type="{{$type}}" 
            name="{{$name}}" 
            id="{{$id}}"
            @if (isset($value)) value="{{$value}}" @endif
            @if (isset($min) && $type === "number") min="{{$min}}" @endif
            {{-- @if (isset($step) && $type === "number") step="{{$step}}" @endif --}}
            class="flex items-center py-3 pr-3 pl-4 gap-2 border rounded-lg isolate">
        @error($name)
                <p class="text-red-500 text-xs">{{$message}}</p>
        @enderror
    </div>
    

@endif