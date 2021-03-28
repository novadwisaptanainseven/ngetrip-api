<?php

namespace App\Http\Controllers;

use App\Models\AgentTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AgentTravelController extends Controller
{
    // Get All Agent Travel
    public function getAll()
    {
        $data = AgentTravel::all();

        foreach ($data as $i => $d) {
            $d->no = $i + 1;
        }

        return response($data, 200);
    }

    // Get Agent Travel By Id
    public function getById($id_agent_travel)
    {
        $data = AgentTravel::getById($id_agent_travel);

        if ($data) {
            return response()->json($data, 200);
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
                "nama" => "required",
                "alamat" => "required",
                "deskripsi" => "required",
                "gambar" => "required|mimes:jpg,jpeg,png|max:2048",
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
                "message" => "Tambah data agent travel berhasil",
                "input_data" => $request->all()
            ], 201);
        } else {
            // Jika gagal -> 500 INTERNAL SERVER ERROR
            return response()->json([
                "message" => "Terjadi kesalahan server",
            ], 500);
        }
    }

    // Edit Agent Travel
    public function edit(Request $request, $id_agent_travel)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "nama" => "required",
                "alamat" => "required",
                "deskripsi" => "required",
                "gambar" => "mimes:jpg,jpeg,png|max:2048",
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

        $edit = AgentTravel::edit($request, $id_agent_travel);

        if ($edit) {
            // Jika proses edit berhasil -> 201 CREATED
            return response()->json([
                "message" => "Edit data agent travel berhasil",
                "input_data" => $request->all()
            ], 201);
        } else {
            // Jika gagal -> 404 NOT FOUND
            return response()->json([
                "message" => "Data agent travel dengan id: $id_agent_travel tidak ditemukan",
            ], 404);
        }
    }

    // Delete Agent Travel 
    public function deleteAgentTravel($id_agent_travel)
    {
        $data = AgentTravel::where("id_agent_travel", "=", $id_agent_travel)->first();

        // Hapus Gambar
        Storage::delete($data->gambar);

        AgentTravel::where("id_agent_travel", "=", $id_agent_travel)
            ->delete();

        return response()->json([
            "message" => "Berhasil menghapus data agent travel dengan id: $id_agent_travel",

        ], 201);
    }

    public function getAllKontak($id_agent_travel)
    {
        $data = AgentTravel::getAllKontak($id_agent_travel);

        foreach ($data as $i => $d) {
            $d->no = $i + 1;
        }

        return response()->json([
            "message" => "Berhasil mendapatkan semua kontak dari agent travel: $id_agent_travel",
            "data" => $data
        ], 200);
    }

    public function getKontakById($id_agent_travel, $id_kontak)
    {
        $data = AgentTravel::getKontakById($id_agent_travel, $id_kontak);

        return response()->json([
            "message" => "Berhasil mendapatkan kontak dengan id: $id_kontak",
            "data" => $data
        ], 200);
    }

    public function insertKontak(Request $request, $id_agent_travel)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "nama" => "required",
                "kontak" => "required",
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

        $insert = AgentTravel::insertKontak($request, $id_agent_travel);

        if ($insert) {
            // Jika proses insert berhasil -> 201 CREATED
            return response()->json([
                "message" => "Tambah data kontak berhasil",
                "input_data" => $request->all()
            ], 201);
        } else {
            // Jika gagal -> 500 INTERNAL SERVER ERROR
            return response()->json([
                "message" => "Terjadi kesalahan server",
            ], 500);
        }
    }

    public function editKontak(Request $request, $id_agent_travel, $id_kontak)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "nama" => "required",
                "kontak" => "required",
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

        $edit = AgentTravel::editKontak($request, $id_agent_travel, $id_kontak);

        if ($edit) {
            // Jika proses edit berhasil -> 201 CREATED
            return response()->json([
                "message" => "Edit data kontak berhasil",
                "input_data" => $request->all()
            ], 201);
        } else {
            // Jika gagal -> 404 NOT FOUND
            return response()->json([
                "message" => "Data tidak ditemukan",
            ], 404);
        }
    }

    public function deleteKontak($id_agent_travel, $id_kontak)
    {
        DB::table("kontak_agent_travel")
            ->where([
                ["id_agent_travel", "=", $id_agent_travel],
                ["id_kontak", "=", $id_kontak],
            ])
            ->delete();

        return response()->json([
            "message" => "Berhasil menghapus data kontak dengan id: $id_kontak",

        ], 201);
    }
}
