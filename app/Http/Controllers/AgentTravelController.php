<?php

namespace App\Http\Controllers;

use App\Models\AgentTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgentTravelController extends Controller
{
    // Get All Agent Travel
    public function getAll()
    {
        $data = AgentTravel::all();

        return response($data, 200);
    }

    // Get Agent Travel By Id
    public function getById($id_agent_travel)
    {
        $data = AgentTravel::getById($id_agent_travel);

        if ($data) {
            return response()->json($data);
        } else {
            return response()->json([
                "message" => "Data agent travel dengan id: {$id_agent_travel} tidak ditemukan"
            ], 404);
        }
    }

    // Insert Agent Travel
    public function insert(Request $request)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "nama" => "required"
            ],
            $message
        );
        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "message" => $validator->errors()
            ], 400);
        }
        // End of validation

        $insert = AgentTravel::insert($request);

        if ($insert) {
            // Jika proses insert berhasil -> 201 CREATED
            return response()->json([
                "message" => "Tambah data paket wisata berhasil",
                "input_data" => $request->all()
            ], 201);
        } else {
            // Jika gagal -> 500 INTERNAL SERVER ERROR
            return response()->json([
                "message" => "Terjadi kesalahan server",
            ], 500);
        }
    }
}
