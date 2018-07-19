<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Candidate extends Model
{
    protected $table = 'candidates';

    protected $fillable = array('first_name', 'last_name', 'email', 'phone', 'rate', 'cv_file_path', 'comments');

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }

    public function createCandidate($candidate)
    {
        $candidate_id = DB::table('candidates')->insertGetId($candidate, 'id');
        return $candidate_id;
    }

    public function getCandidateById($id)
    {
        $candidate = DB::table('candidates')->where('id', $id)->first();
        return $candidate;
    }

    public function getCandidatesByCriteria(array $criteria)
    {
        if ($criteria) {

        }
        $candidates = DB::select('select * from candidates where role_id = ? and ', array($criteria));
        return $candidates;
    }

    public function getCandidates()
    {
        $candidates = DB::select(
          'select can.*, roles.name as role_name, recruiters.name as recruiter_name, clients.name as client_name, interviews.interview_time from candidates can
            left join roles on roles.id = can.role_id
            left join clients on clients.id = can.client_id
            left join recruiters on recruiters.id = can.recruiter_id
            left join interviews on can.id = interviews.candidate_id
            order by can.id desc');
        return $candidates;
    }

    public function updateCandidate($candidate)
    {
        DB::table('candidates')
          ->where('id', $candidate['id'])
          ->update($candidate);
        return $candidate;
    }
}
