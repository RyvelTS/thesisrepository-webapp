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
    <div class="card mt-3">
      <div class="card-header">
        <div class="row">
          <div class="col align-self-center">
            <h6 class="m-0 fw-bold text-secondary">Thesis Detail</h6>
          </div>
          @can('delete', $thesis)
            <div class="col-auto align-self-center">
              <button type="button" class="btn btn-outline-danger border-0" data-bs-toggle="modal"
                data-bs-target="#deleteConfirmation-{{ $thesis->id }}"><i class=" bi bi-trash"></i></button>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="deleteConfirmation-{{ $thesis->id }}" tabindex="-1"
              aria-labelledby="deleteConfirmation-{{ $thesis->id }}-Label" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmation-{{ $thesis->id }}-Label">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Delete "{{ $thesis->title }}" ?
                  </div>
                  <div class="modal-footer">
                    <form action="{{ route('thesis_destroy') }}" method="post">
                      @method('delete')
                      @csrf
                      <input type="hidden" name="thesis_id" value="{{ $thesis->id }}">
                      <button type="submit" class="btn btn-outline-danger border-0"><i class=" bi bi-trash me-2"></i>
                        Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary ms-3" data-bs-dismiss="modal">Cancel</button>
                  </div>
                </div>
              </div>
            </div>
          @endcan
          @can('update', $thesis)
            <div class="col-auto align-self-center">
              <a href="{{ route('thesis_edit', [$thesis->id]) }}" class="btn btn-secondary " role="button"
                aria-disabled="true"><i class="bi bi-pencil-square me-2"></i>Edit</a>
            </div>
          @endcan
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
