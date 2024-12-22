<x-layout items="items-stretch text-center sm:text-start">
    <div class="flex flex-col gap-2">
        <h2 class="font-semibold text-2xl">Manage Users</h2>
        <h4 class="text-xl text-neutral-500">Manage All Users</h4>
    </div>
    <div class="flex flex-col items-stretch gap-6">
        {{-- @unless ($users->isEmpty()) --}}
        
        @foreach ($users as $user)
            
        <div class="flex flex-col sm:flex-row items-center p-6 gap-6 border rounded-lg">
            <div class="flex-1 flex flex-col gap-4">
                <a href="{{url('/users/' . $user->id)}}" class="flex flex-col gap-2">
                    <h2 class="font-semibold text-2xl">{{$user->name}}</h2>
                    <h1>{{$user->email}}</h1>                    
                </a>
                
                <div class="flex items-center justify-center sm:justify-start gap-4" padding=>
                    @if (Auth::id() === $user->id || Auth::user()->is_admin)
                        <form method="POST" action="{{url('/users/' . $user->id)}}" class="flex">
                            @csrf
                            @method('DELETE')
                            <x-button type="submit" class="flex-1 gap-1 text-textRed" padding="px-0 py-3">
                                <x-svg-icon type="delete"/>
                                Delete User
                            </x-button>
                        </form> 
                    @endif 
                </div>
                
            </div>
        </div>

        @endforeach

        {{-- @else

        <div class="flex justify-center items-center">
            <h2 class="font-semibold text-2xl">You don't have products yet</h2>
        </div>

        @endunless --}}
        <div>
            {{$users->links()}}
        </div>
    </div>
</x-layout>