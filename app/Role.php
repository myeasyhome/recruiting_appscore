<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    protected $table = 'roles';

    public function getRoles()
    {
        $roles = DB::select('select * from roles');
        return $roles;
    }
}
