<?php

namespace App\Http\Controllers;

use App\Models\TiketWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TiketWisataController extends Controller
{

    // Get Tiket Wisata by Username
    public function getByUsername($username)
    {
        $data = TiketWisata::getByUsername($username);

        if (count($data) > 0) {
            return response()->json($data, 200);
        } else {
            return response()->json([
                "message" => "Data tiket wisata dari username: $username tidak ditemukan"
            ], 404);
        }
    }

    // Get Tiket Wisata by Id
    public function getById($id_tiket_wisata)
    {
        $data = TiketWisata::getById($id_tiket_wisata);

        if ($data) {
            return response()->json($data, 200);
        } else {
            return response()->json([
                "message" => "Data tiket wisata dengan id: $id_tiket_wisata tidak ditemukan"
            ], 404);
        }
    }

    // Insert Tiket Wisata / Beli Paket Wisata
    public function insert(Request $request)
    {
        // Validasi
        $messages = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "username" => "required",
                "id_paket_wisata" => "required",
                "tgl_tiket" => "required",
                "total_tiket" => "required",
                "total_harga" => "required",
                "kode_transaksi" => "required",
            ],
            $messages
        );
        // Cek Validasi
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }

        // Proses insert / beli paket wisata
        TiketWisata::insert($request);

        return response()->json([
            "message" => "Beli paket wisata berhasil",
            "input_data" => $request->all()
        ], 201);
    }

    // Hapus Tiket Wisata
    public function deleteTiket($id_tiket_wisata)
    {
        $data = TiketWisata::where('id_tiket_wisata', '=', $id_tiket_wisata)->first();

        if ($data) {
            TiketWisata::where('id_tiket_wisata', '=', $id_tiket_wisata)->delete();
            return response()->json([
                "message" => "Berhasil menghapus data tiket dengan id: $id_tiket_wisata",
                "deleted_data" => $data
            ], 201);
        } else {
            return response()->json([
                "message" => "Data tiket dengan id: $id_tiket_wisata tidak ditemukan"
            ], 404);
        }
    }
}
