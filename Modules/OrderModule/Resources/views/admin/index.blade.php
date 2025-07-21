@extends('layoutmodule::layouts.main')

@section('title')
    Orders
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
                                    <h2 class="mb-0">Orders</h2>
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
                                <table class="table table-hover tbl-order" id="pc-dt-simple">
                                    <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->order_nu }}</td>
                                                <td>{{ $order->user->name }}</td>
                                                <td>{{ $order->total_amount }}</td>
                                                <td>{{ $order->status->status }}</td>
                                                <td class="text-center">
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                        </li>
                                                    
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
 
@endpush
