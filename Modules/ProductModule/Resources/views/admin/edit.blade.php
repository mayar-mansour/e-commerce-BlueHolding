@extends('layoutmodule::layouts.main')

@section('title')
    Edit Product
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
                                <h2 class="mb-0">Edit Product</h2>
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
                            <h5>Update Product</h5>
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

                            <form method="post" action="{{ route('products.update', $product->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name', $product->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="form-label">Price <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('price') is-invalid @enderror" name="price"
                                            value="{{ old('price', $product->price) }}">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control @error('stock_quantity') is-invalid @enderror"
                                            name="stock_quantity"
                                            value="{{ old('stock_quantity', $product->stock_quantity) }}">
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

                                        @if ($product->images && count($product->images))
                                            <div class="mt-2">
                                                <p>Current Images:</p>
                                                <div class="d-flex flex-wrap">
                                                    @foreach ($product->images as $image)
                                                        <img src="{{ $image->image_full_path }}" class="me-2 mb-2"
                                                            width="100" height="100" alt="Product Image">
                                                    @endforeach
                                                </div>

                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if (isset($categories))
                                    <div class="mb-4">
                                        <label class="form-label">Categories</label>
                                        <select class="form-control" multiple id="categorySelect">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if (in_array($category->id, old('categories', $product->categories->pluck('id')->toArray()))) selected @endif>
                                                    {{ $category->name }}
                                                </option>
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
                                        <select class="form-control" multiple id="tagSelect">
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->id }}"
                                                    @if (in_array($tag->id, old('tags', $product->tags->pluck('id')->toArray()))) selected @endif>
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="tags" id="tags-json">
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
        $(document).ready(function() {
            $('#categorySelect, #tagSelect').select2({
                width: '100%',
                placeholder: 'Select from list',
                allowClear: true
            });

            $('form').on('submit', function() {
                const selectedCategories = $('#categorySelect').val() || [];
                const selectedTags = $('#tagSelect').val() || [];

                $('#categories-json').val(JSON.stringify(selectedCategories));
                $('#tags-json').val(JSON.stringify(selectedTags));
            });
        });
    </script>
@endpush
