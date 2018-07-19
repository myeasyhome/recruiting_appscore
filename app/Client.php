<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    protected $table = 'clients';

    public function getClients()
    {
        $clients = DB::select('select * from clients');
        return $clients;
    }
}
