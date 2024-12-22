<x-layout items="items-center">
    <form method="POST" action="{{url('/users/' . $user->id)}}" class="flex flex-col gap-6 p-6 border rounded-lg">
        @csrf
        @method('PUT')
        <x-input type="text" name="name" id="name" value="{{$user->name}}">Name</x-input>
        {{-- <x-input type="email" name="email" id="email" value="{{$user->email}}">Email</x-input> --}}
        <x-input type="password" name="password" id="password">Password</x-input>
        <x-button type="submit" variant="primary">Save changes</x-button>
    </form>
</x-layout>

