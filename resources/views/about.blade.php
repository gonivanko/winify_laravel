<x-layout justify="justify-center">
    <div class="flex flex-col gap-6">
        <h1 class="text-7xl font-bold">About Winify</h1>
        <p class="text-3xl text-gray-500">
            Created by @gonivanko
        </p>
    </div>
    <div class="flex justify-center gap-5">
        <x-button href="{{url('https://t.me/gonivanko')}}" variant="subtle"><img src="{{asset('icons/telegram.svg')}}" class="h-12"></x-button>
        <x-button href="{{url('https://github.com/gonivanko')}}" variant="subtle"><img src="{{asset('icons/github.svg')}}" class="h-12"></x-button>
        <x-button href="{{url('https://x.com/gonivanko')}}" variant="subtle"><img src="{{asset('icons/x.svg')}}" class="h-12"></x-button>
    </div>
</x-layout>