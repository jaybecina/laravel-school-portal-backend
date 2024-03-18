@extends('layouts.app')


@section('content')

<div class="card p-4">
    <div class="card-header px-0 py-2 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Create New Subject</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.subjects.index') }}"> Back</a>
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
    {!! Form::open(array('route' => 'admin.subjects.store','method'=>'POST')) !!}
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Subject Code') }}</label> --}}
                <input type="text" class="form-control @error('subject_code') is-invalid @enderror" name="subject_code" value="{{ old('subject_code') }}" placeholder="{{ __('Subject Code') }}" required autocomplete="off" autofocus>
                @error('subject_code')
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
                {{-- <label class="form-label">{{ __('Prerequisite Subject') }}</label> --}}
                {{-- {!! Form::select('prereq_subj[]', $prereq_subj,[], array('class' => 'form-control','multiple')) !!} --}}
                <select name="prereq_subj" class="form-control @error('prereq_subj') is-invalid @enderror" placeholder="" name="prereq_subj">
                    <option value="" selected>Select a Prerequisite Subject</option>
                    @forelse ($prereq_subj as $key => $pre_subj)
                        <option value="{{ $pre_subj->subject_code }}__{{ $pre_subj->name }}">{{ $pre_subj->name }}</option>
                    @empty
                        <option value="">No subject data available for prerequisite subjects</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Prerequisite Subject') }}</label> --}}
                {{-- {!! Form::select('prereq_subj[]', $prereq_subj,[], array('class' => 'form-control','multiple')) !!} --}}
                <select name="teacher" class="form-control @error('teacher') is-invalid @enderror" placeholder="" name="teacher">
                    <option value="" selected>Select Teacher</option>
                    @forelse ($teachers as $key => $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->last_name }}, {{ $teacher->first_name }} {{ $teacher->middle_name }}</option>
                    @empty
                        <option value="">No teacher data available</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Start Time') }}</label> --}}
                <input type="time" class="form-control @error('start_time') is-invalid @enderror" placeholder="{{ __('Start Time') }}" name="start_time" value="{{ old('start_time') }}" required autocomplete="off" autofocus>
                @error('start_time')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('End Time') }}</label> --}}
                <input type="time" class="form-control @error('end_time') is-invalid @enderror" placeholder="{{ __('End Time') }}" name="end_time" value="{{ old('end_time') }}" required autocomplete="off" autofocus>
                @error('end_time')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Day') }}</label> --}}
                <input type="date" class="form-control @error('day') is-invalid @enderror" placeholder="{{ __('Day') }}" name="day" value="{{ old('day') }}" required autocomplete="off" autofocus>
                @error('day')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Room No') }}</label> --}}
                <input type="text" class="form-control @error('room_no') is-invalid @enderror" placeholder="{{ __('Room No') }}" name="room_no" value="{{ old('room_no') }}" required autocomplete="off" autofocus>
                @error('room_no')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Units') }}</label> --}}
                <input type="number" step="any" class="form-control @error('units') is-invalid @enderror" placeholder="{{ __('Units') }}" name="units" value="{{ old('units') }}" required autocomplete="off" autofocus>
                @error('units')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Detail') }}</label> --}}
                <textarea class="form-control @error('detail') is-invalid @enderror" placeholder="{{ __('Detail') }}" name="detail" required autocomplete="off" autofocus>{{ old('detail') }}</textarea>
                @error('detail')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>


@endsection