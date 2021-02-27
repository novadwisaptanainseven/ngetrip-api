<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    // Get Image
    public function getImage($path, $filename)
    {
        $fullpath = "/app/$path/$filename";

        if (file_exists(storage_path($fullpath))) {
            return response()->file(storage_path($fullpath), [
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ], 200);
        } else {
            return response()->json([
                "message" => "Gambar tidak ditemukan"
            ], 404);
        }

        // if (file_exists(storage_path($fullpath))) {
        //     return response()->download(storage_path($fullpath));
        // } else {
        //     return response()->json([
        //         "message" => "Gambar tidak ditemukan"
        //     ], 404);
        // }
    }
}
