@extends('layouts.app')


@section('content')

<div class="card p-4">
    <div class="card-header px-0 py-2 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit User</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.users.index') }}"> Back</a>
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
    {!! Form::open(array('route' => ['admin.users.update', $user->id],'method'=>'POST')) !!}
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('First Name') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('First Name') }}</label> --}}
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $user->first_name }}" placeholder="{{ __('First Name') }}" required autocomplete="off" autofocus>
                @error('first_name')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Middle Name') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Middle Name') }}</label> --}}
                <input type="text" class="form-control @error('middle_name') is-invalid @enderror" name="middle_name" value="{{ $user->middle_name }}" placeholder="{{ __('Middle Name') }}" required autocomplete="off" autofocus>
                @error('middle_name')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Last Name') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Last Name') }}</label> --}}
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" placeholder="{{ __('Last Name') }}" name="last_name" value="{{ $user->last_name }}" required autocomplete="off" autofocus>
                @error('last_name')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Contact Number') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Contact Number') }}</label> --}}
                <input type="text" class="form-control @error('contact_num') is-invalid @enderror" placeholder="{{ __('Contact Number') }}" name="contact_num" value="{{ $user->contact_num }}" required autocomplete="off" autofocus>
                @error('contact_num')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Email Address') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Email Address') }}</label> --}}
                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Email Address') }}" name="email" value="{{ $user->email }}" required autocomplete="off" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Password') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Password') }}</label> --}}
                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password" value="{{ old('password') }}" required autocomplete="off" autofocus>
                @error('password')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Confirm Password') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Confirm Password') }}</label> --}}
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="off" autofocus>
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert" align=right>
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <label class="form-label">{{ __('Role') }}</label>
            <div class="input-group input-group-outline mb-3">
                {{-- <label class="form-label">{{ __('Role') }}</label> --}}
                {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
                <select name="roles[]" class="form-control @error('role') is-invalid @enderror" placeholder="" name="role" value="{{ old('roles') }}" required>
                    <option value="{{ $user->roles[0]->name }}" selected>{{ $user->roles[0]->name }}</option>
                    @forelse ($roles as $role)
                        @if($role != "Super Admin" && $role != $user->roles[0]->name)
                            <option value={{ $role }}>{{ $role }}</option>
                        @endif
                    @empty
                        <option value="">No role data yet</option>
                    @endforelse
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