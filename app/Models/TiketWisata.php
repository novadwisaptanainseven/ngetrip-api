<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TiketWisata extends Model
{
    use HasFactory;

    protected $table = "tiket_wisata";
    protected $primaryKey = "id_tiket_wisata";

    // Get All Tiket Wisata
    public static function getByUsername($username)
    {
        // Tabel - tabel
        $tbl_tiket = "tiket_wisata";
        $tbl_paket = "paket_wisata";

        $data = DB::table($tbl_tiket)
            ->where("$tbl_tiket.username", "=", $username)
            ->leftJoin($tbl_paket, "$tbl_paket.id_paket_wisata", "=", "$tbl_tiket.id_paket_wisata")
            ->orderBy("$tbl_tiket.id_tiket_wisata", "desc")
            ->get();

        if ($data) {
            return $data;
        } else {
            return null;
        }
    }

    // Get Tiket Wisata By Id
    public static function getById($id)
    {
        // Tabel - tabel
        $tbl_tiket = "tiket_wisata";
        $tbl_paket = "paket_wisata";
        $tbl_agent = "agent_travel";

        $data = DB::table($tbl_tiket)
            ->where("$tbl_tiket.id_tiket_wisata", "=", $id)
            ->leftJoin($tbl_paket, "$tbl_paket.id_paket_wisata", "=", "$tbl_tiket.id_paket_wisata")
            ->leftJoin($tbl_agent, "$tbl_agent.id_agent_travel", "=", "$tbl_paket.id_agent_travel")
            ->first();

        if ($data) {
            return $data;
        } else {
            return null;
        }
    }

    // Insert / Beli Paket Wisata
    public static function insert($req)
    {
        // Tabel - Tabel
        $tbl_tiket = "tiket_wisata";

        // $current_date = date("d-m-Y");

        $data = [
            "username" => $req->username,
            "id_paket_wisata" => $req->id_paket_wisata,
            "tgl_tiket" => $req->tgl_tiket,
            "total_tiket" => $req->total_tiket,
            "total_harga" => $req->total_harga,
            "kode_transaksi" => $req->kode_transaksi,
        ];

        DB::table($tbl_tiket)->insert($data);

        return true;
    }
}
