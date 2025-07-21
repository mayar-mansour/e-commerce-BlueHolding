@extends('layoutmodule::layouts.main')

@section('title')
    Users
@endsection

@section('content')
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="page-header-title">
                                    <h2 class="mb-0">Users</h2>
                                </div>
                                <div>
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                        <i class="ti ti-plus f-18"></i> Add New User
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div id="flash-message" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-body mt-3 m-3">
                            <div class="table-responsive">
                                <table class="table table-hover tbl-user" id="pc-dt-simple">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Roles</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>
                                                    @foreach ($user->roles as $role)
                                                        <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td class="text-center">
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                        </li>
                                                      
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-3">
                                    {{ $users->links() }} <!-- Pagination -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-btn', function () {
            const form = $(this).closest('.delete-form');
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
