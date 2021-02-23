<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    // Insert Wishlist
    public function insert(Request $request)
    {
        $messages = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "username" => "required",
                "id_paket_wisata" => "required"
            ],
            $messages
        );
        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }

        $insert = Wishlist::insert($request);

        if ($insert) {
            return response()->json([
                "message" => "Berhasil menambah data wishlist",
                "input_data" => $request->all()
            ], 201);
        } else {
            return response()->json([
                "message" => "Data wishlist sudah diremove",
                "remove_data" => $request->all()
            ], 201);
        }
    }

    // Get All Wishlist
    public function getByUsername($username)
    {
        $data = Wishlist::getByUsername($username);

        if ($data) {
            return response()->json([
                "message" => "Berhasil mendapatkan semua data wishlist dari user: $username",
                "data" => $data
            ], 200);
        } else {
            return response()->json([
                "message" => "Data wishlist dari user: $username tidak ditemukan"
            ], 404);
        }
    }
}
