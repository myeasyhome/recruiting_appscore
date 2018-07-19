<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Recruiter extends Model
{
    protected $table = 'recruiters';

    public function getRecruiters()
    {
        $recruiters = DB::select('select * from recruiters');
        return $recruiters;
    }
}
