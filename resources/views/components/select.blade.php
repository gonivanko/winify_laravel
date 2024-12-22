<div class="flex flex-col items-stretch text-start gap-2">
    <label for="{{$name}}">{{$label}}</label>
    <select name="{{$name}}" id="{{$id}}" class="flex items-center py-3 pr-3 pl-4 gap-2 border rounded-lg isolate">
        {{$slot}}
    </select>
</div>