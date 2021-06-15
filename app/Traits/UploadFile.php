<?php

namespace App\Traits;

use Carbon\Carbon;

trait UploadFile {
	public function uploadFile($file, $folder)
	{
		
        $filename = date('Ymdhis') . '.' . $file->getClientOriginalExtension();
        $path = public_path('uploads/'.$folder.'/');
        $file->move($path, $filename);
        return 'uploads/'.$folder.'/'. $filename;
	}
}