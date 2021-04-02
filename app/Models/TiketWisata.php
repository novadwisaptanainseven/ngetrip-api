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
    public static function getAll()
    {
        // Tabel - tabel
        $tbl_tiket = "tiket_wisata";
        $tbl_paket = "paket_wisata";
        $tbl_agent = "agent_travel";

        $data_transaksi = DB::table($tbl_tiket)
            ->select(
                "$tbl_tiket.kode_transaksi",
                "$tbl_tiket.tgl_beli as tgl_transaksi",
                "$tbl_tiket.tgl_tiket as tgl_checkin",
                "$tbl_tiket.total_tiket as qty",
                "$tbl_tiket.total_harga",
                "$tbl_tiket.username as pembeli",
                "$tbl_paket.nama_paket_wisata as paket_wisata",
                "$tbl_agent.nama as agent_travel"
            )
            ->leftJoin($tbl_paket, "$tbl_paket.id_paket_wisata", "=", "$tbl_tiket.id_paket_wisata")
            ->leftJoin($tbl_agent, "$tbl_agent.id_agent_travel", "=", "$tbl_paket.id_agent_travel")
            ->orderBy("$tbl_tiket.id_tiket_wisata", "desc")
            ->get();

        // Memberikan nomor urut pada data transaksi
        foreach ($data_transaksi as $i => $item) {
            $item->no = $i + 1;
        }

        // Menghitung total uang yang diperoleh oleh agent travel Derawan Fun Trip
        $tot_harga_derawan_fun_trip = DB::table($tbl_tiket)
            ->select(
                "$tbl_tiket.*",
                "$tbl_paket.nama_paket_wisata",
                "$tbl_agent.nama as agent_travel"
            )
            ->leftJoin($tbl_paket, "$tbl_paket.id_paket_wisata", "=", "$tbl_tiket.id_paket_wisata")
            ->leftJoin($tbl_agent, "$tbl_agent.id_agent_travel", "=", "$tbl_paket.id_agent_travel")
            ->where("$tbl_agent.id_agent_travel", "=", 1)
            ->sum("$tbl_tiket.total_harga");

        // Menghitung total uang yang diperoleh oleh agent travel Trivefun
        $tot_harga_trivefun = DB::table($tbl_tiket)
            ->select(
                "$tbl_tiket.*",
                "$tbl_paket.nama_paket_wisata",
                "$tbl_agent.nama as agent_travel"
            )
            ->leftJoin($tbl_paket, "$tbl_paket.id_paket_wisata", "=", "$tbl_tiket.id_paket_wisata")
            ->leftJoin($tbl_agent, "$tbl_agent.id_agent_travel", "=", "$tbl_paket.id_agent_travel")
            ->where("$tbl_agent.id_agent_travel", "=", 2)
            ->sum("$tbl_tiket.total_harga");

        // Menghitung total uang yang diperoleh oleh agent travel HVTrip
        $tot_harga_hvtrip = DB::table($tbl_tiket)
            ->select(
                "$tbl_tiket.*",
                "$tbl_paket.nama_paket_wisata",
                "$tbl_agent.nama as agent_travel"
            )
            ->leftJoin($tbl_paket, "$tbl_paket.id_paket_wisata", "=", "$tbl_tiket.id_paket_wisata")
            ->leftJoin($tbl_agent, "$tbl_agent.id_agent_travel", "=", "$tbl_paket.id_agent_travel")
            ->where("$tbl_agent.id_agent_travel", "=", 3)
            ->sum("$tbl_tiket.total_harga");

        $output_data = [
            "total_pendapatan_derawan_fun_trip" => $tot_harga_derawan_fun_trip,
            "total_pendapatan_trivefun" => $tot_harga_trivefun,
            "total_pendapatan_hvtrip" => $tot_harga_hvtrip,
            "transaksi" => $data_transaksi,
        ];

        return $output_data;
    }

    // Get All Tiket Wisata by Username
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
