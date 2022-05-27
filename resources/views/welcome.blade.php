@extends('layouts.app')


@section('content')
<div class="container">
  <div class="row justify-content-center my-5">
    <div class="col-md-6 text-center ">
      <h3 class="fw-bold">SWPU Thesis Repository</h3>
      <p class="text-secondary">Ryvel Timothy Stamber - 201839060053</p>
      <form action="{{ route('search') }}">
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
    </div>
  </div>
</div>
@endsection