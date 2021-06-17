<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Traits\GetDisposisi;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	use GetDisposisi;
    public function showDisposisi()
	{
		$users = $this->getDisposisi();
		$res = [];
		foreach($users as $user){
			array_push($res, $user->load('roles'));
		}
		return response()->json([
			'message' => 'get users disposisi',
			'status' => true,
			'data' => UserResource::collection(collect($res))
		]);
	}
}
