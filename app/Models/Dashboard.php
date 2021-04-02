<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Model
{
    use HasFactory;

    // Get Dashboard Information
    public static function getDashboardInformation()
    {
        // Tabel - tabel
        $tbl_paket = "paket_wisata";
        $tbl_agent = "agent_travel";
        $tbl_transaksi = "tiket_wisata";

        $tot_paket = DB::table($tbl_paket)->get()->count();
        $tot_agent = DB::table($tbl_agent)->get()->count();
        $tot_transaksi = DB::table($tbl_transaksi)->get()->count();

        $output = [
            "total_paket_wisata" => $tot_paket,
            "total_agent_travel" => $tot_agent,
            "total_transaksi" => $tot_transaksi,
        ];


        return $output;
    }
}
