<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\RegistersUsers;
// use App\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use App\Mail\VerifyEmail;


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

        Mail::to($user->email)->send(new VerifyEmail($user));


        $user->assignRole('user'); // Default role for all registered users
        // Log the user in
        // auth()->login($user);

        // Redirect to a desired page
        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    protected function sendVerificationEmail($user)
    {
        // Generate a signed URL with a limited expiration time (e.g., 60 minutes)
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $user->id]
        );

        // Send the verification email
        Mail::send('emails.verify-email', ['url' => $verificationUrl], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Email Verification');
        });
    }



    public function create()
    {
        // Return the admin registration view
        return view('auth.admin-register');
    }

    public function registerAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);

        $user->assignRole('admin'); // Default role for all registered users

        Mail::to($user->email)->send(new VerifyEmail($user));

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }



    public function regformStaff()
    {
        return view('auth.staff-register');
    }


    public function registerstaff(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            // 'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);

        $user->assignRole('staff'); // Default role for all registered users

        Mail::to($user->email)->send(new VerifyEmail($user));

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
}
