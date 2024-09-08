@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
  <span class="pagetitle">{{ $title }}</span>
</div>

<div class="col-xxl-4 col-md-3">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Users</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $users ?? 0 }}</h6>
                     
                    </div>
                  </div>
                </div>

              </div>
            </div>
@endsection
