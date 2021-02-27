<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

        $data = [
            "nama" => $req->nama
        ];

        $insert = DB::table($tbl_agent_travel)->insert($data);

        if ($insert) {
            return true;
        } else {
            return false;
        }
    }
}
