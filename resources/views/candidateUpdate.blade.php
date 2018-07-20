@extends('layouts.app')

@section('content')
    <div class="container">
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{route('home')}}">{{  __('Candidate List')}}</a>
        </nav>
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card">
                    <div class="card-header">{{ __('Update Candidate') }}</div>
                    <form method="get">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                    <div class="card-body">
                        @if (session('candidate_success'))
                            <div class="alert alert-success">
                                {{ session('candidate_success') }}
                            </div>
                        @endif
                        @if (session('error_msg'))
                            <div class="alert alert-danger">
                                {{ session('error_msg') }}
                            </div>
                        @endif
                        <form action="{{route('candidateUpdated',$candidate->id)}}" method="post"
                              enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('First Name')}}</label>
                                <div class="col-md-6">
                                    <input class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                           name="first_name" value="{{$candidate->first_name}}" required autofocus>
                                    @if ($errors->has('first_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('Last Name')}}</label>
                                <div class="col-md-6">
                                    <input class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                           name="last_name" value="{{$candidate->last_name}}" required autofocus>
                                    @if ($errors->has('last_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('Email')}}</label>
                                <div class="col-md-6">
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" type="email" value="{{$candidate->email}}" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('Phone')}}</label>
                                <div class="col-md-6">
                                    <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                           name="phone" type="number" value="{{$candidate->phone}}" required>
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role" class="col-sm-4 col-form-label text-md-right">{{ __('Role')}}</label>
                                <div class="col-md-6">
                                    <select id="role" class="form-control" name="role_id">
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}" {{$role->id != $candidate->role_id ?:'selected'}}>{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="client"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Client')}}</label>
                                <div class="col-md-6">
                                    <select id="client" class="form-control" name="client_id">
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}" {{$client->id != $candidate->client_id ?:'selected'}}>{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="recruiter"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Recruiter')}}</label>
                                <div class="col-md-6">
                                    <select id="recruiter" class="form-control" name="recruiter_id">
                                        @foreach($recruiters as $recruiter)
                                            <option value="{{$recruiter->id}}" {{$recruiter->id != $candidate->recruiter_id ?:'selected'}}>{{$recruiter->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="interviews"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Interview Time')}}</label>
                                <div class="col-md-6">
                                    <input id='interviews_date'
                                           class="form-control{{ $errors->has('interviews') ? ' is-invalid' : '' }}"
                                           name="interviews" value="{{ $interviews? Carbon\Carbon::parse($interviews->interview_time)->format('Y-m-d'):''}}"
                                           type="datetime" required>
                                    <input type="hidden" name="interviews_id"
                                           value="{{$interviews?$interviews->id:''}}">
                                    @if ($errors->has('interviews'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('interviews') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('CV File')}}</label>
                                <div class="col-md-6">
                                    <input class="form-control{{ $errors->has('cv_file_path') ? ' is-invalid' : '' }}"
                                           name="cv_file_path" type="file">
                                    @if ($errors->has('cv_file_path'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cv_file_path') }}</strong>
                                        </span>
                                    @endif
                                    @if($candidate->cv_file_path)
                                        <a class="btn btn-link"
                                           href={{ asset($candidate->cv_file_path) }}>{{__('Download CV')}}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('Rate')}}</label>
                                <div class="col-md-6">
                                    <select id="rate" class="form-control" name="rate">
                                        @for($i =1; $i <=10;$i++)
                                            <option value="{{$i}}" {{$i != $candidate->rate ?:'selected'}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('Comments')}}</label>
                                <div class="col-md-6">
                                    <textarea class="form-control{{ $errors->has('comments') ? ' is-invalid' : '' }}"
                                              name="comments">{{ $candidate->comments}}</textarea>
                                    @if ($errors->has('comments'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('comments') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#interviews_date').datepicker({
            defaultDate: new Date(),
            format: 'yyyy-mm-dd',
            sideBySide: true
        });
    </script>
@endsection
