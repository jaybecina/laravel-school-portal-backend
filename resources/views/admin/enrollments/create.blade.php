@extends('layouts.app')


@section('content')

<div class="card p-4">
    <div class="card-header px-0 py-2 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Create New Enrollment</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.enrollments.index') }}"> Back</a>
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
    {!! Form::open(array('route' => 'admin.enrollments.store','method'=>'POST')) !!}
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Name') }}</label> --}}
                <input type="text" class="form-control @error('curriculum_name') is-invalid @enderror" name="curriculum_name" value="{{ $curriculum->name }}" placeholder="{{ __('Curriculum Name') }}" required autocomplete="off" autofocus readonly style="border: none;">
                
                <input type="hidden" class="form-control @error('curriculum') is-invalid @enderror" name="curriculum" value="{{ $curriculum->id }}" placeholder="{{ __('Curriculum') }}" required autocomplete="off" autofocus readonly style="border: none;">
                @error('curriculum')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
              {{-- <label class="form-label">{{ __('Role') }}</label> --}}
              {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
              @php
                $currentYear = date('Y');
              @endphp
              <select id="school_year" name="school_year" class="form-control @error('school_year') is-invalid @enderror" placeholder="" name="school_year" value="{{ old('school_year') }}" required>
                    <option value="" selected>Select a School Year</option>
                    @for ($year = $currentYear + 1; $year >= 1985; $year--)
                        <option value="{{ $year }} - {{ $year + 1 }}">{{ $year }} - {{ $year + 1 }}</option>
                    @endfor
              </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
              {{-- <label class="form-label">{{ __('Role') }}</label> --}}
              {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
              <select id="sem" name="sem" class="form-control @error('sem') is-invalid @enderror" placeholder="" name="sem" value="{{ old('sem') }}" required>
                    <option value="" selected>Select a Semester</option>
                    <option value="1st Sem">1st Sem</option>
                    <option value="2nd Sem">2nd Sem</option>
              </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Enrollment Code') }}</label> --}}
                <input type="text" class="form-control @error('enrollment_code') is-invalid @enderror" name="enrollment_code" value="{{ old('enrollment_code') }}" placeholder="{{ __('Enrollment Code') }}" required autocomplete="off" autofocus>
                @error('enrollment_code')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        {{-- <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ __('Name') }}" required autocomplete="off" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div> --}}
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Prerequisite Subject') }}</label> --}}
                {{-- {!! Form::select('prereq_subj[]', $prereq_subj,[], array('class' => 'form-control','multiple')) !!} --}}
                <select name="student_id" class="form-control @error('student_id') is-invalid @enderror" placeholder="">
                    <option value="" selected>Select Student</option>
                    @forelse ($students as $key => $student)
                        <option value="{{ $student->id }}">{{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }}</option>
                    @empty
                        <option value="">No student data available</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Description') }}</label> --}}
                <textarea class="form-control @error('remarks') is-invalid @enderror" placeholder="{{ __('Remarks') }}" name="remarks" required autocomplete="off" autofocus>{{ old('remarks') }}</textarea>
                @error('remarks')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4">
                <label class="form-label">{{ __('Current Credits') }}</label>
                <div class="input-group input-group-outline mb-3">
                    {{-- <label class="form-label">{{ __('Current Credits') }}</label> --}}
                    <input type="number" class="form-control @error('credits') is-invalid @enderror" placeholder="{{ __('Credits') }}" name="credits" id="credits" value="{{ $curriculum->credits }}" required autocomplete="off" autofocus readonly>
                    @error('credits')
                    <span class="invalid-feedback" role="alert" align=right>
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-xs-4 col-sm-4 col-md-4">
                <label class="form-label">{{ __('Required Credits') }}</label>
                <div class="input-group input-group-outline mb-3">
                    {{-- <label class="form-label">{{ __('Credits') }}</label> --}}
                    <input type="number" class="form-control @error('required_credits') is-invalid @enderror" placeholder="{{ __('Required Credits') }}" name="required_credits" id="required_credits" value="{{ $curriculum->credits }}" required autocomplete="off" autofocus readonly style="border: none;">
                    @error('required_credits')
                    <span class="invalid-feedback" role="alert" align=right>
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <input type="hidden" name="course_selected" value="" class="course_selected" id="course-selected" placeholder="course-selected" />
            @forelse ($curriculum->courses->unique() as $course)
                <div class="form-check" style="padding-left: 0 !important;">
                    <input type="radio" name="course" value="{{ $course->id }}" class="form-check-enrcurr-course-create" id="inlineCheckbox{{ $course->id }}"
                    @php
                        $courseCodeToCheck = $course->course_code; // The course code you want to check
                        $courseFound = false; // Initialize a variable to track if the course is found

                        // Loop through the $curriculum->courses array to check for the course code
                        foreach ($curriculum->courses()->where('curriculum_id', $curriculum->id)->get()->unique() as $curr_course) {
                            if ($curr_course->course_code === $courseCodeToCheck) {
                                $courseFound = true;
                                break; // Exit the loop if the course is found
                            }
                        }
                    @endphp

                    @if ($courseFound)
                        {{-- checked --}}
                    @endif>
                    <label class="custom-control-label" for="inlineCheckbox{{ $course->id }}"><strong>{{ $course->course_code }} - {{ $course->title }}</strong></label>
                </div>
                <div class="pt-0 pb-2 px-4" id="divCheckSubjGrp{{ $course->id }}" style="display: none;">
                    @forelse ($subjects as $subject)
                        <div class="form-check" style="padding-left: 0 !important;">
                            <input type="checkbox" name="subjects_{{ $course->id }}[]" value="{{ $subject->id }}" class="form-check-enrcurr-subject-create{{ $course->id }}" id="inlineCheckbox{{ $course->id }}-{{ $subject->id }}" data-units="{{ $subject->units }}"
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
                            disabled
                        >
                            <label class="custom-control-label" for="inlineCheckbox{{ $course->id }}">{{ $subject->subject_code }} - {{ $subject->name }} --- Units: {{ $subject->units }} --- Teacher: {{ $subject->teacher->last_name }}, {{ $subject->teacher->first_name }} {{ $subject->teacher->middle_name }}</label>
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
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection