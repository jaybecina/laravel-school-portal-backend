@extends('layouts.app')


@section('content')

<div class="card p-4">
    <div class="card-header px-0 py-2 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Create New Curriculum</h2>
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
    {!! Form::open(array('route' => 'admin.curricula.store','method'=>'POST')) !!}
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Curriculum Code') }}</label> --}}
                <input type="text" class="form-control @error('curriculum_code') is-invalid @enderror" name="curriculum_code" value="{{ old('curriculum_code') }}" placeholder="{{ __('Curriculum Code') }}" required autocomplete="off" autofocus>
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
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="{{ __('Name') }}" required autocomplete="off" autofocus>
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
                <textarea class="form-control @error('desc') is-invalid @enderror" placeholder="{{ __('Description') }}" name="desc" required autocomplete="off" autofocus>{{ old('desc') }}</textarea>
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
                    <input type="number" class="form-control @error('credits') is-invalid @enderror" placeholder="0" name="credits" value="{{ old('credits') }}" required autocomplete="off" autofocus>
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
            @forelse ($courses as $course)
                <div class="form-check" style="padding-left: 0 !important;">
                    <input type="checkbox" name="courses[]" value="{{ $course->id }}" class="form-check-course" id="inlineCheckbox{{ $course->id }}">
                    <label class="custom-control-label" for="inlineCheckbox{{ $course->id }}"><strong>{{ $course->course_code }} - {{ $course->title }}</strong></label>
                </div>
                <div class="pt-0 pb-2 px-4" id="divCheckSubjGrp{{ $course->id }}" style="display: none;">
                    @forelse ($subjects as $subject)
                        <div class="form-check" style="padding-left: 0 !important;">
                            <input type="checkbox" name="subjects_{{ $course->id }}[]" value="{{ $subject->id }}" class="form-check-subject{{ $course->id }}" id="inlineCheckbox{{ $course->id }}-{{ $subject->id }}" data-units="{{ $subject->units }}">
                            <label class="custom-control-label" for="inlineCheckbox{{ $course->id }}">{{ $subject->subject_code }} - {{ $subject->name }} --- Units: {{ $subject->units }}</label>
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