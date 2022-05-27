@extends('layouts.dashboard')
@section('css')
  <style>
    #discoverLink {
      color: #005BA7;
      font-weight: bold
    }

  </style>
@endsection
@section('content')
  <div class="container">
    <form action="{{ route('thesis_search') }}">
      @if (request('user'))
      <input type="hidden" name="user" value="{{ request('user') }}">
      @endif
      @if (request('school'))
      <input type="hidden" name="school" value="{{ request('school') }}">
      @endif
      <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search @if (request('school'))Thesis in {{ request('school') }}@endif @if (request('user'))Thesis by {{ request('user') }} @endif..." value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit" ><i class="bi bi-search"></i></button>
      </div>
    </form>
    <hr>
    @forelse ($theses as $thesis)
    <div class="mb-3">
    <a class="link-primary text-decoration-none" href="{{ route('thesis_show',[$thesis->id]) }}">
      <div class="card">
        <div class="card-body">
          <h4 class="mb-1 fw-bold">{{ $thesis->title }}</h4>
          <span class="m-0 text-dark">Supervised by: {{ $thesis->supervisor_name }} || Department:</span><a class="link-secondary ms-2" href="/thesis?school={{ $thesis->user->school->name }}">{{ $thesis->user->school->name }}</a>
          <div class="row mt-2">
            <div class="col-auto">
              @isset( $thesis->user->picture)
              <img src="{{asset('/storage/pictures/'.$thesis->user->picture)}}" width="30" height="30" class="rounded-circle">
              @else
              <img src="{{asset('/storage/pictures/anonymous-user.jpg')}}" width="30" height="30" class="rounded-circle">
              @endisset
              <a class="link-secondary fw-bold ms-2" href="/thesis?user={{ $thesis->user->name }}">{{ $thesis->user->name }}</a>
            </div>
          </div>
        </div>
      </div>
    </a>
    </div>
    @empty
    <p class="text-center">Thesis Not Found</p>
    @endforelse
    <div class="row justify-content-center">
      <div class="col-auto">
        {{ $theses->links() }}
      </div>
    </div>
    
  </div>
@endsection
