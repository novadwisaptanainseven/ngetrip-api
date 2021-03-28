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
            return response()->json($data, 200);
        } else {
            return response()->json([
                "message" => "Data wishlist dari user: $username tidak ditemukan"
            ], 404);
        }
    }

    // Get Wishlist by Id Paket Wisata
    public function getByIdPaketWisata(Request $request, $id_paket_wisata)
    {
        $data = Wishlist::where([
            ["id_paket_wisata", "=", $id_paket_wisata],
            ["username", "=", $request->username],
        ])->first();

        if ($data) {
            return response()->json($data, 200);
        } else {
            return response()->json([
                "message" => "Data wishlist dengan id paket wisata: $id_paket_wisata tidak ditemukan"
            ], 404);
        }
    }

    // Delete Wishlist
    public function deleteWishlist(Request $request, $id_paket_wisata)
    {
        Wishlist::where([
            ["id_paket_wisata", "=", $id_paket_wisata],
            ["username", "=", $request->username],
        ])->delete();

        return response('', 201);
    }
}
