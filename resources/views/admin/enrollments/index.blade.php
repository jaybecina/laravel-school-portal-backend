@extends('layouts.app')


@section('content')

<div class="card p-4">
  <div class="card-header px-0 py-2 position-relative z-index-2">
    <div class="row">
      <div class="col-lg-12 margin-tb">
          <div class="pull-left">
              <h2>Enrollments Management</h2>
          </div>
          {!! Form::open(array('route' => 'admin.enrollments.validate-curriculum','method'=>'POST')) !!}
            @csrf
            <div class="d-flex col-lg-7">
              <div class="col-lg-3">
                <div class="form-group mr-3">
                  <div class="input-group input-group-outline mb-3">
                    {{-- <label class="form-label">{{ __('Role') }}</label> --}}
                    {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
                    <select id="curriculum" name="curriculum" class="form-control @error('curriculum') is-invalid @enderror" placeholder="" name="curriculum" value="{{ old('curriculum') }}" required>
                        <option value="" selected>Select a Curriculum</option>
                        @forelse ($curricula as $curriculum)
                            <option value={{ $curriculum->id }}>{{ $curriculum->curriculum_code }}</option>
                        @empty
                            <option value="">No curriculum data yet</option>
                        @endforelse
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group ml-3">
                  <button type="submit" class="btn btn-success"> Create New Enrollment</a>
                </div>
              </div>
            </div>
          {!! Form::close() !!}
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
  <div class="table-responsive">
    <table class="table table-striped align-items-center">
      <tr class="py-4">
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Enrollment Code</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">School Year</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Semester</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Student Name</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Remarks</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Curriculum</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Course</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Subjects</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Status</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="280px">Action</th>
      </tr>
      @foreach ($data as $key => $enrollment)
        <tr>
          <td class="align-middle text-center text-sm">{{ $enrollment->enrollment_code }}</td>
          <td class="align-middle text-center text-sm">{{ $enrollment->school_year }}</td>
          <td class="align-middle text-center text-sm">{{ $enrollment->sem }}</td>
          <td class="align-middle text-center text-sm">{{ $enrollment->student->last_name }}, {{ $enrollment->student->first_name }} {{ $enrollment->student->middle_name }}</td>
          <td class="align-middle text-center text-sm">{{ $enrollment->remarks }}</td>
          <td class="align-middle text-center text-sm">
            <div class="d-flex flex-wrap">
                @if(!empty($enrollment->curricula))
                    @foreach($enrollment->curricula->unique() as $curriculum)
                        <span class="m-1">{{ $curriculum->curriculum_code }}</span>
                    @endforeach
                @endif
            </div>
          </td>
          <td class="align-middle text-center text-sm">
            <div class="d-flex flex-wrap">
                @if(!empty($enrollment->curricula))
                    @foreach($enrollment->curricula->unique() as $curriculum)
                      @foreach($curriculum->enrolledCourses()->where('enrollment_id', $enrollment->id)->where('curriculum_id', $curriculum->id)->get()->unique() as $course)
                        <span class="m-1">{{ $course->course_code }}</span>
                      @endforeach
                    @endforeach
                @endif
            </div>
          </td>
          <td class="align-middle text-center text-sm">
            <div class="d-flex flex-wrap">
                @if(!empty($enrollment->curricula))
                    @foreach($enrollment->curricula->unique() as $curriculum)
                      @foreach($curriculum->enrolledCourses()->where('enrollment_id', $enrollment->id)->where('curriculum_id', $curriculum->id)->get()->unique() as $course)
                        @foreach($course->enrolledSubjects()->where('enrollment_id', $enrollment->id)->where('curriculum_id', $curriculum->id)->where('course_id', $course->id)->get()->unique() as $subject)
                          <span class="badge badge-pill badge-lg bg-gradient-info m-1">{{ $subject->subject_code }}</span>
                        @endforeach
                      @endforeach
                    @endforeach
                @endif
            </div>
          </td>
          <td class="align-middle text-center text-sm">{{ $enrollment->status }}</td>
          <td class="d-flex justify-content-center align-items-center align-middle text-center text-sm pb-0">
            <a class="btn btn-info" href="{{ route('admin.enrollments.show', $enrollment->id) }}">Show</a>
            {!! Form::open(array('route' => 'admin.enrollments.validate-edit-curriculum','method'=>'POST')) !!}
            @csrf
              @foreach ($enrollment->curricula->unique() as $curriculum)
                <input type="hidden" id="enrollment" name="enrollment" class="form-control @error('enrollment') is-invalid @enderror" placeholder="" name="enrollment" value="{{ $enrollment->id }}" required>
                <input type="hidden" id="curriculum_edit" name="curriculum_edit" class="form-control @error('curriculum_edit') is-invalid @enderror" placeholder="" name="curriculum_edit" value="{{ $curriculum->id }}" required>
                <button type="submit" class="btn btn-warning" href="{{ route('admin.enrollments.show', $enrollment->id) }}">Edit</button>
              @endforeach
            {!! Form::close() !!}
            {!! Form::open(['method' => 'DELETE','route' => ['admin.enrollments.destroy', $enrollment->id],'style'=>'display:inline']) !!}
              @csrf
              {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
          </td>
        </tr>
      @endforeach
    </table>
    {{ $data->onEachSide(1)->links() }}
  </div>
</div>




@endsection