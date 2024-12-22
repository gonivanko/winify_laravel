<x-layout items="items-stretch" gap="gap-6">
    <div class="flex flex-col gap-2">
        <h2 class="font-semibold text-2xl">Profile</h2>
        @if (Auth::id() === $user->id) <h4 class="text-xl text-neutral-500">Your profile page</h4>
        @else <h4 class="text-xl text-neutral-500">{{$user->name}}'s profile page</h4> @endif
    </div>
    <div class="flex flex-col items-center justify-evenly gap-6 p-6 border rounded-lg">
        <div class="flex flex-col items-center gap-4">
            <h2>Name</h2>
            <h1 class="font-semibold text-2xl">{{$user->name}}</h1>
        </div>
        
        <div class="flex flex-col items-center gap-4">
            <h2>Email</h2>
            <h1 class="font-semibold text-2xl">{{$user->email}}</h1>
        </div>
    </div>
        @if (Auth::id() === $user->id)
            <x-button href="{{url('/products/bids')}}" variant="primary">Bids</x-button>
            <x-button href="{{url('/products/manage')}}" variant="primary">Products</x-button>
            <x-button href="{{url('/users/' . $user->id . '/edit')}}" variant="primary">Edit profile</x-button>
        @endif
        @if (Auth::id() === $user->id || Auth::user()->is_admin)
            <form method="POST" action="{{url('/users/' . $user->id)}}" class="flex">
                @csrf
                @method('DELETE')
                <x-button type="submit" class="flex-1 gap-1 text-textRed">
                    <x-svg-icon type="delete"/>
                    Delete User
                </x-button>
            </form> 
        @endif 
</x-layout>