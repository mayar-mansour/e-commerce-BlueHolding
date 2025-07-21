@extends('layoutmodule::layouts.main')

@section('title')
    Product Details
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
                                    <a href="{{ route('products.index') }}" class="text-primary">Products</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">View Product Details</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Breadcrumb End -->

            <!-- Product Details Card -->
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <div class="card shadow border-0">
                        <div class="card-header bg-primary text-white text-center">
                            <h4 class="mb-0"><i class="ti ti-package"></i> Product Details: {{ $product->name }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <h6 class="text-muted"><i class="ti ti-tag"></i> Name</h6>
                                        <p class="fw-bold mb-0">{{ $product->name }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <h6 class="text-muted"><i class="ti ti-currency-dollar"></i> Price</h6>
                                        <p class="fw-bold mb-0">{{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <h6 class="text-muted"><i class="ti ti-align-left"></i> Description</h6>
                                        <p class="fw-bold mb-0">{{ $product->description }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="p-3 border rounded bg-light">
                                        <h6 class="text-muted"><i class="ti ti-box"></i> Stock Quantity</h6>
                                        <p class="fw-bold mb-0">{{ $product->stock_quantity }}</p>
                                    </div>
                                </div>

                                @if ($product->categories->count())
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-light">
                                            <h6 class="text-muted"><i class="ti ti-tags"></i> Categories</h6>
                                            <p class="fw-bold mb-0">
                                                {{ $product->categories->pluck('name')->implode(', ') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($product->tags->count())
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded bg-light">
                                            <h6 class="text-muted"><i class="ti ti-hash"></i> Tags</h6>
                                            <p class="fw-bold mb-0">
                                                {{ $product->tags->pluck('name')->implode(', ') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($product->images && count($product->images))
                                    <div class="col-12">
                                        <div class="p-3 border rounded bg-light">
                                            <h6 class="text-muted"><i class="ti ti-photo"></i> Images</h6>
                                            <div class="d-flex flex-wrap">
                                                @foreach ($product->images as $image)
                                                    <img src="{{ asset('storage/' . $image) }}" class="me-2 mb-2" width="100" height="100" alt="Product Image">
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mx-2">
                        <i class="ti ti-arrow-left"></i> Back to List
                    </a>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary mx-2">
                        <i class="ti ti-pencil"></i> Edit Product
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
