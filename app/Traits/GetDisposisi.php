<?php

namespace App\Traits;

use App\User;
use Carbon\Carbon;

trait GetDisposisi {
	public function getDisposisi()
	{
		$users = User::with('roles')->where('is_login', true)->get();
		$disposisi = $users->filter(function($user){
			if(auth()->user()->hasRole('super admin')){
				return !$user->hasRole('super admin');
			}elseif(auth()->user()->hasRole('admin')){
				return !$user->hasRole(['super admin', 'admin']);
			}elseif(auth()->user()->hasRole('sekretaris')){
				return !$user->hasRole(['super admin', 'admin', 'sekretaris']);
			}elseif(auth()->user()->hasRole('deputi(Eselon I)')){
				return !$user->hasRole(['super admin', 'admin', 'sekretaris', 'deputi(Eselon I)']);
			}elseif(auth()->user()->hasRole('asdep/karo(eselon II)')){
				return !$user->hasRole(['super admin', 'admin', 'sekretaris', 'deputi(Eselon I)', 'asdep/karo(eselon II)']);
			}
		});
		// $disposisi = $users->reject(function($user){
		// 	if(auth()->user()->hasRole('super admin')){
		// 		return $user->hasRole('super admin');
		// 	}elseif(auth()->user()->hasRole('admin')){
		// 		return $user->hasRole(['super admin', 'admin']);
		// 	}elseif(auth()->user()->hasRole('sekretaris')){
		// 		return $user->hasRole(['super admin', 'admin', 'sekretaris']);
		// 	}elseif(auth()->user()->hasRole('deputi(Eselon I)')){
		// 		return $user->hasRole(['super admin', 'admin', 'sekretaris', 'deputi(Eselon I)']);
		// 	}elseif(auth()->user()->hasRole('asdep/karo(eselon II)')){
		// 		return $user->hasRole(['super admin', 'admin', 'sekretaris', 'deputi(Eselon I)', 'asdep/karo(eselon II)']);
		// 	}
		// });

		return collect($disposisi);
	}
}