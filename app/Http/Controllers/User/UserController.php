<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
	{
		$roles = Role::all();
		return view('user.index', [
			'roles' => $roles
		]);
	}

	public function get($id)
	{
		$user = User::whereId($id)->first();
		$role = $user->roles->pluck('name');
		return [
			'user' => $user,
			'role' => $role,
		];
	}

	public function createOrUpdate(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'email' => 'required|email|unique:users,email,'.$request->id,
			'role' => 'required'
		]);

		$user = User::updateOrCreate(['id' => $request->id], [
			'name' => $request->name,
			'email' => $request->email,
			'password' => Hash::make($request->password ?? 'password')
		]);

		$user->syncRoles($request->role);

		return response()->json([
			'message' => 'berhasil menambahkan data'
		]);
	}

	public function datatables(Request $request)
	{
		$users = User::all();
        $datatables = datatables($users)
		->addIndexColumn()
        ->addColumn('_buttons', function($row){
            $btn = '<a data-id="'.$row->id.'" class="btn-edit btn btn-sm btn-warning mr-2"><i class="fa fa-edit"></i></a>';
            $btn .= '<a data-id="'.$row->id.'" class="btn-delete btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
            return $btn;
        })
        ->rawColumns(['_buttons']);
        return $datatables->toJson();
	}

	public function delete($id)
	{
		$user = User::whereId($id)->first();
		$user->roles()->detach();
		$user->forgetCachedPermissions();
		$user->delete();

		return response()->json([
			'message' => 'berhasil delete data'
		]);
	}
}
