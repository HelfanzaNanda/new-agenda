<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{
    public function index()
	{
		return view('update_password.index');
	}

	public function update(Request $request)
	{
		$request->validate([
			'password' => 'required|min:8|confirmed'
		]);

		auth()->user()->update([
			'password' => Hash::make($request->password)
		]);

		return response()->json([
			'message' => 'berhasil update password'
		]);
	}
}
