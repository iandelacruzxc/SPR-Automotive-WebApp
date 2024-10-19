<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Ensure you have a User model

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login'); // Adjust if your login view is in a different path
    }
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Check if the user's email is verified
            if (Auth::user()->email_verified_at === null) {
                Auth::logout(); // Log out the user if not verified
                return back()->withErrors([
                    'email' => 'Your email is not verified. Please check your inbox for the verification link.',
                ]);
            }

            // If the email is verified, regenerate the session and redirect based on role
            $request->session()->regenerate();

            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('dashboard'); // Change to your admin route
            } else {
                return redirect()->route('user.dashboard'); // Correct usage
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }


    public function verifyEmail(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Check if the email is already verified
        if ($user->email_verified_at) {
            // If already verified, return a 404 response
            abort(403, 'This account has already been activated.');
        }

        // Check if the hash matches
        if (!hash_equals(sha1($user->email), $request->hash)) {
            return redirect('/')->withErrors(['message' => 'Invalid verification link.']);
        }

        // Verify the email
        $user->email_verified_at = now();
        $user->save();

        // Redirect with a success message
        return redirect('/login ')->with('message', 'Email verified successfully!');
    }



    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
