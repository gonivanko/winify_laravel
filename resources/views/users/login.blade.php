<x-layout items="items-center" justify="justify-center">
    <form 
        action="{{url('/users/authenticate')}}" method="POST" class="flex flex-col gap-6 p-6 border rounded-lg"
    >
        @csrf
        <x-input type="email" name="email" id="email" value="{{old('email')}}">Email</x-input>
        <x-input type="password" name="password" id="password" value="{{old('password')}}">Password</x-input>
        <x-button type="submit" variant="primary">Log In</x-button>
    </form>
    <x-button href="{{url('/register')}}">Don't have an account yet? Register here!</x-button>
</x-layout>