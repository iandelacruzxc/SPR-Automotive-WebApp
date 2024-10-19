<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{



    use VerifiesEmails; // Include the VerifiesEmails trait
    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request, $id)
    {
        // Check if the link is valid and not expired
        if (!$request->hasValidSignature()) {
            return redirect()->route('login')->withErrors('The verification link is invalid or expired.');
        }

        // Find the user by ID
        $user = User::findOrFail($id);

        // If the user has already verified their email
        if ($user->email_verified_at) {
            return redirect()->route('login')->with('status', 'Your email is already verified.');
        }

        // Verify the user's email
        $user->email_verified_at = now();
        $user->save();

        // Redirect to the login page with success message
        return redirect()->route('login')->with('status', 'Your email has been successfully verified.');
    }

    public function resend(Request $request)
    {
        // Resend verification email to the user
        $user = Auth::user();
        if ($user->email_verified_at) {
            return redirect()->route('dashboard')->with('status', 'Your email is already verified.');
        }

        $this->sendVerificationEmail($user);

        return back()->with('status', 'Verification email resent.');
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
}
