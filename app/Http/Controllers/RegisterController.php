<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{

    use ValidatesRequests; // Us


    public function showRegistrationForm()
    {
        return view('auth.register'); // Adjust the path to your registration view
    }

    public function register(Request $request)
    {
        // Validate the incoming request data
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // $user->sendEmailVerificationNotification();

        // Log the user in
        auth()->login($user);

        // Redirect to a desired page
      return redirect()->route('login')->with('success', 'Registration successful! Please login.');

    }
}