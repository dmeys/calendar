<?php

namespace App\Http\Controllers\Files;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');

        if(empty($file)) {
            return response()->json('Empty file for upload.', 404);
        }

        $upload_file = Storage::putFile('public', $file);

        return $upload_file;
    }
}
