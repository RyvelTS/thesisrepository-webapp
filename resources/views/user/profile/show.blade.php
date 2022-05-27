@extends('layouts.dashboard')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-auto">
        <div class="avatar-container rounded-circle">
          @isset(Auth::user()->picture)
          <img src="{{asset('/storage/pictures/'.Auth::user()->picture)}}" alt="">
          @else
          <img src="{{asset('/storage/pictures/anonymous-user.jpg')}}" alt="">
          @endisset
          
        </div>
      </div>
      <div class="col align-self-center">
        <h2 class="fw-bold">{{ Auth::user()->name }}</h2>
        <h5>{{ Auth::user()->email }}</h5>
      </div>
    </div>
    <hr>
    @cannot('admin')
    <form action="{{ route('profile_update') }}" method="POST" action="patchlink" enctype="multipart/form-data">
      @method('patch')
      @csrf
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header">
              @isset(Auth::user()->picture)
              <h5 class="fw-bold py-2 m-0">Change Profile Picture</h5>
              @else
              <h5 class="fw-bold py-2 m-0">Upload Profile Picture</h5>
              @endisset
            </div>
            <div class="card-body">
              <div class="input-group">
                @isset(Auth::user()->picture)
                <input type="hidden" name="old_picture" value="{{ Auth::user()->picture }}">
                @endisset
                <input type="file" class="form-control @error('picture') is-invalid @enderror" name="picture" aria-describedby="inputGroupFileAddon04"
                  aria-label="Upload">
                  @error('picture')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="card mt-3">
            <div class="card-header">
              <h5 class="fw-bold py-2 m-0">My Data</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <label for="student_id" class="form-label">Student ID</label>
                <input type="text" class="form-control @error('student_id') is-invalid @enderror" name="student_id" value="{{ Auth::user()->student_id }}"
                  placeholder="Type your Student Id here">
                  @error('student_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
              <div class="mb-3">
                <label for="school_id" class="form-label">School / Department</label>
                <select name="school_id" class="form-select" aria-label="Default select example">
                  @foreach ($schools as $school)
                    @if ($school->id == Auth::user()->school_id)
                      <option selected value={{ $school->id }}>{{ Auth::user()->school->name }}</option>
                    @else
                      <option value={{ $school->id }}>{{ $school->name }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="row justify-content-end">
                <div class="col-auto">
                  <button type="submit" class="btn btn-success px-4"><i class="bi bi-check-circle me-2"></i> Save</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
    @endcannot
  </div>
@endsection
