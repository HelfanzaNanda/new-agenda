<?php

namespace App\Http\Controllers\API\User;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User\UserResource;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
	{
		$credentials = $request->validate([
			'email' => 'required',
			'password' => 'required',
		]);

		if(Auth::attempt($credentials)){
			$auth = auth()->user();
			$auth->update([
				'is_login' => true,
				'api_token' => Str::random(60)
			]);
			return response()->json([
				'message' => 'berhasil login',
				'status' => true,
				'data' => new UserResource($auth)
			]);
		}else{
			return response()->json([
				'message' => 'masukkan email dan password yang benar',
				'status' => false,
				'data' => (object)[]
			]);
		}
	}

	public function logout(Request $request)
	{
		auth()->user()->update([
			'is_login' => false
		]);
		$this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
		return response()->json([
			'message' => 'berhasil logout',
			'status' => true,
			'data' => (object)[]
		]);

	}
}
