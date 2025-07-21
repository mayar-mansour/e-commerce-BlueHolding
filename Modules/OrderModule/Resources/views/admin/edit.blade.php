@extends('layoutmodule::layouts.main')

@section('title')
    Edit Order
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
                                <h2 class="mb-0">Edit Order</h2>
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
                            <h5>Update Order</h5>
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

                            <form method="post" action="{{ route('orders.update', $order->id) }}">
                                @csrf
                                @method('POST')

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Customer Name </label>
                                        <input type="text" class="form-control" name="customer_name"
                                            value="{{ old('customer_name', $order->user->name) }}" readonly>

                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="form-label">Order Status <span class="text-danger">*</span></label>
                                        <select class="form-control p-1 @error('status_id') is-invalid @enderror"
                                            name="status_id">
                                            @foreach ($statuses as $status)
                                                <option value="{{ $status->id }}"
                                                    {{ old('status_id', $order->status_id) == $status->id ? 'selected' : '' }}>
                                                    {{ ucfirst($status->status) }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Order Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" name="notes">{{ old('notes', $order->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Order Items</label>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderItems as $index => $item)
                                                <tr>
                                                    <td>{{ $item->product_name }}</td>
                                                    <td>
                                                        <input type="number"
                                                            name="items[{{ $item->id }}][quantity]"
                                                            class="form-control"
                                                            value="{{ old("items.$item->id.quantity", $item->quantity) }}">
                                                    </td>
                                                    <td>{{ number_format($item->item_price, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="text-center mt-5">
                                    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mx-2">
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
