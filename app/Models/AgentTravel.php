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
