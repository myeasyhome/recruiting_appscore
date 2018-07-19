@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{  __('Candidates List')}}</div>
                    <div class="card-body">
                        <div class="row float-right">
                            <a href="{{route('candidateCreate')}}" class="btn btn-primary">{{ __('Add Candidate') }}</a>
                        </div>
                        <table id="candidateList" class="table table-striped table-bordered" style="margin-top:45px">
                            <thead>
                            <tr>
                                <th>{{ __('Name')}}</th>
                                <th>{{ __('Role')}}</th>
                                <th>{{ __('Client')}}</th>
                                <th>{{ __('Interview Time')}}</th>
                                <th>{{ __('Rate')}}</th>
                                <th>{{ __('Create Time')}}</th>
                                <th>{{ __('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($candidates as $candidate)
                                <tr>
                                    <td>{{ucfirst(sprintf('%s %s',$candidate->first_name, $candidate->last_name)) }}</td>
                                    <td>{{ $candidate->role_name }}</td>
                                    <td>{{ $candidate->client_name }}</td>
                                    <td>{{ $candidate->interview_time }}</td>
                                    <td>{{ $candidate->rate }}</td>
                                    <td>{{ $candidate->created_at }}</td>
                                    <td><a href="{{ route('candidateUpdate',$candidate->id)}}"
                                           class="btn btn-primary btn-sm">{{ __('Edit Candidate')}} </a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#candidateList').DataTable();
        } );
    </script>
@endsection
