<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AgentTravel extends Model
{
    use HasFactory;

    protected $table = "agent_travel";
    protected $primaryKey = "id_agent_travel";

    // Get All Agent Travel
    public static function getById($id_agent_travel)
    {
        // Tabel - tabel
        $tbl_agent_travel = 'agent_travel';
        $tbl_kontak = 'kontak_agent_travel';

        // Cek apakah data agent travel ditemukan
        $data_agent = DB::table($tbl_agent_travel)
            ->where("id_agent_travel", "=", $id_agent_travel)
            ->first();
        if (!$data_agent) {
            return null;
        }

        $kontak_agent = DB::table($tbl_kontak)
            ->where("id_agent_travel", "=", $id_agent_travel)
            ->get();

        $data_agent->kontak = $kontak_agent;

        return $data_agent;
    }

    // Insert Agent Travel
    public static function insert($req)
    {
        // Tabel - tabel
        $tbl_agent_travel = 'agent_travel';

        // Tambah gambar wisata
        $file = $req->file("gambar");
        // Sanitasi nama file
        $sanitize = sanitizeFile($file);
        $gambar = $file->storeAs("images", rand(0, 100) . time() . '-' . $sanitize);

        $data = [
            "nama" => $req->nama,
            "alamat" => $req->alamat,
            "deskripsi" => $req->deskripsi,
            "gambar" => $gambar,
        ];

        $insert = DB::table($tbl_agent_travel)->insert($data);

        if ($insert) {
            return true;
        } else {
            return false;
        }
    }

    // Edit Agent Travel
    public static function edit($req, $id)
    {
        // Tabel - tabel
        $tbl_agent_travel = 'agent_travel';

        $data_agent = DB::table($tbl_agent_travel)->where("id_agent_travel", "=", $id)->first();
        if (!$data_agent) {
            return null;
        }

        if ($req->hasFile("gambar")) {
            $path = $data_agent->gambar;
            Storage::delete($path);

            // Tambah gambar wisata
            $file = $req->file("gambar");
            // Sanitasi nama file
            $sanitize = sanitizeFile($file);
            $gambar = $file->storeAs("images", rand(0, 100) . time() . '-' . $sanitize);
        } else {
            $gambar = $data_agent->gambar;
        }

        $data = [
            "nama" => $req->nama,
            "alamat" => $req->alamat,
            "deskripsi" => $req->deskripsi,
            "gambar" => $gambar,
        ];

        DB::table($tbl_agent_travel)->where("id_agent_travel", "=", $id)->update($data);

        return true;
    }

    // Get All Kontak
    public static function getAllKontak($id_agent_travel)
    {
        $tbl_kontak = "kontak_agent_travel";

        $data = DB::table($tbl_kontak)
            ->where("id_agent_travel", "=", $id_agent_travel)
            ->get();

        return $data;
    }

    // Get Kontak By ID
    public static function getKontakById($id_agent_travel, $id_kontak)
    {
        $tbl_kontak = "kontak_agent_travel";

        $data = DB::table($tbl_kontak)
            ->where([
                ["id_agent_travel", "=", $id_agent_travel],
                ["id_kontak", "=", $id_kontak],
            ])
            ->first();

        return $data;
    }

    // Insert Kontak
    public static function insertKontak($req, $id_agent_travel)
    {
        // Tabel - tabel
        $tbl_kontak = 'kontak_agent_travel';

        $data = [
            "id_agent_travel" => $id_agent_travel,
            "nama" => $req->nama,
            "kontak" => $req->kontak,
        ];

        DB::table($tbl_kontak)->insert($data);

        return true;
    }

    // Edit Kontak
    public static function editKontak($req, $id_agent_travel, $id_kontak)
    {
        // Tabel - tabel
        $tbl_kontak = 'kontak_agent_travel';

        // Cek apakah data ditemukan
        $data_kontak = DB::table($tbl_kontak)
            ->where([
                ["id_agent_travel", "=", $id_agent_travel],
                ["id_kontak", "=", $id_kontak],
            ])
            ->first();
        if (!$data_kontak) {
            return 404;
        }

        $data = [
            "nama" => $req->nama,
            "kontak" => $req->kontak,
        ];

        $update = DB::table($tbl_kontak)
            ->where([
                ["id_agent_travel", "=", $id_agent_travel],
                ["id_kontak", "=", $id_kontak],
            ])
            ->update($data);



        return $update;
    }
}
