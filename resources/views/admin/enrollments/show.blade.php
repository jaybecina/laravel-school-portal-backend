@extends('layouts.app')


@section('content')

<div class="card p-4">
    <div class="card-header px-0 py-2 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2> Show Enrollment</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.enrollments.index') }}"> Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Enrollment ID:</strong>
                {{ $enrollment->id }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Enrollment Code:</strong>
                {{ $enrollment->enrollment_code }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Semester:</strong>
                {{ $enrollment->sem }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $enrollment->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Remarks:</strong>
                {{ $enrollment->remarks }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Credits:</strong>
                {{ $enrollment->credits }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Status:</strong>
                {{ $enrollment->status }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            @if(!empty($enrollment->curricula))
                @foreach($enrollment->curricula->unique() as $curriculum)
                    @foreach($curriculum->enrolledCourses()->where('enrollment_id', $enrollment->id)->where('curriculum_id', $curriculum->id)->get()->unique() as $course)
                        <div class="form-group mt-2">
                            <strong>Curriculum: {{  $curriculum->curriculum_code  }}</strong>
                            <br />
                            {{-- <strong>Course ID: {{  $course->id  }}</strong>
                            <br /> --}}
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
                                        @foreach($course->enrolledSubjects()->where('enrollment_id', $enrollment->id)->where('curriculum_id', $curriculum->id)->where('course_id', $course->id)->get() as $subject)
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
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection