<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Str;

trait UploadFile {
	public function uploadFile($file, $folder)
	{
		
        $filename = date('Ymdhis') . '-'.  Str::slug(Str::random(10)) . '.' . $file->getClientOriginalExtension();
        $path = public_path('uploads/'.$folder.'/');
        $file->move($path, $filename);
        return 'uploads/'.$folder.'/'. $filename;
	}
}