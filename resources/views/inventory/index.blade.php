@extends('layout.index')
@section('title', 'Inventory')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Inventory</h4>
                <h6>Manage your inventory</h6>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label">SKU</label>
                                <input type="text" class="form-control" name="sku" value="{{ request()->get('sku') }}" placeholder="SKU ...">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Material</label>
                                <input type="text" class="form-control" name="material" value="{{ request()->get('material') }}" placeholder="Material ...">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Category</label>
                                <select class="form-control" name="category">
                                    <option value="">-- Choose Category --</option>
                                    @foreach($category as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == request()->get('category') ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label class="form-label text-white">-</label>
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-info">Search</button>
                                    <a href="{{ url()->current() }}" class="btn btn-danger ms-2">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SKU</th>
                                    <th>Material</th>
                                    <th>Category</th>
                                    <th class="text-center">Min Stock</th>
                                    <th class="text-center">Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($inventory as $index => $item)
                                <tr>
                                    <td>{{ $inventory->firstItem() + $index }}</td>
                                    <td>{{ $item->material->sku }}</td>
                                    <td>{{ $item->material->name }}</td>
                                    <td>{{ $item->material->category->name }}</td>
                                    <td class="text-center fw-bold">{{ number_format($item->material->min_stock) }} {{ $item->material->satuan }}</td>
                                    <td class="text-center fw-bold">{{ number_format($item->stock * 1000) }} {{ $item->material->satuan }}</td>
                                    <td>
                                        <a href="{{ route('inventory.detail', ['id' => $item->id]) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </a>
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
@endsection
