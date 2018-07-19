@extends('layouts.app')

@section('content')
    <div class="container">
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{route('home')}}">{{  __('Candidate List')}}</a>
        </nav>
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card">
                    <div class="card-header">{{ __('Add Candidate') }}</div>
                    <form method="get">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                    <div class="card-body">
                        @if (session('error_msg'))
                            <div class="alert alert-danger">
                                {{ session('error_msg') }}
                            </div>
                        @endif
                        <form action="{{route('candidateCreated')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('First Name *')}}</label>
                                <div class="col-md-6">
                                    <input class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                           name="first_name" required autofocus>
                                    @if ($errors->has('first_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('Last Name *')}}</label>
                                <div class="col-md-6">
                                    <input class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                           name="last_name" required autofocus>
                                    @if ($errors->has('last_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('Email *')}}</label>
                                <div class="col-md-6">
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" type="email" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('Phone *')}}</label>
                                <div class="col-md-6">
                                    <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                           name="phone" type="number" required>
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="role"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Role *')}}</label>
                                <div class="col-md-6">
                                    <select id="role"
                                            class="form-control{{ $errors->has('role_id') ? ' is-invalid' : '' }}"
                                            name="role_id">
                                        <option value="0">--</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('role_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('role_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="client"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Client *')}}</label>
                                <div class="col-md-6">
                                    <select id="client"
                                            class="form-control{{ $errors->has('client_id') ? ' is-invalid' : '' }}"
                                            name="client_id">
                                        <option value="0">--</option>
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}">{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('client_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('client_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="recruiter"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Recruiter *')}}</label>
                                <div class="col-md-6">
                                    <select id="recruiter"
                                            class="form-control{{ $errors->has('recruiter_id') ? ' is-invalid' : '' }}"
                                            name="recruiter_id">
                                        <option value="0">--</option>
                                        @foreach($recruiters as $recruiter)
                                            <option value="{{$recruiter->id}}">{{$recruiter->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('recruiter_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('recruiter_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="interviews"
                                       class="col-sm-4 col-form-label text-md-right">{{ __('Interview Time *')}}</label>
                                <div class="col-md-6">
                                    <input class="form-control{{ $errors->has('interviews') ? ' is-invalid' : '' }}"
                                           name="interviews" type="datetime" required>
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
                                    <input id="cv_file_path"
                                           class="form-control{{ $errors->has('cv_file_path') ? ' is-invalid' : '' }}"
                                           name="cv_file_path" type="file">
                                    @if ($errors->has('cv_file_path'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cv_file_path') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('Rate')}}</label>
                                <div class="col-md-6">
                                    <select id="rate" class="form-control" name="rate">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right">{{ __('Comments')}}</label>
                                <div class="col-md-6">
                                    <textarea class="form-control{{ $errors->has('comments') ? ' is-invalid' : '' }}"
                                              name="comments"></textarea>
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
                                        {{ __('Add') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
