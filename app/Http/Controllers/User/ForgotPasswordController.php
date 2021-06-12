<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    //use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
		$request->validate([
			'email' => 'required|email|exists:users',
		]);

		$token = Str::random(64);
		DB::table('password_resets')->insert(
			['email' => $request->email, 'token' => $token, 'created_at' => now()]
		);

		Mail::to($request->email)->send(new ForgotPasswordMail($request->email, $token));
		return back()->with('status', 'Silahkan cek email anda untuk reset password');
    }
}
