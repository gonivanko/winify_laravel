<x-layout items="items-center">
    <form method="POST" action="{{url('/users')}}" class="flex flex-col gap-6 p-6 border rounded-lg">
        @csrf
        <x-input type="text" name="name" id="name" value="{{old('name')}}">Name</x-input>
        <x-input type="email" name="email" id="email" value="{{old('email')}}">Email</x-input>
        <x-input type="password" name="password" id="password">Password</x-input>
        <x-button type="submit" variant="primary">Register</x-button>
    </form>
    <x-button href="{{url('/login')}}">Already have an account? Log in here!</x-button>
</x-layout>

