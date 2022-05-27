@extends('layouts.dashboard')
@section('css')
  <style>
    #homeLink {
      color: #005BA7;
      font-weight: bold
    }

  </style>
@endsection

@section('content')
  {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}

  <div class="container">
    <div class="row py-3">
      <div class="col">
        <h4 class="fw-bold">Hello {{ Auth::user()->name }},</h4>
      </div>
    </div>
    @cannot('admin')
      <div class="card">
        <div class="card-body">
          <h5 class="fw-bold">My Recent Thesis</h5>
          @isset($recent_thesis)
            <div class="card mt-3">
              <div class="card-header">
                <div class="row">
                  <div class="col align-self-center">
                    <h6 class="m-0 fw-bold text-secondary">{{ $recent_thesis->title }}</h6>
                  </div>
                  <div class="col-auto">
                    <a class="btn btn-outline-dark" href="{{ route('thesis_show', $recent_thesis->id) }}" role="button"><i
                        class="bi bi-folder2-open"></i></a>
                  </div>
                </div>

              </div>
              <div class="card-body">
                <p>Created at : {{ \Carbon\Carbon::parse($recent_thesis->created_at)->format('d M Y') }}</p>
                <p>Last Updated : {{ \Carbon\Carbon::parse($recent_thesis->updated_at)->format('d M Y - h:i ') }}</p>
                <p>Supervisor : {{ $recent_thesis->supervisor_name }}</p>
              </div>
            </div>
          @else
            <a class="btn btn-outline-secondary w-100 mt-3" href="{{ route('thesis_create') }}" role="button">
              <p>Add Thesis</p>
              <h2><i class="bi bi-plus-circle-dotted"></i></h2>
            </a>
          @endisset
        </div>
      </div>
    @endcannot
    @can('admin')
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col border-end align-self-center text-center">
                  <h3 class=" fw-bold text-secondary">Stats <i class="bi bi-bar-chart-fill ms-2"></i></h3>
                </div>
                <div class="col border-end">
                  <a class="text-decoration-none" href="">
                  <h1 class="text-center fw-bold text-primary">{{ $count->thesis }}</h1>
                  <h5 class="link-secondary text-center fw-bold">Total Thesis</h5>
                  </a>
                </div>
                <div class="col border-end">
                  <a class="text-decoration-none" href="{{ route('user.index') }}">
                  <h1 class="text-center fw-bold text-primary">{{ $count->user }}</h1>
                  <h5 class="link-secondary text-center fw-bold">Total User</h5>
                  </a>
                </div>
                <div class="col">
                  <a class="text-decoration-none" href="{{ route('school.index') }}">
                  <h1 class="text-center fw-bold text-primary">{{ $count->school }}</h1>
                  <h5 class="link-secondary text-center fw-bold">School/Department</h5>
                  </a>
                </div>
                
              </div>
              
            </div>
          </div>
        </div>
        
      </div>
    @endcan

  </div>
@endsection
