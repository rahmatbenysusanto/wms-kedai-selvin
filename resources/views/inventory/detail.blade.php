@extends('layout.index')
@section('title', 'Detail Inventory')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Inventory Detail</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>PO Number</th>
                                <th>Date</th>
                                <th>QTY</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($inventoryDetail as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->purchaseOrderDetail->purchaseOrder->number }}</td>
                                <td>{{ $detail->created_at }}</td>
                                <td>{{ number_format($detail->qty) }}</td>
                                <td>Rp {{ number_format($detail->price) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
