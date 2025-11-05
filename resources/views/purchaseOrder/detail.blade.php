@extends('layout.index')
@section('title', 'Detail Purchase Order')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Detail Purchase Order</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table>
                        <tr>
                            <td class="fw-bold">Supplier</td>
                            <td class="fw bold ms-1">:</td>
                            <td class="ms-2">{{ $purchaseOrder->supplier->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">PO Number</td>
                            <td class="fw bold ms-1">:</td>
                            <td class="ms-2">{{ $purchaseOrder->number }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status PO</td>
                            <td class="fw bold ms-1">:</td>
                            <td class="ms-2">{{ $purchaseOrder->status }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">QTY PO</td>
                            <td class="fw bold ms-1">:</td>
                            <td class="ms-2">{{ $purchaseOrder->qty }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">List Material</h4>
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
                                    <th class="text-center">QTY</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($purchaseOrderDetail as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->material->sku }}</td>
                                    <td>{{ $item->material->name }}</td>
                                    <td>{{ $item->material->category->name }}</td>
                                    <td class="text-center fw-bold">{{ $item->qty }}</td>
                                    <td class="fw-bold">Rp {{ number_format($item->price) }}</td>
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
