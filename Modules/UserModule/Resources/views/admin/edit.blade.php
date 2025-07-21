@extends('layoutmodule::layouts.main')

@section('title')
    Edit User
@endsection

@section('content')
    <section class="pc-container">
        <div class="pc-content">
            <!-- [ Page Header ] -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Edit User</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- [ Main Content ] -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Update User Information</h5>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="post" action="{{ route('admin.users.update', $user->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               name="name" value="{{ old('name', $user->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               name="email" value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                               name="phone" value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="form-label">Password <small>(leave blank to keep unchanged)</small></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                               name="password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Assign Roles</label>
                                    <select name="roles[]" class="form-control" multiple id="roleSelect">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                @if (in_array($role->id, old('roles', $user->roles->pluck('id')->toArray()))) selected @endif>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-center mt-5">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary mx-2">
                                        <i class="ti ti-arrow-left"></i> Back to List
                                    </a>
                                    <button type="submit" class="btn btn-primary mx-2">
                                        <i class="ti ti-device-floppy"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#roleSelect').select2({
                width: '100%',
                placeholder: 'Select roles',
                allowClear: true
            });
        });
    </script>
@endpush
