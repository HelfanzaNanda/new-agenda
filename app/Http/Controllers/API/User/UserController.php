<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showDisposisi()
	{
		$users = User::all();
		return response()->json([
			'message' => 'get users disposisi',
			'status' => true,
			'data' => $users
		]);
	}
}
