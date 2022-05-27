@extends('layouts.dashboard')
@section('css')
  <style>
    #manageUser {
      color: #e9b300;
      font-weight: bold
    }

  </style>
@endsection
@section('content')
  <div class="container">
    <form action="{{ route('user.index') }}">
      <div class="input-group mb-3">
        <input type="text" name="search" class="form-control" placeholder="Search User..."
          value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
      </div>
    </form>
    <hr>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col border-end align-self-center text-center">
            <h3 class=" fw-bold text-secondary"><i class="bi bi-people me-2"></i>Users/ Admin</h3>
          </div>
          <div class="col border-end">
            <h1 class="text-center fw-bold text-primary">{{ $count }}</h1>
            <h5 class="link-secondary text-center fw-bold">Available User(s)</h5>
          </div>
          <div class="col ">
            <button class="btn btn-outline-secondary w-100" type="button" data-bs-toggle="modal"
              data-bs-target="#createUser">
              <p>Add User</p>
              <h2><i class="bi bi-plus-circle-dotted"></i></h2>
            </button>
            <!-- Modal -->
            <div class="modal fade" id="createUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
              aria-labelledby="createUserLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="createUserLabel">Create User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form method="POST" action="{{ route('user.store') }}">
                    @csrf
                    <div class="modal-body">
                      <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                        <div class="col-md-6">
                          <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                          @error('name')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">

                          @error('email')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                        <div class="col-md-6">
                          <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password">

                          @error('password')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="password-confirm"
                          class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                          <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password">
                        </div>
                      </div>
                      <hr>
                      <div class="row mb-3">
                        <label for="school_id" class="col-form-label text-md-end col-md-4">School / Department</label>
                        <div class="col-md-6">
                          <select name="school_id" class="form-select" aria-label="Default select example">
                            <option disabled selected>Choose School</option>
                            @foreach ($schools as $school)
                              <option value={{ $school->id }}>{{ $school->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="mb-4 row">
                        <label for="student_id" class="col-form-label text-md-end col-md-4">Student ID</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('student_id') is-invalid @enderror"
                            name="student_id" placeholder="Student Id">
                          @error('student_id')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                      <hr>
                      <div class="ms-3 mb-3 row">
                        <div class="col align-content-center">
                          <div class="form-check">
                            <label class="form-check-label" for="is_admin">
                              Admin Status
                            </label>
                            <input name="is_admin" class="form-check-input" type="checkbox" value="1"
                              {{ old('is_admin') ? 'checked="checked"' : '' }}>
                          </div>
                        </div>
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
    <table class="table table-responsive mt-2">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Student_id</th>
          <th scope="col">School</th>
          <th scope="col">Thesis</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $user)
          <tr>
            <th scope="row">{{ $user->id }}</th>
            <td>{{ $user->name }}</td>
            <td>
              @isset($user->student_id)
                {{ $user->student_id }}
              @else
                ~
              @endisset
            </td>
            <td>
              @isset($user->school_id)
                {{ $user->school->name }}
              @else
                ~
              @endisset
            </td>
            <td class="text-center ">{{ $user->total_theses }}</td>
            <td>{{ $user->email }}</td>
            <td>
              @if ($user->is_admin)
                Admin
              @else
                User
              @endif
            </td>
            <td>
              <div class="d-inline-flex">
                @if ($user->is_admin)
                  N/A
                @else
                  <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                  data-bs-target="#editUser-{{ $user->id }}"><i class="bi bi-pencil me-2"></i>Edit</button>
                  <!-- Modal -->
                  <div class="modal fade" id="editUser-{{ $user->id }}" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="editUser-{{ $user->id }}Label"
                    aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="editUser-{{ $user->id }}Label">Edit User
                          </h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('user.update',[$user]) }}">
                          @method('patch')
                          @csrf
                          <div class="modal-body">
                            <div class="row mb-3">
                              <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                              <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                  name="name" value="{{  $user->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                            </div>

                            <div class="row mb-3">
                              <label for="email"
                                class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                              <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                  name="email" value="{{  $user->email }}" required autocomplete="email">

                                @error('email')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                            </div>
                            <hr>
                            <div class="row mb-3">
                              <label for="school_id" class="col-form-label text-md-end col-md-4">School /
                                Department</label>
                              <div class="col-md-6">
                                <select name="school_id" class="form-select" aria-label="Default select example">
                                  @foreach ($schools as $school)
                                    @if ($school->id == $user->school_id)
                                      <option selected value={{ $school->id }}>{{ $user->school->name }}</option>
                                    @else
                                      <option value={{ $school->id }}>{{ $school->name }}</option>
                                    @endif
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="mb-4 row">
                              <label for="student_id" class="col-form-label text-md-end col-md-4">Student ID</label>
                              <div class="col-md-6">
                                <input type="text" class="form-control @error('student_id') is-invalid @enderror"
                                  name="student_id" placeholder="Student Id" value="{{  $user->student_id }}">
                                @error('student_id')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                            </div>
                            <hr>
                            <div class="ms-3 mb-3 row">
                              <div class="col align-content-center">
                                <div class="form-check">
                                  <label class="form-check-label" for="is_admin">
                                    Admin Status
                                  </label>
                                  <input name="is_admin" class="form-check-input" type="checkbox" value="1"
                                    {{ old('is_admin') ? 'checked="checked"' : '' }}>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary border-0"
                              data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save Changes<i
                                class="bi bi-arrow-right-circle-fill ms-2"></i></button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-outline-danger border-0" data-bs-toggle="modal"
                  data-bs-target="#deleteUser-{{ $user->id }}"><i class="bi bi-trash me-2"></i>Delete</button>
                <!-- Modal -->
                <div class="modal fade" id="deleteUser-{{ $user->id }}" data-bs-backdrop="static"
                  data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteUser-{{ $user->id }}Label"
                  aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="deleteUser-{{ $user->id }}Label">Delete
                          "{{ $user->name }}"
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Are you sure want to delete <strong>"{{ $user->name }}"</strong> with it's <strong>theses</strong> ? 
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="{{ route('user.destroy',[$user]) }}" method="POST">
                          @csrf
                          @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger border-0">Delete</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td class="text-center" colspan="3">User Not Found</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    <div class="row justify-content-center">
      <div class="col-auto">
        {{ $users->links() }}
      </div>
    </div>
  </div>
@endsection
