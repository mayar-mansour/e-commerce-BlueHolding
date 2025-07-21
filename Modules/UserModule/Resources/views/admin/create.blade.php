@extends('layoutmodule::layouts.main')

@section('title')
    Create User
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
                                <h2 class="mb-0">Create New User</h2>
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
                            <h5>Add User</h5>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div id="flash-message" class="alert alert-success alert-dismissible fade show"
                                    role="alert">
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

                            <form method="POST" action="{{ route('admin.users.store') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" placeholder="Enter full name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" placeholder="Enter email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            name="phone" value="{{ old('phone') }}" placeholder="Enter phone number">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            name="password" placeholder="Enter password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                @if (isset($roles))
                                    <div class="mb-4">
                                        <label class="form-label">Assign Roles</label>
                                        <select name="roles[]" id="roleSelect"
                                            class="form-control @error('roles') is-invalid @enderror" multiple>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}"
                                                    @if (in_array($role->id, old('roles', []))) selected @endif>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <div class="text-center mt-5">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary mx-2">
                                        <i class="ti ti-arrow-left"></i> Back to List
                                    </a>
                                    <button type="submit" class="btn btn-primary mx-2">
                                        <i class="ti ti-user-plus"></i> Create User
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
        $(document).ready(function() {
            $('#roleSelect').select2({
                width: '100%',
                placeholder: 'Select roles',
                allowClear: true
            });
        });
    </script>
@endpush
