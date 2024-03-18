@extends('layouts.app')


@section('content')

<div class="card p-4">
  <div class="card-header px-0 py-2 position-relative z-index-2">
    <div class="row">
      <div class="col-lg-12 margin-tb">
          <div class="pull-left">
              <h2>Sports Management</h2>
          </div>
          <div class="pull-right">
              <a class="btn btn-success" href="{{ route('admin.sports.create') }}"> Create New Sport</a>
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
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Image</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Name</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Details</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Is Active</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="280px">Action</th>
      </tr>
      @foreach ($data as $key => $sport)
        @php
          if (!function_exists('truncateText')) {
              function truncateText($text, $length = 50) {
                  if (strlen($text) > $length) {
                      $truncatedText = substr($text, 0, $length);
                      // Find the last space within the truncated text
                      $lastSpace = strrpos($truncatedText, ' ');
                      // Trim text to the last space
                      $truncatedText = substr($truncatedText, 0, $lastSpace);
                      return $truncatedText . '...';
                  }
                  return $text;
              }
          }
        @endphp

        <tr>
          <td class="align-middle text-center text-sm">
            <img src={{ url($sport->path) }} alt="Image {{ $sport->imagename }}" style="width: 50px; height; 50px; object-fit: contain;" />
          </td>
          <td class="align-middle text-center text-sm">{{ $sport->name }}</td>
          <td class="align-middle text-center text-sm">{{ truncateText($sport->details) }}</td>
          <td class="align-middle text-center text-sm">{{ $sport->is_active == 1 ? "Active" : "Inactive" }}</td>
          <td class="d-flex justify-content-center align-items-center align-middle text-center text-sm pb-0">
            <a class="btn btn-info" href="{{ route('admin.sports.show',$sport->id) }}">Show</a>
            <a class="btn btn-primary mr-2" href="{{ route('admin.sports.edit', $sport->id) }}">Edit</a>
              {!! Form::open(['method' => 'DELETE','route' => ['admin.sports.destroy', $sport->id],'style'=>'display:inline']) !!}
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