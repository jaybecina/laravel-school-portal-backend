@extends('layouts.app')


@section('content')

<div class="card p-4">
    <div class="card-header px-0 py-2 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Virtual Tour</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.virtual-tour.index') }}"> Back</a>
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
    {!! Form::open(array('route' => ['admin.virtual-tour.update', $virtualTour->id],'method'=>'POST')) !!}
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Title') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Title') }}</label> --}}
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $virtualTour->title }}" placeholder="{{ __('Title') }}" required autocomplete="off" autofocus>
                @error('title')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Description') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Description') }}</label> --}}
                <textarea class="form-control @error('desc') is-invalid @enderror" name="desc" placeholder="{{ __('Description') }}" required autocomplete="off" autofocus>{{ $virtualTour->desc }}</textarea>
                @error('desc')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Video ID') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Video ID') }}</label> --}}
                <input type="text" class="form-control @error('videoId') is-invalid @enderror" name="videoId" value="{{ $virtualTour->videoId }}" placeholder="{{ __('Video ID') }}" required autocomplete="off" autofocus>
                @error('videoId')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Is Active') }}</label>
            <div class="input-group input-group-outline mb-3">
                <select id="is_active" name="is_active" class="form-control @error('is_active') is-invalid @enderror" placeholder="" name="is_active" value="{{ $virtualTour->is_active }}" required>
                    <option value="1" 
                        @if($virtualTour->is_active === "1") 
                            selected
                        @endif
                    >
                        Active
                    </option>
                    <option value="0" 
                        @if($virtualTour->is_active === "0") 
                            selected
                        @endif
                    >
                        Inactive
                    </option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>


@endsection