@extends('layouts.dashboard')
@section('css')
  <style>
    #createLink {
      color: #005BA7;
      font-weight: bold
    }

  </style>
@endsection
@section('content')
  <div class="container">
    <div class="row py-3">
      <div class="col">
        <h4 class="fw-bold">Create Thesis,</h4>
      </div>
    </div>
    <form action="{{ route('thesis_store') }}" method="post" enctype="multipart/form-data">
      @csrf
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
            <textarea type="text" name="title" class="form-control @error('title') is-invalid @enderror" rows="2"
              placeholder="Type your thesis title here"></textarea>
            @error('title')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <label for="supervisor_name" class="form-label">Supervisor</label>
          <input type="text" name="supervisor_name" class="form-control @error('supervisor_name') is-invalid @enderror"
            placeholder="Type your Supervisor Name here" aria-label="Supervisor Name" aria-describedby="basic-addon2">
          @error('supervisor_name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
      </div>
      <div class="card mt-3">
        <div class="card-header">
          <div class="row">
            <div class="col align-self-center">
              <h6 class="m-0 fw-bold text-secondary">Upload Thesis</h6>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div>
            <label for="formFile" class="form-label">Choose your Thesis/Paper/Report File</label>
            <input type="file" class="form-control @error('document') is-invalid @enderror" name="document">
            @error('document')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
      </div>
      <div class="row justify-content-end py-3">
        <div class="col-auto">
          @can('create', App\Models\Thesis::class)
            <button type="submit" class="btn btn-success"><i class="me-2 bi bi-file-earmark-check"></i> Save</button>
          @else
            <p class="text-warning fw-bold"> <i class="bi bi-exclamation-diamond me-2"></i>Please insert your full
              information in the profile page</p>
          @endcan
        </div>
      </div>
    </form>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    window.addEventListener('keydown', function(e) {
      if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13) {
        if (e.target.nodeName == 'INPUT' && e.target.type == 'text') {
          e.preventDefault();
          return false;
        }
      }
    }, true);
  </script>
@endsection
