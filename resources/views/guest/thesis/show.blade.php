@extends('layouts.app')


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
          <input name="title" class="form-control" type="text" value="{{ $thesis->title }}"
            aria-label="readonly input example" readonly>
        </div>
        <label for="supervisor_name" class="form-label">Supervisor</label>
        <input name="supervisor_name" class="form-control" type="text" value="{{ $thesis->supervisor_name }}"
          aria-label="readonly input example" readonly>
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
          </div>
        </div>
        <div class="card-body">
          <h6 class="fw-bold mb-3"><i class="bi bi-file-earmark-pdf-fill me-2"></i>{{ $thesis->document }}</h6>
        </div>
      </div>
    @endisset

  </div>
@endsection

