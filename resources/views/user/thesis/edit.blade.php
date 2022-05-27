@extends('layouts.dashboard')

@section('content')
  <div class="container">
    <div class="row py-3">
      <div class="col">
        <h4 class="fw-bold">{{ $thesis->title }}</h4>
        <h5 class="text-secondary fw-normal">
          {{ $thesis->user->student_id }} <i class="bi bi-dash-lg mx-1"></i> {{ $thesis->user->name }}<i
            class="bi bi-dash-lg mx-1"></i>{{ $thesis->user->school->name }} </h5>
      </div>
    </div>
    <form action="{{ route('thesis_update', [$thesis->id]) }}" method="POST" action="patchlink">
      @method('patch')
      @csrf
      <input type="hidden" name="thesis_id" value="{{ $thesis->id }}">
      <div class="card mt-3">
        <div class="card-header">
          <div class="row">
            <div class="col align-self-center">
              <h6 class="m-0 fw-bold text-secondary">Thesis Detail</h6>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <textarea type="text" name="title" class="form-control @error('title') is-invalid @enderror"
              rows="2">{{ $thesis->title }}</textarea>
            @error('title')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <label for="supervisor_name" class="form-label">Supervisor</label>
          <input type="text" name="supervisor_name" class="form-control @error('supervisor_name') is-invalid @enderror"
            placeholder="Supervisor Name" aria-label="Supervisor Name" aria-describedby="basic-addon2"
            value="{{ $thesis->supervisor_name }}">
          @error('supervisor_name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
          <div class="row justify-content-end py-3">
            <div class="col-auto">
              <button type="submit" class="btn btn-success"><i class="me-2 bi bi-file-earmark-check"></i>
                Save</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    @isset($thesis->document)
      <div class="card mt-3">
        <div class="card-header">
          <div class="row">
            <div class="col align-self-center">
              <h6 class="m-0 fw-bold text-secondary">Uploaded Document</h6>
            </div>
            <div class="col-auto">
              <a class="btn btn-outline-success" href="{{ asset('/storage/documents/' . $thesis->document) }}" download
                role="button"><i class="bi bi-file-earmark-arrow-down me-2"></i>
                download</a>
            </div>
            <div class="col-auto">
              <form action="{{ route('thesis_update', [$thesis->id]) }}" method="POST" action="patchlink">
                @method('patch')
                @csrf
                <input type="hidden" name="old_document" value="{{ $thesis->document }}">
                <button class="btn btn-outline-danger" type="submit"><i class="bi bi-file-earmark-x me-2"></i>
                  delete</a>
              </form>
            </div>
          </div>
        </div>
        <div class="card-body">
          <h6 class="fw-bold mb-3"><i class="bi bi-file-earmark-pdf-fill me-2"></i>{{ $thesis->document }}</h6>
        </div>
      </div>
    @else
      <form action="{{ route('thesis_update', [$thesis->id]) }}" method="POST" action="patchlink"
        enctype="multipart/form-data">
        @method('patch')
        @csrf
        <input type="hidden" name="thesis_id" value="{{ $thesis->id }}">
        <input type="hidden" name="title" value="{{ $thesis->title }}">
        <input type="hidden" name="supervisor_name" value="{{ $thesis->supervisor_name }}">
        <div class="card mt-3">
          <div class="card-header">
            <h6 class="m-0 fw-bold text-secondary">Upload Document</h6>
          </div>
          <div class="card-body">
            <div class="input-group">
              <input type="file" name="document" class="form-control @error('document') is-invalid @enderror"
                id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
              <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04"><i
                  class="bi bi-file-earmark-plus me-2"></i>Upload</button>
              @error('document')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
        </div>
      </form>
    @endisset

  </div>
@endsection
