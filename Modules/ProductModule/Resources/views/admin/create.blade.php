@extends('layoutmodule::layouts.main')

@section('title')
    Create Product
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
                                <h2 class="mb-0">Create New Product</h2>
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
                            <h5>Add Product</h5>
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

                            <form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Product Name <span class="text-danger">(required)</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" placeholder="Enter product name" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="form-label">Price <span class="text-danger">(required)</span></label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('price') is-invalid @enderror" name="price"
                                            placeholder="Enter price" value="{{ old('price') }}">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                        placeholder="Enter product description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Stock Quantity <span class="text-danger">(required)</span></label>
                                        <input type="number"
                                            class="form-control @error('stock_quantity') is-invalid @enderror"
                                            name="stock_quantity" value="{{ old('stock_quantity') }}">
                                        @error('stock_quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="form-label">Images</label>
                                        <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                            name="images[]" multiple>
                                        @error('images.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                @if (isset($categories))
                                    <div class="mb-4">
                                        <label class="form-label">Categories</label>
                                        <select id="category-select" class="form-control" multiple>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                        <input type="hidden" name="categories" id="categories-json">

                                        @error('categories')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                @if (isset($tags))
                                    <div class="mb-4">
                                        <label class="form-label">Tags</label>
                                        <select class="form-control @error('tags') is-invalid @enderror" name="tags[]"
                                            multiple id="tagSelect">
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('tags')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <div class="text-center mt-5">
                                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mx-2">
                                        <i class="ti ti-arrow-left"></i> Back to List
                                    </a>
                                    <button type="submit" class="btn btn-primary mx-2">
                                        <i class="ti ti-device-floppy"></i> Save Product
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
            $('#category-select, #tagSelect').select2({
                width: '100%',
                placeholder: 'Select from list',
                allowClear: true
            });
        });

        document.querySelector('form').addEventListener('submit', function (e) {
            const selected = Array.from(document.querySelector('#category-select').selectedOptions).map(o => o.value);
            document.querySelector('#categories-json').value = JSON.stringify(selected);
        });
    </script>
@endpush
