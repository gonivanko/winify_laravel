@php
    $padding = $attributes->has('padding') ? $padding : "p-3";
    $style = "flex items-center justify-center $padding text-slate-800";
    if ($attributes->has('variant') && $variant === "primary") {
        $style = "flex items-center justify-center $padding bg-neutral-800 text-zinc-100 rounded-lg";
    }
@endphp

@if ($attributes->has('type') && ($type === "submit" || $type === "button"))
    <button class="{{$style}} {{$attributes->get('class')}}" type="{{$type}}" onclick="{{$attributes->get('onclick')}}">
        {{$slot}}
    </button>
@else
    <a href={{$href}} class="{{$style}} {{$attributes->get('class')}}">
        {{$slot}}
    </a>
@endif

