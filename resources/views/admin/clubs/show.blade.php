@extends('layouts.app')


@section('content')

<div class="card p-4">
    <div class="card-header px-0 py-2 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2> Show Club</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.clubs.index') }}"> Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <img src={{ url($club->path) }} alt="Image {{ $club->imagename }}" style="width: 350px; height: 350px; object-fit: contain;" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $club->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Details:</strong>
                {{ $club->details }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Is Active:</strong>
                {{ $club->is_active ? 'Active' : 'Inactive' }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group mt-3">
                <strong>Student Members:</strong>
                <br />
                <div class="table-responsive p-0 mt-2">
                    <table class="table table-bordered align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Name</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                @forelse ($club->students as $clubStudent)
                                    <td>
                                        {{ $clubStudent->last_name }}, {{ $clubStudent->first_name }} {{ $clubStudent->middle_name }}
                                    </td>
                                @empty
                                    <td>
                                        No student member yet
                                    </td>
                                @endforelse
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection