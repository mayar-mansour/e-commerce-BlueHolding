@extends('layoutmodule::layouts.main')

@section('title')
    User Profile
@endsection

@section('content')
    <!-- Main Content -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- Breadcrumb -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb bg-light p-3 rounded">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard.index') }}" class="text-primary">
                                        <i class="ti ti-home"></i> Home
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.users.index') }}" class="text-primary">Users</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">View User</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Breadcrumb End -->

            <!-- User Profile Card -->
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="card shadow border-0">
                        <div class="card-header bg-primary text-white text-center">
                            <h4 class="mb-0"><i class="ti ti-user"></i> User Profile: {{ $user->name }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <h6 class="text-muted"><i class="ti ti-user"></i> Name</h6>
                                        <p class="fw-bold mb-0">{{ $user->name }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <h6 class="text-muted"><i class="ti ti-mail"></i> Email</h6>
                                        <p class="fw-bold mb-0">{{ $user->email }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <h6 class="text-muted"><i class="ti ti-phone"></i> Phone</h6>
                                        <p class="fw-bold mb-0">{{ $user->phone }}</p>
                                    </div>
                                </div>

                                @if ($user->roles->count())
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-light">
                                            <h6 class="text-muted"><i class="ti ti-shield-check"></i> Roles</h6>
                                            <p class="fw-bold mb-0">
                                                {{ $user->roles->pluck('name')->implode(', ') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if (!empty($user->profile_photo_url ?? null))
                                    <div class="col-12">
                                        <div class="p-3 border rounded bg-light">
                                            <h6 class="text-muted"><i class="ti ti-photo"></i> Profile Photo</h6>
                                            <img src="{{ $user->profile_photo_url }}" class="rounded" width="120" height="120" alt="Profile Photo">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary mx-2">
                        <i class="ti ti-arrow-left"></i> Back to List
                    </a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary mx-2">
                        <i class="ti ti-pencil"></i> Edit User
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
