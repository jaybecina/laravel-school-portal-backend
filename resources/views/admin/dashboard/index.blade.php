@extends('layouts.app')

@section('content')
  {{-- <h6>If you are not redirected automatically, follow <a href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard ">this link</a>.</h6> --}}
  <div class="row p-4">
    <div class="col-lg-12 position-relative z-index-2">
      <div class="card card-plain mb-4">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-lg-12">
              <div class="d-flex flex-column h-100">
    <h2 class="font-weight-bolder mb-0 text-center">Welcome to KLL Admin</h2>
  </div>

            </div>
          </div>
        </div>
      </div>

      

          <div class="card ">
    <div class="card-header p-3 pt-2 bg-transparent">
      <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
        <i class="material-icons opacity-10">store</i>
      </div>
      <img src="{{ asset('/assets/img/kll-admin-bg.jpg') }}" style="width: 100%; height: 600px; object-fit: cover;" alt="dashboard-bg">
    </div>

    <hr class="horizontal my-0 dark">
    <div class="card-footer p-3">
      <p class="mb-0 "><strong>Dashboard</strong></p>
    </div>
  </div>

        </div>
      </div>
@stop