@extends('layouts.app')


@section('content')

<div class="card p-4">
    <div class="card-header px-0 py-2 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Create New Event</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.events.index') }}"> Back</a>
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
    {!! Form::open(array('route' => 'admin.events.store','method'=>'POST', 'enctype'=>'multipart/form-data')) !!}
    @csrf
    <div class="row">
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
                {{-- <label class="form-label">{{ __('Details') }}</label> --}}
                <textarea class="form-control @error('details') is-invalid @enderror" name="details" placeholder="{{ __('Details') }}" required autocomplete="off" autofocus>{{ old('details') }}</textarea>
                @error('details')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <label class="form-label">{{ __('Start Date') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Start Date') }}</label> --}}
                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}" placeholder="" required autocomplete="off" autofocus>
                @error('start_date')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <label class="form-label">{{ __('End Date') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('End Date') }}</label> --}}
                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" placeholder="" required autocomplete="off" autofocus>
                @error('end_date')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Speaker Name') }}</label> --}}
                <input type="text" class="form-control @error('speaker_name') is-invalid @enderror" name="speaker_name" value="{{ old('speaker_name') }}" placeholder="{{ __('Speaker Name') }}" required autocomplete="off" autofocus>
                @error('speaker_name')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Name') }}</label> --}}
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" placeholder="{{ __('Upload Image') }}" required autocomplete="off" autofocus>
                @error('image')
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