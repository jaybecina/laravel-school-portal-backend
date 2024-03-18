@extends('layouts.app')


@section('content')

<div class="card p-4">
    <div class="card-header px-0 py-2 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Curriculum</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.curricula.index') }}"> Back</a>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
        <div class="alert alert-success text-white" role="alert">
        <p>{{ $message }}</p>
        </div>
        @endif

        @if ($message = Session::get('danger'))
        <div class="alert alert-danger text-white" role="alert">
        <p>{{ $message }}</p>
        </div>
        @endif
        
        @if (count($errors) > 0)
          <div class="alert alert-danger text-white" role="alert">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
               @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
               @endforeach
            </ul>
          </div>
        @endif
    </div>
    {!! Form::open(array('route' => ['admin.curricula.update', $curriculum->id],'method'=>'POST')) !!}
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Curriculum Code') }}</label> --}}
                <input type="text" class="form-control @error('curriculum_code') is-invalid @enderror" name="curriculum_code" value="{{ $curriculum->curriculum_code }}" placeholder="{{ __('Curriculum Code') }}" required autocomplete="off" autofocus>
                @error('curriculum_code')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Name') }}</label> --}}
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $curriculum->name }}" placeholder="{{ __('Name') }}" required autocomplete="off" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Description') }}</label> --}}
                <textarea class="form-control @error('desc') is-invalid @enderror" placeholder="{{ __('Description') }}" name="desc" required autocomplete="off" autofocus>{{ $curriculum->desc }}</textarea>
                @error('desc')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <label class="form-label">{{ __('Credits') }}</label>
                <div class="input-group input-group-outline mb-3">
                    {{-- <label class="form-label">{{ __('Credits') }}</label> --}}
                    <input type="number" class="form-control @error('credits') is-invalid @enderror" placeholder="0" name="credits" value="{{ $curriculum->credits }}" required autocomplete="off" autofocus>
                    @error('credits')
                    <span class="invalid-feedback" role="alert" align=right>
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                {{-- <label class="form-label">{{ __('Current Credits') }}</label> --}}
                <div id="checkedCourseCurrentCreditDiv" class="input-group input-group-outline mb-3">
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Is Active') }}</label>
            <div class="input-group input-group-outline mb-3">
              {{-- <label class="form-label">{{ __('Role') }}</label> --}}
              {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
              <select id="is_active" name="is_active" class="form-control @error('is_active') is-invalid @enderror" placeholder="" name="is_active" value="{{ $curriculum->is_active }}" required>
                    <option value="1" 
                        @if($curriculum->is_active === "True") 
                            selected
                        @endif
                    >
                        Active
                    </option>
                    <option value="0" 
                        @if($curriculum->is_active === "False") 
                            selected
                        @endif
                    >
                        Inactive
                    </option>
              </select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-xs-12 col-sm-12 col-md-6">
                <h4>Edit Courses and Subjects</h4>
                @forelse ($courses as $course)
                    <div class="form-check" style="padding-left: 0 !important;">
                        <input type="checkbox" name="courses[]" value="{{ $course->id }}" class="form-check-course-edit" id="inlineEditCourseCheckbox{{ $course->id }}"
                        @php
                            $courseCodeToCheck = $course->course_code; // The course code you want to check
                            $courseFound = false; // Initialize a variable to track if the course is found

                            // Loop through the $curriculum->courses array to check for the course code
                            foreach ($curriculum->courses->unique() as $curr_course) {
                                if ($curr_course->course_code === $courseCodeToCheck) {
                                    $courseFound = true;
                                    break; // Exit the loop if the course is found
                                }
                            }
                        @endphp

                        @if ($courseFound)
                            checked
                        @endif>
                        <label class="custom-control-label" for="inlineEditCourseCheckbox{{ $course->id }}"><strong>{{ $course->course_code }} - {{ $course->title }}</strong></label>
                    </div>
                    <div class="pt-0 pb-2 px-4" id="divCheckSubjGrp{{ $course->id }}" style="display: none;">
                        @forelse ($subjects as $subject)
                            <div class="form-check" style="padding-left: 0 !important;">
                                <input type="checkbox" name="subjects_{{ $course->id }}[]" value="{{ $subject->id }}" class="form-check-subject{{ $course->id }}" id="inlineEditCourseCheckbox{{ $course->id }}-{{ $subject->id }}"
                                @php
                                    $subjectCodeToCheck = $subject->subject_code; // The subject code you want to check
                                    $subjectFound = false; // Initialize a variable to track if the subject is found

                                    // Loop through the $curriculum->subjects array to check for the subject code
                                    foreach ($course->subjects()->where('curriculum_id', $curriculum->id)->where('course_id', $course->id)->get() as $curr_subject) {
                                        if ($curr_subject->subject_code === $subjectCodeToCheck) {
                                            $subjectFound = true;
                                            break; // Exit the loop if the course is found
                                        }
                                    }
                                @endphp

                                @if ($subjectFound)
                                    checked
                                @endif
                            >
                                <label class="custom-control-label" for="inlineEditCourseCheckbox{{ $course->id }}">{{ $subject->subject_code }} - {{ $subject->name }}</label>
                            </div>
                        @empty
                            <span>No subjects data yet</span>
                        @endforelse
                        @error('subjects_{{ $course->id }}')
                            <span class="invalid-feedback" role="alert" align=right>
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @empty
                    <span>No courses data yet</span>
                @endforelse
                @error('course')
                    <span class="invalid-feedback" role="alert" align=right>
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mb-6">
                <h4>Saved Courses and Subjects</h4>
                @if(!empty($curriculum->courses))
                    @foreach($curriculum->courses->unique() as $course)
                        <input type="hidden" name="saved_curr_ids[]" value="{{ $course->id }}" readonly>
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
                                            @foreach($course->subjects()->where('curriculum_id', $curriculum->id)->where('course_id', $course->id)->get() as $subject)
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
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection