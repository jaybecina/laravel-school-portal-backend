@extends('layouts.app')


@section('content')

<div class="card p-4">
  <div class="card-header px-0 py-2 position-relative z-index-2">
    <div class="row">
      <div class="col-lg-12 margin-tb">
          <div class="pull-left">
              <h2>Subjects Management</h2>
          </div>
          <div class="pull-right">
              <a class="btn btn-success" href="{{ route('admin.subjects.create') }}"> Create New Subject</a>
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
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Subject Code</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Name</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Start Time</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">End Time</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Day</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Room No</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Units</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Detail</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Teacher</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="280px">Action</th>
      </tr>
      @foreach ($data as $key => $subject)
        <tr>
          <td class="align-middle text-center text-sm">{{ $subject->subject_code }}</td>
          <td class="align-middle text-center text-sm">{{ $subject->name }}</td>
          <td class="align-middle text-center text-sm">{{ $subject->start_time }}</td>
          <td class="align-middle text-center text-sm">{{ $subject->end_time }}</td>
          <td class="align-middle text-center text-sm">{{ $subject->day }}</td>
          <td class="align-middle text-center text-sm">{{ $subject->room_no }}</td>
          <td class="align-middle text-center text-sm">{{ $subject->units }}</td>
          <td class="align-middle text-center text-sm">{{ $subject->detail }}</td>
          <td class="align-middle text-center text-sm">{{ $subject->teacher->last_name }}, {{ $subject->teacher->first_name }} {{ $subject->teacher->middle_name }}</td>
          <td class="d-flex justify-content-center align-items-center align-middle text-center text-sm pb-0">
            <a class="btn btn-info" href="{{ route('admin.subjects.show',$subject->id) }}">Show</a>
            <a class="btn btn-primary mr-2" href="{{ route('admin.subjects.edit', $subject->id) }}">Edit</a>
              {!! Form::open(['method' => 'DELETE','route' => ['admin.subjects.destroy', $subject->id],'style'=>'display:inline']) !!}
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