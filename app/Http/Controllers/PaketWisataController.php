<?php

namespace App\Http\Controllers;

use App\Models\PaketWisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaketWisataController extends Controller
{
    // Get All Paket Wisata berdasarkan Agent Travel
    public function getByAgentTravel($id_agent_travel)
    {
        $data = PaketWisata::getByAgentTravel($id_agent_travel);

        foreach ($data as $i => $d) {
            $d->no = $i + 1;
        }

        return response()->json($data, 200);
    }

    // Get All Paket Wisata
    public function getAll()
    {
        $data = PaketWisata::getAll();

        // UNtk namba no urut
        foreach ($data as $i => $d) {
            $d->no = $i + 1;
        }

        return response()->json($data, 200);
    }

    // Get Paket Wisata By Id
    public function getById($id_paket_wisata)
    {
        $data = PaketWisata::getById($id_paket_wisata);

        if ($data) {
            return response()->json($data, 200);
        } else {
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan",
                "data" => $data
            ], 404);
        }
    }

    // Insert Paket Wisata
    public function insert(Request $request, $id_agent_travel)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "nama_paket_wisata" => "required",
                "harga" => "required",
                "meeting_point" => "required",
                "include" => "required",
                "exclude" => "required",
                "deskripsi" => "required",
                "gambar" => "mimes:jpg,jpeg,png|max:1048|required",
            ],
            $message
        );

        $errors = [];

        if (in_array(null, $request->include)) {
            array_push($errors, "Include paket wisata harus diisi!");
        }
        if (in_array(null, $request->exclude)) {
            array_push($errors, "Exclude paket wisata harus diisi!");
        }
        if (in_array(null, $request->deskripsi)) {
            array_push($errors, "Deskripsi paket wisata harus diisi!");
        }
        // if(count($errors) > 0)
        // {
        //     return response()->json([
        //         "errors" => $errors
        //     ])
        // }

        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }
        // End of validation

        $insert = PaketWisata::insert($request, $id_agent_travel);

        if ($insert === 201) {
            // Jika proses insert berhasil -> 201 CREATED
            return response()->json([
                "message" => "Berhasil menambahkan data paket wisata",
                "input_data" => $request->all()
            ], 201);
        } elseif ($insert === 404) {
            // Jika data agent travel tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data agent travel dengan id: {$id_agent_travel} tidak ditemukan"
            ], 404);
        } else {
            // Jika gagal -> 500 INTERNAL SERVER ERROR
            return response()->json([
                "message" => "Terjadi kesalahan server",
            ], 500);
        }
    }

    // Insert Paket Wisata 2
    public function insertPaketWisata(Request $request)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "id_agent_travel" => "required",
                "nama_paket_wisata" => "required",
                "harga" => "required",
                "satuan" => "required",
                "meeting_point" => "required",
                "include" => "required",
                "exclude" => "required",
                "deskripsi" => "required",
                "gambar" => "mimes:jpg,jpeg,png|max:1048|required",
            ],
            $message
        );

        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }

        // $errors = [];
        $errors = new \stdClass;

        // if (!count($request->include) > 0) {
        //     // array_push($errors, "Include paket wisata harus diisi!");
        //     $errors->include = ["Include paket wisata harus diisi"];
        // }
        if (in_array(null, $request->include)) {
            // array_push($errors, "Include paket wisata harus diisi!");
            $errors->include = ["Include paket wisata harus diisi"];
        }
        // if (!count($request->exclude) > 0) {
        //     // array_push($errors, "Exclude paket wisata harus diisi!");
        //     $errors->exclude = ["Exclude paket wisata harus diisi"];
        // }
        if (in_array(null, $request->exclude)) {
            // array_push($errors, "Exclude paket wisata harus diisi!");
            $errors->Exclude = ["Exclude paket wisata harus diisi"];
        }
        // if (!count($request->deskripsi) > 0) {
        //     // array_push($errors, "Deskripsi paket wisata harus diisi!");
        //     $errors->deskripsi = ["Deskripsi paket wisata harus diisi"];
        // }
        if (in_array(null, $request->deskripsi)) {
            // array_push($errors, "Deskripsi paket wisata harus diisi!");
            $errors->deskripsi = ["Deskripsi paket wisata harus diisi"];
        }

        if (count((array)$errors) > 0) {
            return response()->json([
                "errors" => $errors
            ], 400);
        }

        // End of validation

        $insert = PaketWisata::insertPaketWisata($request);

        if ($insert) {
            // Jika proses insert berhasil -> 201 CREATED
            return response()->json([
                "message" => "Berhasil menambahkan data paket wisata",
                "input_data" => $request->all()
            ], 201);
        } elseif ($insert === 404) {
            // Jika data agent travel tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data agent travel dengan id: {$request->id_agent_travel} tidak ditemukan"
            ], 404);
        } else {
            // Jika gagal -> 500 INTERNAL SERVER ERROR
            return response()->json([
                "message" => "Terjadi kesalahan server",
            ], 500);
        }
    }

    // Insert Rating Wisata
    public function insertRating(Request $request, $id_paket_wisata)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "rating" => "required",
                "username" => "required",
            ],
            $message
        );

        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }
        // End of validation

        $insert = PaketWisata::insertRating($request, $id_paket_wisata);

        if ($insert === 201) {
            // Jika proses insert berhasil -> 201 CREATED
            return response()->json([
                "message" => "Berhasil memberikan rating pada data paket wisata",
                "input_data" => $request->all()
            ], 201);
        } elseif ($insert === 404) {
            // Jika data paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } else {
            // Jika gagal -> 500 INTERNAL SERVER ERROR
            return response()->json([
                "message" => "Terjadi kesalahan server",
            ], 500);
        }
    }

    // Edit Paket Wisata
    public function edit(Request $request, $id_paket_wisata)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "nama_paket_wisata" => "required",
                "harga" => "required",
                "meeting_point" => "required",
            ],
            $message
        );

        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }
        // End of validation

        $edit = PaketWisata::edit($request, $id_paket_wisata);

        if ($edit === 201) {
            // Jika proses edit berhasil -> 201 CREATED
            return response()->json([
                "message" => "Berhasil mengubah data paket wisata dengan id: {$id_paket_wisata}",
                "input_data" => $request->all()
            ], 201);
        } elseif ($edit === 404) {
            // Jika data paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } else {
            // Jika gagal -> 500 INTERNAL SERVER ERROR
            return response()->json([
                "message" => "Terjadi kesalahan server",
            ], 500);
        }
    }
    // Delete Paket Wisata
    public function delete($id_paket_wisata)
    {
        $data = DB::table("paket_wisata")
            ->where("id_paket_wisata", "=", $id_paket_wisata)
            ->first();

        $delete = PaketWisata::deletePaketWisata($id_paket_wisata);

        if ($delete === true) {
            return response()->json([
                "message" => "Berhasil menghapus data paket wisata dengan id: {$id_paket_wisata}",
                "deleted_data" => $data
            ], 201);
        } elseif ($delete === 404) {
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } else {
            return response()->json([
                "message" => "Terjadi kesalahan server"
            ], 500);
        }
    }


    // Deskripsi Wisata

    // Get All Deskripsi
    public function getDeskripsi($id_paket_wisata)
    {
        $data = PaketWisata::getDeskripsi($id_paket_wisata);

        foreach ($data as $i => $item) {
            $item->no = $i + 1;
        }

        if ($data !== 404) {
            // Jika berhasil -> 200 OK
            return response()->json($data, 200);
        } else {
            // Jika paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        }
    }

    // Get Deskripsi By ID
    public function getDeskripsiById($id_paket_wisata, $id_deskripsi)
    {
        $data = PaketWisata::getDeskripsiById($id_paket_wisata, $id_deskripsi);

        if ($data !== 404) {
            // Jika berhasil -> 200 OK
            return response()->json($data, 200);
        } else {
            // Jika paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} dan deskripsi dengan id: $id_deskripsi tidak ditemukan"
            ], 404);
        }
    }

    // Insert Deskripsi
    public function insertDeskripsi(Request $request, $id_paket_wisata)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "hari_ke" => "required",
                "keterangan" => "required",
            ],
            $message
        );

        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }
        // End of validation

        $insert = PaketWisata::insertDeskripsi($request, $id_paket_wisata);

        if ($insert === 201) {
            // Jika proses insert berhasil -> 201 CREATED
            return response()->json([
                "message" => "Berhasil menambahkan data deskripsi",
                "input_data" => $request->all()
            ], 201);
        } elseif ($insert === 404) {
            // Jika data agent travel tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } else {
            // Jika gagal -> 500 INTERNAL SERVER ERROR
            return response()->json([
                "message" => "Terjadi kesalahan server",
            ], 500);
        }
    }

    // Edit Deskripsi
    public function editDeskripsi(Request $request, $id_paket_wisata, $id_deskripsi_wisata)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "hari_ke" => "required",
                "keterangan" => "required",
            ],
            $message
        );

        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }
        // End of validation

        $edit = PaketWisata::editDeskripsi($request, $id_paket_wisata, $id_deskripsi_wisata);

        if ($edit === 404) {
            // Jika data agent travel tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } else {
            // Jika proses edit berhasil -> 201 CREATED
            return response()->json([
                "message" => "Berhasil mengubah data deskripsi",
                "edited_data" => $edit
            ], 201);
        }
    }

    // Delete Deskripsi
    public function deleteDeskripsi($id_paket_wisata, $id_deskripsi_wisata)
    {

        $data = DB::table("deskripsi_wisata")
            ->where("id_deskripsi_wisata", "=", $id_deskripsi_wisata)
            ->first();

        $delete = PaketWisata::deleteDeskripsi($id_paket_wisata, $id_deskripsi_wisata);

        if ($delete === true) {
            return response()->json([
                "message" => "Berhasil menghapus data deskripsi wisata dengan id: {$id_deskripsi_wisata}",
                "deleted_data" => $data
            ], 201);
        } elseif ($delete === 404) {
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } elseif ($delete === 405) {
            return response()->json([
                "message" => "Data deskripsi wisata dengan id: {$id_deskripsi_wisata} tidak ditemukan"
            ], 404);
        } else {
            return response()->json([
                "message" => "Terjadi kesalahan server"
            ], 500);
        }
    }

    // Include Wisata

    // Get All Include
    public function getInclude($id_paket_wisata)
    {
        $data = PaketWisata::getInclude($id_paket_wisata);

        foreach ($data as $i => $item) {
            $item->no = $i + 1;
        }

        if ($data !== 404) {
            // Jika berhasil -> 200 OK
            return response()->json($data, 200);
        } else {
            // Jika paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        }
    }

    // Get Include By ID
    public function getIncludeById($id_paket_wisata, $id_include)
    {
        $data = DB::table("include_wisata")
            ->where([
                ["id_paket_wisata", "=", $id_paket_wisata],
                ["id_include_wisata", "=", $id_include],
            ])->first();

        if ($data) {
            // Jika berhasil -> 200 OK
            return response()->json($data, 200);
        } else {
            // Jika paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} dan include dengan id: $id_include tidak ditemukan"
            ], 404);
        }
    }

    // Insert Include
    public function insertInclude(Request $request, $id_paket_wisata)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "include" => "required",
            ],
            $message
        );

        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }
        // End of validation

        $insert = PaketWisata::insertInclude($request, $id_paket_wisata);

        if ($insert === 201) {
            // Jika proses insert berhasil -> 201 CREATED
            return response()->json([
                "message" => "Berhasil menambahkan data include",
                "input_data" => $request->all()
            ], 201);
        } elseif ($insert === 404) {
            // Jika data paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } else {
            // Jika gagal -> 500 INTERNAL SERVER ERROR
            return response()->json([
                "message" => "Terjadi kesalahan server",
            ], 500);
        }
    }

    // Edit Include
    public function editInclude(Request $request, $id_paket_wisata, $id_include_wisata)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "include" => "required",
            ],
            $message
        );

        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }
        // End of validation

        $edit = PaketWisata::editInclude($request, $id_paket_wisata, $id_include_wisata);

        if ($edit === 404) {
            // Jika data paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } elseif ($edit === 405) {
            // Jika data include wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data include wisata dengan id: {$id_include_wisata} tidak ditemukan"
            ], 404);
        } else {
            // Jika proses edit berhasil -> 201 CREATED
            return response()->json([
                "message" => "Berhasil mengubah data include dengan id: {$id_include_wisata}",
                "edited_data" => $edit
            ], 201);
        }
    }

    // Delete Include
    public function deleteInclude($id_paket_wisata, $id_include_wisata)
    {

        $data = DB::table("include_wisata")
            ->where("id_include_wisata", "=", $id_include_wisata)
            ->first();

        $delete = PaketWisata::deleteInclude($id_paket_wisata, $id_include_wisata);

        if ($delete === true) {
            return response()->json([
                "message" => "Berhasil menghapus data include wisata dengan id: {$id_include_wisata}",
                "deleted_data" => $data
            ], 201);
        } elseif ($delete === 404) {
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } elseif ($delete === 405) {
            return response()->json([
                "message" => "Data include wisata dengan id: {$id_include_wisata} tidak ditemukan"
            ], 404);
        } else {
            return response()->json([
                "message" => "Terjadi kesalahan server"
            ], 500);
        }
    }

    // Exclude Wisata

    // Get All Exclude
    public function getExclude($id_paket_wisata)
    {
        $data = PaketWisata::getExclude($id_paket_wisata);

        foreach ($data as $i => $item) {
            $item->no = $i + 1;
        }

        if ($data !== 404) {
            // Jika berhasil -> 200 OK
            return response()->json($data, 200);
        } else {
            // Jika paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        }
    }

    // Get Exclude By ID
    public function getExcludeById($id_paket_wisata, $id_exclude)
    {
        $data = DB::table("exclude_wisata")
            ->where([
                ["id_paket_wisata", "=", $id_paket_wisata],
                ["id_exclude_wisata", "=", $id_exclude],
            ])->first();

        if ($data) {
            // Jika berhasil -> 200 OK
            return response()->json($data, 200);
        } else {
            // Jika paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} dan exclude dengan id: $id_exclude tidak ditemukan"
            ], 404);
        }
    }

    // Insert Exclude
    public function insertExclude(Request $request, $id_paket_wisata)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "exclude" => "required",
            ],
            $message
        );

        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }
        // End of validation

        $insert = PaketWisata::insertExclude($request, $id_paket_wisata);

        if ($insert === 201) {
            // Jika proses insert berhasil -> 201 CREATED
            return response()->json([
                "message" => "Berhasil menambahkan data exclude",
                "input_data" => $request->all()
            ], 201);
        } elseif ($insert === 404) {
            // Jika data paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } else {
            // Jika gagal -> 500 INTERNAL SERVER ERROR
            return response()->json([
                "message" => "Terjadi kesalahan server",
            ], 500);
        }
    }

    // Edit Exclude
    public function editExclude(Request $request, $id_paket_wisata, $id_exclude_wisata)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi"
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "exclude" => "required",
            ],
            $message
        );

        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }
        // End of validation

        $edit = PaketWisata::editExclude($request, $id_paket_wisata, $id_exclude_wisata);

        if ($edit === 404) {
            // Jika data paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } elseif ($edit === 405) {
            // Jika data exclude wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data exclude wisata dengan id: {$id_exclude_wisata} tidak ditemukan"
            ], 404);
        } else {
            // Jika proses edit berhasil -> 201 CREATED
            return response()->json([
                "message" => "Berhasil mengubah data exclude dengan id: {$id_exclude_wisata}",
                "edited_data" => $edit
            ], 201);
        }
    }

    // Delete Exclude
    public function deleteExclude($id_paket_wisata, $id_exclude_wisata)
    {

        $data = DB::table("exclude_wisata")
            ->where("id_exclude_wisata", "=", $id_exclude_wisata)
            ->first();

        $delete = PaketWisata::deleteExclude($id_paket_wisata, $id_exclude_wisata);

        if ($delete === true) {
            return response()->json([
                "message" => "Berhasil menghapus data exclude wisata dengan id: {$id_exclude_wisata}",
                "deleted_data" => $data
            ], 201);
        } elseif ($delete === 404) {
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } elseif ($delete === 405) {
            return response()->json([
                "message" => "Data exclude wisata dengan id: {$id_exclude_wisata} tidak ditemukan"
            ], 404);
        } else {
            return response()->json([
                "message" => "Terjadi kesalahan server"
            ], 500);
        }
    }

    // Gambar Wisata

    // Get All Gambar
    public function getGambar($id_paket_wisata)
    {
        $data = PaketWisata::getGambar($id_paket_wisata);

        foreach ($data as $i => $item) {
            $item->no = 1 + $i;
        }

        if ($data !== 404) {
            // Jika berhasil -> 200 OK
            return response()->json($data, 200);
        } else {
            // Jika paket wisata tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        }
    }

    // Insert Gambar
    public function insertGambar(Request $request, $id_paket_wisata)
    {
        // Validation
        $message = [
            "required" => ":attribute harus diisi",
            "mimes" => ":attribute hanya boleh bertipe jpg, png, dan jpeg",
            "max" => ":attribute maksimal 1 mb",
        ];
        $validator = Validator::make(
            $request->all(),
            [
                "file_gambar" => "required|mimes:jpg,png,jpeg|max:1048",
            ],
            $message
        );

        // Validation Check
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 400);
        }
        // End of validation

        $insert = PaketWisata::insertGambar($request, $id_paket_wisata);

        if ($insert === 201) {
            // Jika proses insert berhasil -> 201 CREATED
            return response()->json([
                "message" => "Berhasil menambahkan data gambar",
                "input_data" => $request->all()
            ], 201);
        } elseif ($insert === 404) {
            // Jika data paket gambar tidak ditemukan -> 404 NOT FOUND
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } else {
            // Jika gagal -> 500 INTERNAL SERVER ERROR
            return response()->json([
                "message" => "Terjadi kesalahan server",
            ], 500);
        }
    }

    // Delete Gambar
    public function deleteGambar($id_paket_wisata, $id_gambar)
    {
        $data = DB::table("gambar_wisata")
            ->where("id_gambar_wisata", "=", $id_gambar)
            ->first();

        $delete = PaketWisata::deleteGambar($id_paket_wisata, $id_gambar);

        if ($delete === true) {
            return response()->json([
                "message" => "Berhasil menghapus data gambar wisata dengan id: {$id_gambar}",
                "deleted_data" => $data
            ], 201);
        } elseif ($delete === 404) {
            return response()->json([
                "message" => "Data paket wisata dengan id: {$id_paket_wisata} tidak ditemukan"
            ], 404);
        } elseif ($delete === 405) {
            return response()->json([
                "message" => "Data gambar wisata dengan id: {$id_gambar} tidak ditemukan"
            ], 404);
        } else {
            return response()->json([
                "message" => "Terjadi kesalahan server"
            ], 500);
        }
    }

    // Update Status Gambar
    public function updateStatusGambar(Request $request, $id_paket_wisata, $id_gambar)
    {
        $update_status_gambar = PaketWisata::updateStatusGambar($request, $id_paket_wisata, $id_gambar);

        if ($update_status_gambar) {
            return response()->json([
                "message" => "Update status gambar menjadi utama dengan id: $id_gambar berhasil",
                "input_data" => $request->all()
            ], 201);
        } else {
            return response()->json([
                "message" => "Gambar dengan $id_gambar tidak ditemukan"
            ], 404);
        }
    }
}
