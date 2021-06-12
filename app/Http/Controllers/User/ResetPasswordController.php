<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm($email, $token  = null)
    {
        return view('auth.passwords.reset', [
            'token' => $token, 
            'email' => $email
        ]);
    }

    protected function reset(Request $request)
    {
		$request->validate([
			'password' => 'required|min:8|confirmed'
		]);

		
		User::where('email', $request->email)->update([
			'password' => Hash::make($request->password),
		]);

        return redirect()->route('login')
        ->with('status', 'berhasil reset password, silahkan login kembali');
    }
}
