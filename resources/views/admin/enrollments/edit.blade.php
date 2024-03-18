@extends('layouts.app')


@section('content')

<div class="card p-4">
    <div class="card-header px-0 py-2 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Enrollment</h2>
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
    {!! Form::open(array('route' => ['admin.enrollments.update', $enrollment->id],'method'=>'POST')) !!}
    @csrf
    @method('PUT')
    <div class="row">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3" id="currentCurrDiv">
                
                <input type="hidden" class="form-control @error('edit_curriculum_toggle') is-invalid @enderror" name="edit_curriculum_toggle" value="{{ $isEditCurriculum === true ? true : false }}" placeholder="{{ __('edit_curriculum_toggle') }}" required autocomplete="off" autofocus readonly>

                <label class="form-label">{{ __('Curriculum Code') }}</label>
                <div class="input-group input-group-outline mb-3">
                    {{-- <label class="form-label">{{ __('Curriculum Code') }}</label> --}}
                    <input type="text" class="form-control @error('curriculum_code') is-invalid @enderror" name="curriculum_code" value="{{ $isEditCurriculum === true ? $curriculumURLParam->curriculum_code : $curriculum->curriculum_code }}" placeholder="{{ __('Curriculum Code') }}" required autocomplete="off" autofocus readonly style="border: none;">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 d-none" id="currEditSelectDiv">
                <label class="form-label">{{ __('Curriculum Code') }}</label>
                <div class="input-group input-group-outline mb-3">
                    {{-- <label class="form-label">{{ __('Role') }}</label> --}}
                    {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
                    <select id="currEditSelect" name="sem" class="form-control @error('currEditSelect') is-invalid @enderror" placeholder="" name="currEditSelect" value="{{ old('currEditSelect') }}">
                        <option value="" selected>Select a Curriculum Code</option>
                        @forelse ($select_curriculum as $sel_curr)
                            <option value="{{ $sel_curr->id }}">{{ $sel_curr->curriculum_code }} ( {{ $sel_curr->name }} )</option>
                        @empty
                            <option value="">No courses data yet</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4" style="margin-top: 32px;" id="currEditDiv">
                <button type="button" class="btn btn-primary" href="#" id="currEditBtn"> Edit Curriculum Code</a>
                <button type="button" class="btn btn-primary d-none" href="#" id="currCancelEditBtn"> Cancel Edit Curriculum Code</a>
                <button type="button" class="btn btn-primary d-none" href="#" id="currCancelEditBtn"> Cancel Edit Curriculum Code</a>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Curriculum Name') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Curriculum Name') }}</label> --}}
                <input type="text" class="form-control @error('curriculum_name') is-invalid @enderror" name="curriculum_name" value="{{ $isEditCurriculum === true ? $curriculumURLParam->name : $curriculum->name }}" placeholder="{{ __('Curriculum Name') }}" required autocomplete="off" autofocus readonly style="border: none;">
                
                <input type="hidden" class="form-control @error('curriculum') is-invalid @enderror" name="curriculum" value="{{ $isEditCurriculum === true ? $curriculumURLParam->id : $curriculum->id }}" placeholder="{{ __('Curriculum') }}" required autocomplete="off" autofocus readonly style="border: none;">
                @error('curriculum')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('School Year') }}</label>
            <div class="input-group input-group-outline mb-3">
              {{-- <label class="form-label">{{ __('Role') }}</label> --}}
              {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
              @php
                $currentYear = date('Y');
              @endphp
              <select id="school_year" name="school_year" class="form-control @error('school_year') is-invalid @enderror" placeholder="" name="school_year" value="{{ $enrollment->school_year }}" required>
                <option value={{ $enrollment->school_year }}>{{ $enrollment->school_year }}</option>
                    @for ($year = $currentYear + 1; $year >= 1985; $year--)
                        @php 
                            $school_year = $year . " - " . $year + 1;
                        @endphp
                        <option value={{ $school_year }}>{{ $school_year }}</option>
                    @endfor
              </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Semester') }}</label>
            <div class="input-group input-group-outline mb-3">
              {{-- <label class="form-label">{{ __('Role') }}</label> --}}
              {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
              <select id="sem" name="sem" class="form-control @error('sem') is-invalid @enderror" placeholder="" name="sem" value="{{ $enrollment->sem }}" required>
                    <option value="1st Sem" 
                        @if($enrollment->sem === "1st Sem") 
                            selected
                        @endif
                    >
                        1st Sem
                    </option>
                    <option value="2nd Sem" 
                        @if($enrollment->sem === "2nd Sem") 
                            selected
                        @endif
                    >
                        2nd Sem
                    </option>
              </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Enrollment Code') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Enrollment Code') }}</label> --}}
                <input type="text" class="form-control @error('enrollment_code') is-invalid @enderror" name="enrollment_code" value="{{ $enrollment->enrollment_code }}" placeholder="{{ __('Curriculum Code') }}" required autocomplete="off" autofocus>
                @error('enrollment_code')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Student Name') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Prerequisite Subject') }}</label> --}}
                {{-- {!! Form::select('prereq_subj[]', $prereq_subj,[], array('class' => 'form-control','multiple')) !!} --}}
                <select name="student_id" class="form-control @error('student_id') is-invalid @enderror" placeholder="">
                    <option value="" selected>Select Student</option>
                    @forelse ($students as $key => $student)
                        <option value="{{ $student->id }}"
                            @if($enrollment->student_id === $student->id) 
                                selected
                            @endif
                        >
                            {{ $student->last_name }}, {{ $student->first_name }} {{ $student->middle_name }}
                        </option>
                    @empty
                        <option value="">No student data available</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Remarks') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Description') }}</label> --}}
                <textarea class="form-control @error('remarks') is-invalid @enderror" placeholder="{{ __('Remarks') }}" name="remarks" required autocomplete="off" autofocus>{{ $enrollment->remarks }}</textarea>
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
                    <input type="number" class="form-control @error('credits') is-invalid @enderror" placeholder="{{ __('Credits') }}" name="credits" id="credits" value="{{ $enrollment->credits }}" required autocomplete="off" autofocus readonly>
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
            <label class="form-label">{{ __('Status') }}</label>
            <div class="input-group input-group-outline mb-3">
              {{-- <label class="form-label">{{ __('Role') }}</label> --}}
              {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
              <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" placeholder="" name="status" value="{{ $enrollment->status }}" required>
                    <option value="Active" 
                        @if($enrollment->status === "Active") 
                            selected
                        @endif
                    >
                        Active
                    </option>
                    <option value="Inactive" 
                        @if($enrollment->status === "Inactive") 
                            selected
                        @endif
                    >
                        Inactive
                    </option>
                    <option value="Transferred" 
                        @if($enrollment->status === "Transferred") 
                            selected
                        @endif
                    >
                        Transferred
                    </option>
                    <option value="Blacklisted" 
                        @if($enrollment->status === "Blacklisted") 
                            selected
                        @endif
                    >
                        Blacklisted
                    </option>
              </select>
            </div>
        </div>
        <hr />
        <div class="col-xs-6 col-sm-6 col-md-6">
            <h5 class="my-3">Edit Information of Course & Subjects</h5>
            @foreach($enrollment->curricula->unique() as $curriculum)
                @foreach($curriculum->enrolledCourses()->where('enrollment_id', $enrollment->id)->where('curriculum_id', $curriculum->id)->get()->unique() as $course)
                    <input type="hidden" name="course_selected" value="{{ $course->id }}" class="course_selected" id="course-selected" placeholder="course-selected" readonly />
                @endforeach
            @endforeach

            @if($isEditCurriculum === true)
                @forelse ($curriculumURLParam->courses->unique() as $course)
                    <div class="form-check" style="padding-left: 0 !important;">
                        <input type="radio" name="course" value="{{ $course->id }}" class="form-check-enrcurr-course-create" id="inlineCheckbox{{ $course->id }}"
                        @php
                            $courseCodeToCheck = $course->course_code; // The course code you want to check
                            $courseFound = false; // Initialize a variable to track if the course is found

                            // Loop through the $curriculum->courses array to check for the course code
                            foreach ($curriculumURLParam->courses()->where('curriculum_id', $curriculumURLParam->id)->get()->unique() as $curr_course) {
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
                                    foreach ($course->subjects()->where('curriculum_id', $curriculumURLParam->id)->where('course_id', $course->id)->get() as $curr_subject) {
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
                                <label class="custom-control-label" for="inlineCheckbox{{ $course->id }}">{{ $subject->subject_code }} - {{ $subject->name }} - {{ $subject->units }} units</label>
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
            @else
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
                                <label class="custom-control-label" for="inlineCheckbox{{ $course->id }}">{{ $subject->subject_code }} - {{ $subject->name }} - {{ $subject->units }} units</label>
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
            @endif
            @error('course')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <h5 class="my-3">Saved Information of Curriculum, Course & Subjects</h5>
            @if(!empty($enrollment->curricula))
                @foreach($enrollment->curricula->unique() as $curriculum)
                    @foreach($curriculum->enrolledCourses()->where('enrollment_id', $enrollment->id)->where('curriculum_id', $curriculum->id)->get()->unique() as $course)
                        <div class="form-group mt-2">
                            <input type="hidden" class="form-control @error('saved_curr_id') is-invalid @enderror" name="saved_curr_id" value="{{ $curriculum->id }}" placeholder="{{ __('Curriculum ID') }}" autocomplete="off" autofocus>
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
                                            {{-- <span class="m-1">{{ $subject->id }} | {{ $subject->subject_code }} --- Units: {{ $subject->units }} --- Teacher: {{ $subject->teacher->last_name }}, {{ $subject->teacher->first_name }} {{ $subject->teacher->middle_name }}</span><br /> --}}
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
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection