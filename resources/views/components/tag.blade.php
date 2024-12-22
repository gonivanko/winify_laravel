@php
    $variantStyles = [
        'purple' => 'bg-backgroundPurple text-textPurple',
        'red' => 'bg-backgroundRed text-textRed',
        'green' => 'bg-backgroundGreen text-textGreen',
    ];

    $colorStyle = $attributes->has('variant') 
        ? $variantStyles[$attributes->get('variant')] ?? 'border' 
        : 'border';

    $font_weight = $attributes->has('weight') ? $weight : '';
@endphp

<div 
    class="flex items-center self-start p-2 rounded-lg gap-2 text-start {{$colorStyle}} {{$font_weight}}"
>
    {{$slot}}
</div>





