@if (session()->has('message'))
    @php
        $color = session('message.color') ? session('message.color') : "Green";
        $color = ucfirst($color);
    @endphp

    <div 
        x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
        class="fixed top-0 left-1/2 mt-1 transform -translate-x-1/2 flex items-center p-4 gap-3 border rounded-lg bg-background{{$color}} text-text{{$color}}"
    >
        <div class="flex items-center gap-3">
            <x-svg-icon type="info" color="text{{$color}}"/>
            <div class="flex flex-col items-start gap-1">
                <h3 class="font-semibold">
                    {{session('message.text') ? session('message.text') : session('message')}}
                </h3>
            </div>
        </div>
    </div>
@endif