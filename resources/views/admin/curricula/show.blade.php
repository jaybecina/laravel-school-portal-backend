@extends('layouts.app')


@section('content')

<div class="card p-4">
    <div class="card-header px-0 py-2 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2> Show Curriculum</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.curricula.index') }}"> Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Curriculum ID:</strong>
                {{ $curriculum->id }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Curriculum Code:</strong>
                {{ $curriculum->curriculum_code }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $curriculum->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Description:</strong>
                {{ $curriculum->desc }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Is Active:</strong>
                {{ $curriculum->is_active === 1 ? "Active" : "Inactive" }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            @if(!empty($curriculum->courses))
                @foreach($curriculum->courses()->where('curriculum_id', $curriculum->id)->get()->unique() as $course)
                    <div class="form-group mt-2">
                        <strong>ID: {{  $course->id  }}</strong>
                        <br />
                        <strong>Course: {{  $course->course_code  }}</strong>
                        <br />

                        <div class="mt-1 mb-3">
                            <strong>Subjects:</strong>
                            <br />
                            <div class="table-responsive p-0 mt-2">
                                <table class="table table-bordered align-items-center mb-0">
                                  <thead>
                                    <tr>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Subject Code</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Subject Name</th>
                                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Units</th>
                                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Teacher</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                        @foreach($course->subjects()->where('curriculum_id', $curriculum->id)->where('course_id', $course->id)->get()->unique() as $subject)
                                            <tr class="text-center">
                                                <td>
                                                    {{ $subject->subject_code }}
                                                </td>
                                                <td>
                                                    {{ $subject->name }}
                                                </td>
                                                <td>
                                                    {{ $subject->units }}
                                                </td>
                                                <td>
                                                    {{ $subject->teacher->last_name }}, {{ $subject->teacher->first_name }} {{ $subject->teacher->middle_name }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection