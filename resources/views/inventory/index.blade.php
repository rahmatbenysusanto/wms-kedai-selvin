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
