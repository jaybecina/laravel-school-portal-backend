@extends('layouts.app')


@section('content')

<div class="card p-4">
  <div class="card-header px-0 py-2 position-relative z-index-2">
    <div class="row">
      <div class="col-lg-12 margin-tb">
          <div class="pull-left">
              <h2>Student Resources Management</h2>
          </div>
          <div class="pull-right">
              <a class="btn btn-success" href="{{ route('admin.student-resources.create') }}"> Upload New Student Resource</a>
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
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Title</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Description</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">File name</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Path</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Content</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Mime Type</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">File Size</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Is Active</th>
        <th class="align-middle text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7" width="280px">Action</th>
      </tr>
      @foreach ($data as $key => $student_resource)
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
          <td class="align-middle text-center text-sm">{{ $student_resource->title }}</td>
          <td class="align-middle text-center text-sm">{{ truncateText($student_resource->desc) }}</td>
          <td class="align-middle text-center text-sm">{{ $student_resource->filename }}</td>
          <td class="align-middle text-center text-sm">{{ $student_resource->path }}</td>
          <td class="align-middle text-center text-sm">{{ truncateText($student_resource->content, 50) }}</td>
          <td class="align-middle text-center text-sm">{{ $student_resource->mime_type }}</td>
          <td class="align-middle text-center text-sm">{{ $student_resource->filesize }}</td>
          <td class="align-middle text-center text-sm">{{ $student_resource->is_active == 1 ? "Active" : "Inactive" }}</td>
          <td class="d-flex justify-content-center align-items-center align-middle text-center text-sm pb-0">
            <a class="btn btn-info" href="{{ asset("https://kll-portal-spaces.sgp1.digitaloceanspaces.com/student_resources/".$student_resource->filename) }}">Show</a>
            <a class="btn btn-primary mr-2" href="{{ route('admin.student-resources.edit', $student_resource->id) }}">Edit</a>
              {!! Form::open(['method' => 'DELETE','route' => ['admin.student-resources.destroy', $student_resource->id],'style'=>'display:inline']) !!}
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