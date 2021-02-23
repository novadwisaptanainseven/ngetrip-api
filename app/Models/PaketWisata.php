<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaketWisata extends Model
{
    use HasFactory;

    protected $table = 'paket_wisata';
    protected $primaryKey = 'id_paket_wisata';

    // Get Paket Wisata By Agent Travel
    public static function getByAgentTravel($id_agent_travel)
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";
        $tbl_gambar = "gambar_wisata";

        // Get data paket wisata
        $data_paket = DB::table($tbl_paket_wisata)
            ->where('id_agent_travel', '=', $id_agent_travel)
            ->get();

        // Get data gambar utama
        foreach ($data_paket as $d) {
            $gambar = DB::table($tbl_gambar)
                ->where(
                    [
                        ["id_paket_wisata", "=", $d->id_paket_wisata],
                        ["status", "=", 1],
                    ]
                )
                ->first();
            $d->gambar = $gambar->file_gambar;
        }

        return $data_paket;
    }

    // Get Paket Wisata
    public static function getAll()
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";
        $tbl_gambar = "gambar_wisata";

        // Get data paket wisata
        $data_paket = DB::table($tbl_paket_wisata)
            ->get();

        // Get data gambar utama
        foreach ($data_paket as $d) {
            $gambar = DB::table($tbl_gambar)
                ->where(
                    [
                        ["id_paket_wisata", "=", $d->id_paket_wisata],
                        ["status", "=", 1],
                    ]
                )
                ->first();
            $d->gambar = $gambar->file_gambar;
        }

        return $data_paket;
    }

    // Get Paket Wisata By Id
    public static function getById($id_paket_wisata)
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";
        $tbl_gambar = "gambar_wisata";
        $tbl_include = "include_wisata";
        $tbl_exclude = "exclude_wisata";
        $tbl_deskripsi = "deskripsi_wisata";

        // Get data paket wisata
        $data_paket = DB::table($tbl_paket_wisata)
            ->where('id_paket_wisata', '=', $id_paket_wisata)
            ->first();

        // Cek apakah data paket wisata ditemukan
        if ($data_paket) {
            return $data_paket;
        } else {
            return null;
        }
    }

    // Insert Paket Wisata
    public static function insert($req, $id_agent_travel)
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";
        $tbl_gambar = "gambar_wisata";
        $tbl_agent_travel = "agent_travel";

        // Cek apakah data agent travel ditemukan
        $data_agent = DB::table($tbl_agent_travel)->where('id_agent_travel', '=', $id_agent_travel)->first();
        if (!$data_agent) {
            return 404;
        }

        // Tambah data paket wisata
        $data_paket = [
            "id_agent_travel" => $id_agent_travel,
            "nama_paket_wisata" => $req->nama_paket_wisata,
            "harga" => $req->harga,
            "meeting_point" => $req->meeting_point,
        ];
        $insert = DB::table($tbl_paket_wisata)->insert($data_paket);

        // Tambah gambar wisata
        $file = $req->file("gambar");
        // Sanitasi nama file
        $sanitize = sanitizeFile($file);
        $gambar = $file->storeAs("images", rand(0, 100) . time() . '-' . $sanitize);

        // Get id paket wisata 
        $id_paket_wisata = DB::table($tbl_paket_wisata)
            ->orderBy('id_paket_wisata', 'desc')
            ->first()
            ->id_paket_wisata;

        $data_gambar = [
            "id_paket_wisata" => $id_paket_wisata,
            "file_gambar" => $gambar,
            "status" => 1
        ];
        DB::table($tbl_gambar)->insert($data_gambar);

        if ($insert) {
            return 201;
        } else {
            return false;
        }
    }

    // Insert Rating Wisata
    public static function insertRating($req, $id_paket_wisata)
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";
        $tbl_rating = "rating_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket_wisata)->where('id_paket_wisata', '=', $id_paket_wisata)->first();
        if (!$data_paket) {
            return 404;
        }

        // Tambah data rating wisata
        $data_rating = [
            "id_paket_wisata" => $id_paket_wisata,
            "username" => $req->username,
            "rating" => $req->rating,
        ];
        $username = DB::table($tbl_rating)
            ->where("username", '=', $req->username)
            ->first();
        if (!$username) {
            DB::table($tbl_rating)->insert($data_rating);
        } else {
            DB::table($tbl_rating)
                ->where("username", "=", $req->username)
                ->update($data_rating);
        }

        return 201;
    }

    // Edit Paket Wisata
    public static function edit($req, $id_paket_wisata)
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket_wisata)->where('id_paket_wisata', '=', $id_paket_wisata)->first();
        if (!$data_paket) {
            return 404;
        }

        // Edit data paket wisata
        $data_paket = [
            "nama_paket_wisata" => $req->nama_paket_wisata,
            "harga" => $req->harga,
            "meeting_point" => $req->meeting_point,
        ];
        DB::table($tbl_paket_wisata)
            ->where("id_paket_wisata", "=", $id_paket_wisata)
            ->update($data_paket);

        return 201;
    }

    // Delete Paket Wisata
    public static function deletePaketWisata($id_paket_wisata)
    {
        // Tabel - tabel
        $tbl_paket = "paket_wisata";
        $tbl_gambar = "gambar_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket)
            ->where("id_paket_wisata", "=", $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        // Hapus data
        DB::table($tbl_paket)
            ->where("id_paket_wisata", "=", $id_paket_wisata)
            ->delete();

        // Hapus data gambar
        $data_gambar = DB::table($tbl_gambar)
            ->where("id_paket_wisata", "=", $id_paket_wisata)
            ->get();
        DB::table($tbl_gambar)
            ->where("id_paket_wisata", "=", $id_paket_wisata)
            ->delete();

        foreach ($data_gambar as $gambar) {
            $path = $gambar->file_gambar;
            Storage::delete($path);
        }

        return true;
    }

    // Deskripsi Wisata
    // Get All Deskripsi
    public static function getDeskripsi($id_paket_wisata)
    {
        // Tabel - tabel
        $tbl_deskripsi = "deskripsi_wisata";
        $tbl_paket = "paket_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket)
            ->where("id_paket_wisata", '=', $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        $data_deskripsi = DB::table($tbl_deskripsi)
            ->where('id_paket_wisata', '=', $id_paket_wisata)
            ->get();

        return $data_deskripsi;
    }

    // Insert Deskripsi Wisata
    public static function insertDeskripsi($req, $id_paket_wisata)
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";
        $tbl_deskripsi = "deskripsi_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket_wisata)
            ->where('id_paket_wisata', '=', $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        // Tambah data deskripsi wisata
        $data_deskripsi = [
            "id_paket_wisata" => $id_paket_wisata,
            "hari_ke" => $req->hari_ke,
            "keterangan" => $req->keterangan,
        ];
        $insert = DB::table($tbl_deskripsi)->insert($data_deskripsi);

        if ($insert) {
            return 201;
        } else {
            return false;
        }
    }

    // Edit Deskripsi Wisata
    public static function editDeskripsi($req, $id_paket_wisata, $id_deskripsi_wisata)
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";
        $tbl_deskripsi = "deskripsi_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket_wisata)
            ->where('id_paket_wisata', '=', $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        // Tambah data deskripsi wisata
        $data_deskripsi = [
            "hari_ke" => $req->hari_ke,
            "keterangan" => $req->keterangan,
        ];
        DB::table($tbl_deskripsi)
            ->where('id_deskripsi_wisata', '=', $id_deskripsi_wisata)
            ->update($data_deskripsi);

        // Get data setelah diedit
        $edited_data = DB::table($tbl_deskripsi)
            ->where('id_deskripsi_wisata', '=', $id_deskripsi_wisata)
            ->first();

        return $edited_data;
    }

    // Delete Deskripsi Wisata
    public static function deleteDeskripsi($id_paket_wisata, $id_deskripsi_wisata)
    {
        // Tabel - tabel
        $tbl_deskripsi = "deskripsi_wisata";
        $tbl_paket = "paket_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket)
            ->where("id_paket_wisata", "=", $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        // Cek apakah data deskripsi ditemukan
        $data_deskripsi = DB::table($tbl_deskripsi)
            ->where(
                [
                    ["id_deskripsi_wisata", "=", $id_deskripsi_wisata],
                    ["id_paket_wisata", "=", $id_paket_wisata],
                ]
            )
            ->first();
        if (!$data_deskripsi) {
            return 405;
        }

        // Hapus data
        DB::table($tbl_deskripsi)
            ->where(
                [
                    ["id_deskripsi_wisata", "=", $id_deskripsi_wisata],
                    ["id_paket_wisata", "=", $id_paket_wisata],
                ]
            )
            ->delete();

        return true;
    }

    // Include Wisata
    // Get All Include
    public static function getInclude($id_paket_wisata)
    {
        // Tabel - tabel
        $tbl_include = "include_wisata";
        $tbl_paket = "paket_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket)
            ->where("id_paket_wisata", '=', $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        $data_include = DB::table($tbl_include)
            ->where('id_paket_wisata', '=', $id_paket_wisata)
            ->get();

        return $data_include;
    }

    // Insert Include Wisata
    public static function insertInclude($req, $id_paket_wisata)
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";
        $tbl_include = "include_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket_wisata)
            ->where('id_paket_wisata', '=', $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        // Tambah data include wisata
        $data_include = [
            "id_paket_wisata" => $id_paket_wisata,
            "include" => $req->include,
        ];
        $insert = DB::table($tbl_include)->insert($data_include);

        if ($insert) {
            return 201;
        } else {
            return false;
        }
    }

    // Edit Include Wisata
    public static function editInclude($req, $id_paket_wisata, $id_include_wisata)
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";
        $tbl_include = "include_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket_wisata)
            ->where('id_paket_wisata', '=', $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        // Cek apakah data include ditemukan
        $data_include = DB::table($tbl_include)
            ->where([
                ["id_paket_wisata", "=", $id_paket_wisata],
                ["id_include_wisata", "=", $id_include_wisata],
            ])
            ->first();
        if (!$data_include) {
            return 405;
        }

        // Tambah data include wisata
        $data_include = [
            "include" => $req->include,
        ];
        DB::table($tbl_include)
            ->where('id_include_wisata', '=', $id_include_wisata)
            ->update($data_include);

        // Get data setelah diedit
        $edited_data = DB::table($tbl_include)
            ->where('id_include_wisata', '=', $id_include_wisata)
            ->first();

        return $edited_data;
    }

    // Delete Include Wisata
    public static function deleteInclude($id_paket_wisata, $id_include_wisata)
    {
        // Tabel - tabel
        $tbl_include = "include_wisata";
        $tbl_paket = "paket_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket)
            ->where("id_paket_wisata", "=", $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        // Cek apakah data include ditemukan
        $data_include = DB::table($tbl_include)
            ->where(
                [
                    ["id_include_wisata", "=", $id_include_wisata],
                    ["id_paket_wisata", "=", $id_paket_wisata],
                ]
            )
            ->first();
        if (!$data_include) {
            return 405;
        }

        // Hapus data
        DB::table($tbl_include)
            ->where(
                [
                    ["id_include_wisata", "=", $id_include_wisata],
                    ["id_paket_wisata", "=", $id_paket_wisata],
                ]
            )
            ->delete();

        return true;
    }

    // Exclude Wisata
    // Get All Exclude
    public static function getExclude($id_paket_wisata)
    {
        // Tabel - tabel
        $tbl_exclude = "exclude_wisata";
        $tbl_paket = "paket_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket)
            ->where("id_paket_wisata", '=', $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        $data_exclude = DB::table($tbl_exclude)
            ->where('id_paket_wisata', '=', $id_paket_wisata)
            ->get();

        return $data_exclude;
    }

    // Insert Exclude Wisata
    public static function insertExclude($req, $id_paket_wisata)
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";
        $tbl_exclude = "exclude_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket_wisata)
            ->where('id_paket_wisata', '=', $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        // Tambah data exclude wisata
        $data_exclude = [
            "id_paket_wisata" => $id_paket_wisata,
            "exclude" => $req->exclude,
        ];
        $insert = DB::table($tbl_exclude)->insert($data_exclude);

        if ($insert) {
            return 201;
        } else {
            return false;
        }
    }

    // Edit Exclude Wisata
    public static function editExclude($req, $id_paket_wisata, $id_exclude_wisata)
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";
        $tbl_exclude = "exclude_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket_wisata)
            ->where('id_paket_wisata', '=', $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        // Cek apakah data exclude ditemukan
        $data_exclude = DB::table($tbl_exclude)
            ->where([
                ["id_paket_wisata", "=", $id_paket_wisata],
                ["id_exclude_wisata", "=", $id_exclude_wisata],
            ])
            ->first();
        if (!$data_exclude) {
            return 405;
        }

        // Tambah data exclude wisata
        $data_exclude = [
            "exclude" => $req->exclude,
        ];
        DB::table($tbl_exclude)
            ->where('id_exclude_wisata', '=', $id_exclude_wisata)
            ->update($data_exclude);

        // Get data setelah diedit
        $edited_data = DB::table($tbl_exclude)
            ->where('id_exclude_wisata', '=', $id_exclude_wisata)
            ->first();

        return $edited_data;
    }

    // Delete Exclude Wisata
    public static function deleteExclude($id_paket_wisata, $id_exclude_wisata)
    {
        // Tabel - tabel
        $tbl_exclude = "exclude_wisata";
        $tbl_paket = "paket_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket)
            ->where("id_paket_wisata", "=", $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        // Cek apakah data exclude ditemukan
        $data_exclude = DB::table($tbl_exclude)
            ->where(
                [
                    ["id_exclude_wisata", "=", $id_exclude_wisata],
                    ["id_paket_wisata", "=", $id_paket_wisata],
                ]
            )
            ->first();
        if (!$data_exclude) {
            return 405;
        }

        // Hapus data
        DB::table($tbl_exclude)
            ->where(
                [
                    ["id_exclude_wisata", "=", $id_exclude_wisata],
                    ["id_paket_wisata", "=", $id_paket_wisata],
                ]
            )
            ->delete();

        return true;
    }

    // Gambar Wisata
    // Get All Gambar
    public static function getGambar($id_paket_wisata)
    {
        // Tabel - tabel
        $tbl_gambar = "gambar_wisata";
        $tbl_paket = "paket_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket)
            ->where("id_paket_wisata", '=', $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        $data_gambar = DB::table($tbl_gambar)
            ->where('id_paket_wisata', '=', $id_paket_wisata)
            ->get();

        return $data_gambar;
    }

    // Insert Gambar Wisata
    public static function insertGambar($req, $id_paket_wisata)
    {
        // Tabel - tabel
        $tbl_paket_wisata = "paket_wisata";
        $tbl_gambar = "gambar_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket_wisata)
            ->where('id_paket_wisata', '=', $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        // Tambah gambar wisata
        $file = $req->file("file_gambar");
        // Sanitasi nama file
        $sanitize = sanitizeFile($file);
        $gambar = $file->storeAs("images", rand(0, 100) . time() . '-' . $sanitize);

        $data_gambar = [
            "id_paket_wisata" => $id_paket_wisata,
            "file_gambar" => $gambar,
            "status" => 0
        ];
        $insert = DB::table($tbl_gambar)->insert($data_gambar);

        if ($insert) {
            return 201;
        } else {
            return false;
        }
    }

    // Delete Gambar Wisata
    public static function deleteGambar($id_paket_wisata, $id_gambar_wisata)
    {
        // Tabel - tabel
        $tbl_gambar = "gambar_wisata";
        $tbl_paket = "paket_wisata";

        // Cek apakah data paket wisata ditemukan
        $data_paket = DB::table($tbl_paket)
            ->where("id_paket_wisata", "=", $id_paket_wisata)
            ->first();
        if (!$data_paket) {
            return 404;
        }

        // Cek apakah data gambar ditemukan
        $data_gambar = DB::table($tbl_gambar)
            ->where(
                [
                    ["id_gambar_wisata", "=", $id_gambar_wisata],
                    ["id_paket_wisata", "=", $id_paket_wisata],
                ]
            )
            ->first();
        if (!$data_gambar) {
            return 405;
        }

        // Hapus data
        DB::table($tbl_gambar)
            ->where(
                [
                    ["id_gambar_wisata", "=", $id_gambar_wisata],
                    ["id_paket_wisata", "=", $id_paket_wisata],
                ]
            )
            ->delete();
        $path = $data_gambar->file_gambar;
        Storage::delete($path);

        return true;
    }
}
