<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register() {
        return view('users.register');
    }

    public function store(Request $request) {
        $formFields = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:6']
        ]);

        $formFields['password'] = bcrypt($formFields['password']);
        $user = User::create($formFields);

        Auth::login($user);
        return redirect('/')->with('message', 'User created and logged in successfully');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out');
    }

    public function login(Request $request) {
        return view('users.login');
    }

    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        // $formFields['password'] = bcrypt($formFields['password']);
        if (Auth::attempt($formFields)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'You have been logged in successfully');
        }
        else {
            return back()->withErrors([
                'email' => 'Invalid credentials'
            ]);
        }

        Auth::login($user);
        
    }

    public function show(User $user) {
        return view('users.profile', [
            'user' => $user
        ]);
    }

    public function edit(User $user) {

        if ($user->id != Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unathorized Action');
        }

        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user) {

        if ($user->id != Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unathorized Action');
        }

        $formFields = $request->validate([
            'name' => 'required',
            'password' => ['required', 'min:6']
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        $user->update($formFields);

        return back()->with('message', 'User updated successfully');
    }

    public function index() {
        $users = User::latest()->paginate(3);
        return view('users.index', ['users' => $users]);
    }

    public function delete(User $user) {

        if ($user->id != Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'Unathorized Action');
        }

        if ($user->is_admin) {
            abort(403, "Admins can't be deleted");
        }


        $user->delete();
        return back()->with('message', 'User deleted successfully');
    }

    // public function products(User $user) {
    //     return view('products.manage', [
    //         'products' => $user->products()->get()
    //     ]);
    // }
}

