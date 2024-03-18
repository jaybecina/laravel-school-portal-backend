@extends('layouts.app')


@section('content')

<div class="card p-4">
  <div class="card-header px-0 py-2 position-relative z-index-2">
    <div class="row">
      <div class="col-lg-12 margin-tb">
          <div class="pull-left">
              <h2>Curricula Management</h2>
          </div>
          <div class="pull-right">
              <a class="btn btn-success" href="{{ route('admin.curricula.create') }}"> Create New Curriculum</a>
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
  </div>
  <div class="table-responsive">
    <table class="table table-striped align-items-center">
      <tr class="py-4">
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Curriculum Code</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Name</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Description</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Courses</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Is Active</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="280px">Action</th>
      </tr>
      @foreach ($data as $key => $curriculum)
        <tr>
          <td class="align-middle text-center text-sm">{{ $curriculum->curriculum_code }}</td>
          <td class="align-middle text-center text-sm">{{ $curriculum->name }}</td>
          <td class="align-middle text-center text-sm">{{ $curriculum->desc }}</td>
          <td class="align-middle text-center text-sm">
            <div class="d-flex flex-wrap">
                @if(!empty($curriculum->courses))
                    @foreach($curriculum->courses->unique() as $course)
                        <span class="badge badge-pill badge-lg bg-gradient-info m-1">{{ $course->course_code }}</span>
                    @endforeach
                @endif
            </div>
          </td>
          <td class="align-middle text-center text-sm">{{ $curriculum->is_active === 1 ? "Active" : "Inactive" }}</td>
          <td class="d-flex justify-content-center align-items-center align-middle text-center text-sm pb-0">
            <a class="btn btn-info" href="{{ route('admin.curricula.show', $curriculum->id) }}">Show</a>
            <a class="btn btn-primary mr-2" href="{{ route('admin.curricula.edit', $curriculum->id) }}">Edit</a>
              {!! Form::open(['method' => 'DELETE','route' => ['admin.curricula.destroy', $curriculum->id],'style'=>'display:inline']) !!}
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