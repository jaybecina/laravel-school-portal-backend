@extends('layouts.app')


@section('content')

<div class="card p-4">
    <div class="card-header px-0 py-2 position-relative z-index-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2> Show News</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.news.index') }}"> Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <img src={{ url($news->path) }} alt="Image {{ $news->imagename }}" style="width: 350px; height: 350px; object-fit: contain;" />
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Title:</strong>
                {{ $news->title }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Body:</strong>
                {{ $news->body }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Author:</strong>
                {{ $news->author }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mb-2">
            <div class="form-group">
                <strong>Is Active:</strong>
                {{ $news->is_active ? 'Active' : 'Inactive' }}
            </div>
        </div>
    </div>
</div>
@endsection