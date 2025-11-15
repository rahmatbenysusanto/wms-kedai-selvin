@extends('layout.index')
@section('title', 'Outbound Detail')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Outbound</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Outbound Detail</h4>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td class="fw-bold">Outlet</td>
                            <td class="fw-bold ms-1">:</td>
                            <td class="ms-2">{{ $outbound->outlet }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">PO Outlet Number</td>
                            <td class="fw-bold ms-1">:</td>
                            <td class="ms-2">{{ $outbound->outlet_po_number }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">QTY</td>
                            <td class="fw-bold ms-1">:</td>
                            <td class="ms-2">{{ $outbound->qty }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Material</h4>
                </div>
                <div class="card-body">
                    <table class="table align-middle">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>SKU</th>
                            <th>Name</th>
                            <th class="text-center">QTY</th>
                            <th>Satuan</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($outboundDetail as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->material->sku }}</td>
                                <td>{{ $item->material->name }}</td>
                                <td class="text-center text-bold">{{ $item->qty }}</td>
                                <td>{{ $item->satuan }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection































