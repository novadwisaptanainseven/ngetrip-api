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

        // Cek apakah data wishlist sudah ada
        $data_wishlist = DB::table($tbl_wishlist)
            ->where("id_paket_wisata", "=", $req->id_paket_wisata)
            ->first();
        if (!$data_wishlist) {
            $data = [
                "username" => $req->username,
                "id_paket_wisata" => $req->id_paket_wisata,
            ];

            DB::table($tbl_wishlist)->insert($data);

            return true;
        } else {
            DB::table($tbl_wishlist)
                ->where("id_paket_wisata", "=", $req->id_paket_wisata)
                ->delete();
            return false;
        }
    }

    // Get All Wishlist by Username
    public static function getByUsername($username)
    {
        $tbl_wishlist = "wishlist";

        $data = DB::table($tbl_wishlist)
            ->where("username", "=", $username)
            ->get();

        return $data;
    }
}
