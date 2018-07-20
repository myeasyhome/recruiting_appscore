<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Client;
use App\Interviews;
use App\Recruiter;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CandidateController extends Controller
{
    protected $candidate_model;
    protected $client_model;
    protected $recruiter_model;
    protected $role_model;
    protected $interview_model;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->candidate_model = new Candidate();
        $this->role_model = new Role();
        $this->recruiter_model = new Recruiter();
        $this->client_model = new Client();
        $this->interview_model = new Interviews();
    }

    public function validatorCreate(array $data, $message = null)
    {
        return Validator::make($data, [
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:candidates',
          'role_id' => 'exists:roles,id',
          'client_id' => 'exists:clients,id',
          'recruiter_id' => 'exists:recruiters,id',
        ], $message);
    }

    public function validatorUpdate(array $data, $message = null, $id = null)
    {
        return Validator::make($data, [
          'first_name' => 'required|string|max:255',
          'last_name' => 'required|string|max:255',
          'email' => ['required', Rule::unique('candidates')->ignore($id)]
        ], $message);
    }

    /**
     * custom the message array
     *
     * @return array
     */
    public function messages()
    {
        return [
          'first_name.required' => 'You must input first name',
          'last_name.required' => 'You must input last name',
          'email.required' => 'You must input email',
          'email.unique' => 'This email already existed.',
          'role_id.exists' => 'Please select a role.',
          'client_id.exists' => 'Please select a client.',
          'recruiter_id.exists' => 'Please select a recruiter.'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function query(Request $request)
    {

        $criteria = array(
          'created_at' => $request->created_at,
          'role_id' => $request->role_id,
          'rate' => $request->rate
        );
        $candidates = $this->candidate_model->getCandidatesByCriteria($criteria);
        $roles = $this->role_model->getRoles();
        $clients = $this->client_model->getClients();
        $recruiters = $this->recruiter_model->getRecruiters();
        if ($candidates) {
            return view('home', array(
              'candidates' => $candidates,
              'roles' => $roles,
              'clients' => $clients,
              'recruiters' => $recruiters,
              'criteria' => $criteria));
        }
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->role_model->getRoles();
        $clients = $this->client_model->getClients();
        $recruiters = $this->recruiter_model->getRecruiters();
        return view('candidateCreate', array(
          'roles' => $roles,
          'clients' => $clients,
          'recruiters' => $recruiters));
    }

    private function upload(Request $request)
    {
        $file_absolute_path = '';
        if ($request->hasFile('cv_file_path')) {
            $cv_file = $request->file('cv_file_path');
            $file_name = md5(uniqid()) . '.' . $cv_file->getClientOriginalExtension();
            $file_absolute_path = 'upload' . DIRECTORY_SEPARATOR . 'cv_files' . DIRECTORY_SEPARATOR . $file_name;
            $cv_file->move(public_path() . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'cv_files' . DIRECTORY_SEPARATOR, $file_name);
        }
        return $file_absolute_path;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentTime = new \DateTime();

        $this->validatorCreate($request->all(), $this->messages())->validate();

        // upload cv file
        $file_absolute_path = $this->upload($request);
        if ($request->cv_file_path && !$file_absolute_path) {
            return redirect()->back()->with('error_msg', 'Upload CV failed, Please try again');
        }

        $candidate = array(
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'email' => $request->email,
          'phone' => $request->phone,
          'rate' => $request->rate,
          'cv_file_path' => $file_absolute_path,
          'comments' => $request->comments,
          'role_id' => $request->role_id,
          'recruiter_id' => $request->recruiter_id,
          'client_id' => $request->client_id,
          'created_at' => $currentTime,
          'updated_at' => $currentTime
        );

        $candidates = $this->candidate_model->getCandidates();
        $candidate_id = $this->candidate_model->createCandidate($candidate);
        if ($candidate_id) {
            $interviews = array(
              'interview_time' => new \DateTime($request->interviews),
              'candidate_id' => $candidate_id,
              'created_at' => $currentTime,
              'updated_at' => $currentTime
            );
            if ($this->interview_model->createInterviews($interviews)) {
                $candidates = $this->candidate_model->getCandidates();
            }
        };
        return view('home', array('candidates' => $candidates));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $candidate = $this->candidate_model->getCandidateById($id);
        $interviews = $this->interview_model->getInterviewsByCandidateID($id);
        $roles = $this->role_model->getRoles();
        $clients = $this->client_model->getClients();
        $recruiters = $this->recruiter_model->getRecruiters();
        return view('candidateUpdate', array(
          'candidate' => $candidate,
          'interviews' => $interviews,
          'roles' => $roles,
          'clients' => $clients,
          'recruiters' => $recruiters));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $currentTime = new \DateTime();

        // validate the current form post
        $this->validatorUpdate($request->all(), $this->messages(), $id)->validate();

        //get the current candidate by id
        $candidate = $this->candidate_model->getCandidateById($id);

        // upload cv file
        $file_absolute_path = $this->upload($request);

        // get file upload from request but have not upload successfully
        if ($request->cv_file_path && !$file_absolute_path) {
            return redirect()->back()->with('error_msg', 'Upload CV failed, Please try again');
        }

        // already have cv file and have not upload new one, then apply the old path
        if ($candidate->cv_file_path && !$file_absolute_path) {
            $file_absolute_path = $candidate->cv_file_path;
        }

        $candidate = array(
          'id' => $id,
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'email' => $request->email,
          'phone' => $request->phone,
          'rate' => $request->rate,
          'cv_file_path' => $file_absolute_path,
          'comments' => $request->comments,
          'role_id' => $request->role_id,
          'recruiter_id' => $request->recruiter_id,
          'client_id' => $request->client_id,
          'updated_at' => $currentTime
        );

        if ($this->candidate_model->updateCandidate($candidate)) {
            if ($request->interviews_id) {
                // update the old interview id
                $interviews = array(
                  'id' => $request->interviews_id,
                  'interview_time' => new \DateTime($request->interviews),
                  'candidate_id' => $id,
                  'updated_at' => $currentTime
                );
                if ($this->interview_model->updateInterviews($interviews)) {
                    return redirect()->back()->with('candidate_success', 'Candidate updated successfully');
                }
            } else {
                // create new interview time
                $interviews = array(
                  'interview_time' => new \DateTime($request->interviews),
                  'candidate_id' => $id,
                  'created_at' => $currentTime,
                  'updated_at' => $currentTime
                );
                if ($this->interview_model->createInterviews($interviews)) {
                    return redirect()->back()->with('candidate_success', 'Candidate updated successfully');
                }
            }
        };
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
