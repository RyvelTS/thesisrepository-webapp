@extends('layouts.dashboard')
@section('css')
  <style>
    #manageSchool {
      color: #e9b300;
      font-weight: bold
    }

  </style>
@endsection
@section('content')
  <div class="container">
    <form action="{{ route('school.index') }}">
      <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search School..."
          value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
      </div>
    </form>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col border-end align-self-center text-center">
            <h3 class=" fw-bold text-secondary"><i class="bi bi-building me-2"></i>Schools/ Departments</h3>
          </div>
          <div class="col border-end">
            <h1 class="text-center fw-bold text-primary">{{ $count }}</h1>
            <h5 class="link-secondary text-center fw-bold">Available Data(s)</h5>
          </div>
          <div class="col ">
            <button class="btn btn-outline-secondary w-100" type="button" data-bs-toggle="modal"
            data-bs-target="#createSchool">
              <p>Add School</p>
              <h2><i class="bi bi-plus-circle-dotted"></i></h2>
            </button>
            <!-- Modal -->
            <div class="modal fade" id="createSchool" data-bs-backdrop="static"
              data-bs-keyboard="false" tabindex="-1" aria-labelledby="createSchoolLabel"
              aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="createSchoolLabel">Create School
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="{{ route('school.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        placeholder="School/Department Name">
                        @error('name')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary border-0"
                        data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success">Create<i
                          class="bi bi-arrow-right-circle-fill ms-2"></i></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <table class="table table-responsive">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Total Student</th>
          <th scope="col">Thesis Count</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($schools as $school)
          <tr>
            <th scope="row">{{ $school->id }}</th>
            <td>{{ $school->name }}</td>
            <td class="text-center">{{ $school->total_users }}</td>
            <td class="text-center fw-bold">{{ $school->total_theses }}</td>
            <td>
              <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                  data-bs-target="#editSchool-{{ $school->id }}"><i class="bi bi-pencil me-2"></i>Edit</button>
                <!-- Modal -->
                <div class="modal fade" id="editSchool-{{ $school->id }}" data-bs-backdrop="static"
                  data-bs-keyboard="false" tabindex="-1" aria-labelledby="editSchool-{{ $school->id }}Label"
                  aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="editSchool-{{ $school->id }}Label">Edit "{{ $school->name }}"
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="{{ route('school.update', [$school]) }}" method="POST" action="patchlink">
                        @method('patch')
                        @csrf
                        <div class="modal-body">
                          <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                              value="{{ $school->name }}">
                            @error('name')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-secondary border-0"
                            data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success">Save<i
                              class="bi bi-check-circle-fill ms-2"></i></button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <button type="button" class="btn btn-outline-danger border-0" data-bs-toggle="modal"
                  data-bs-target="#deleteSchool-{{ $school->id }}"><i class="bi bi-trash me-2"></i>Delete</button>
                <!-- Modal -->
                <div class="modal fade" id="deleteSchool-{{ $school->id }}" data-bs-backdrop="static"
                  data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteSchool-{{ $school->id }}Label"
                  aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteSchool-{{ $school->id }}Label">Delete
                          "{{ $school->name }}"
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Are you sure want to delete <strong>"{{ $school->name }}"</strong> with it's <strong>users and theses</strong> ? 
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="{{ route('school.destroy',[$school]) }}" method="POST">
                          @csrf
                          @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger border-0">Delete</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td class="text-center" colspan="3">School Not Found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="row justify-content-center">
      <div class="col-auto">
        {{ $schools->links() }}
      </div>
    </div>
  </div>
@endsection
