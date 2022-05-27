@extends('layouts.dashboard')
@section('css')
  <style>
    #manageLink {
      color: #005BA7;
      font-weight: bold
    }

  </style>
@endsection
@section('content')
  <div class="container">
    <div class="row py-3">
      <div class="col">
        <h4 class="fw-bold">My Thesis,</h4>
      </div>
    </div>
    <hr>
    @forelse ($theses as $thesis)
      <div class="card mb-3">
        <div class="card-body">
          <div class="row">
            <div class="col">
              <a href="{{ route('thesis_show', $thesis->id) }}" class="text-decoration-none link-secondary"
                role="button">
                <h5 class="fw-bold ">{{ $thesis->title }}</h5>
                <h6 class="text-secondary mb-0">{{ \Carbon\Carbon::parse($thesis->created_at)->format('d M Y') }} |
                  {{ $thesis->supervisor_name }}</h6>
              </a>
            </div>
            <div class="col-auto">
              <button type="button" class="btn btn-outline-danger border-0" data-bs-toggle="modal" data-bs-target="#deleteConfirmation-{{ $thesis->id }}"><i class=" bi bi-trash"></i></button>
              <!-- Modal -->
              <div class="modal fade" id="deleteConfirmation-{{ $thesis->id }}" tabindex="-1" aria-labelledby="deleteConfirmation-{{ $thesis->id }}-Label"
                aria-hidden="true">
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
                        <button type="submit" class="btn btn-outline-danger border-0"><i
                            class=" bi bi-trash me-2"></i> Delete</button>
                      </form>
                      <button type="button" class="btn btn-secondary ms-3" data-bs-dismiss="modal">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="card">
        <div class="card-body">
          <a class="btn btn-outline-secondary w-100 mt-3" href="{{ route('thesis_create') }}" role="button">
            <p>Add Thesis</p>
            <h2><i class="bi bi-plus-circle-dotted"></i></h2>
          </a>
        </div>
      </div>
    @endforelse

    
    <div class="row justify-content-center mt-2">
      <div class="col-auto">
        {{ $theses->links() }}
      </div>
    </div>
  </div>
@endsection
