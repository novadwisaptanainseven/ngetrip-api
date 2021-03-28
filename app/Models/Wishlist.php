<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = "wishlist";
    protected $primaryKey = "id_wishlist";

    // Insert Wishlist
    public static function insert($req)
    {
        $tbl_wishlist = "wishlist";

        $data = [
            "username" => $req->username,
            "id_paket_wisata" => $req->id_paket_wisata,
        ];

        DB::table($tbl_wishlist)->insert($data);

        return true;
    }

    // Get All Wishlist by Username
    public static function getByUsername($username)
    {
        $tbl_wishlist = "wishlist";
        $tbl_paket = "paket_wisata";
        $tbl_agent = "agent_travel";
        $tbl_gambar = "gambar_wisata";

        $data = DB::table($tbl_wishlist)
            ->where("$tbl_wishlist.username", "=", $username)
            ->leftJoin($tbl_paket, "$tbl_paket.id_paket_wisata", "=", "$tbl_wishlist.id_paket_wisata")
            ->leftJoin($tbl_agent, "$tbl_agent.id_agent_travel", "=", "$tbl_paket.id_agent_travel")
            ->get();

        // Get data gambar utama
        foreach ($data as $d) {
            $gambar = DB::table($tbl_gambar)
                ->where(
                    [
                        ["id_paket_wisata", "=", $d->id_paket_wisata],
                        ["status", "=", 1],
                    ]
                )
                ->first();
            $d->gambar_wisata = $gambar->file_gambar;
        }

        return $data;
    }
}
