@extends('layout.index')
@section('title', 'Purchase Order')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Purchase Order</h4>
            </div>
        </div>
        <div class="page-btn">
            <a href="{{ route('purchase_order.create') }}" class="btn btn-primary">
                <i class="ti ti-circle-plus me-1"></i>
                Create Purchase Order
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label">PO Number</label>
                                <input type="text" class="form-control" name="poNumber" value="{{ request()->get('poNumber') }}" placeholder="PO Number ...">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Supplier</label>
                                <select class="form-control" name="supplier">
                                    <option value="">-- Choose Supplier --</option>
                                    @foreach($suppliers as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == request()->get('supplier') ? 'selected' : '' }}>{{ $item->name }}</option>
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
                                    <th>Number</th>
                                    <th>Supplier</th>
                                    <th>QTY</th>
                                    <th>Status</th>
                                    <th>PO Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($purchaseOrder as $index => $item)
                                <tr>
                                    <td>{{ $purchaseOrder->firstItem() + $index }}</td>
                                    <td>{{ $item->number }}</td>
                                    <td>{{ $item->supplier->name }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>
                                        @if($item->status == 'Pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($item->status == 'Cancel')
                                            <span class="badge bg-danger">Cancel</span>
                                        @else
                                            <span class="badge bg-success">Done</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('purchase_order.detail', ['id' => $item->id]) }}" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($item->status == 'Pending')
                                                <a class="btn btn-info btn-sm" onclick="approvePO('{{ $item->id }}')">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm" onclick="cancelPO('{{ $item->id }}')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        @if ($purchaseOrder->hasPages())
                            <ul class="pagination">
                                @if ($purchaseOrder->onFirstPage())
                                    <li class="disabled"><span>&laquo; Previous</span></li>
                                @else
                                    <li><a href="{{ $purchaseOrder->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="prev">&laquo; Previous</a></li>
                                @endif

                                @foreach ($purchaseOrder->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="disabled"><span>{{ $element }}</span></li>
                                    @endif

                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $purchaseOrder->currentPage())
                                                <li class="active"><span>{{ $page }}</span></li>
                                            @else
                                                <li><a href="{{ $url }}&per_page={{ request('per_page', 10) }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                @if ($purchaseOrder->hasMorePages())
                                    <li><a href="{{ $purchaseOrder->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="next">Next &raquo;</a></li>
                                @else
                                    <li class="disabled"><span>Next &raquo;</span></li>
                                @endif
                            </ul>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function approvePO(id) {
            Swal.fire({
                title: "Are you sure?",
                text: `Approve Purchase Order`,
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mt-2",
                    cancelButton: "btn btn-danger w-xs mt-2"
                },
                confirmButtonText: "Yes, Approve!",
                buttonsStyling: false,
                showCloseButton: true
            }).then((i) => {
                if (i.value) {

                    $.ajax({
                        url: '{{ route('purchase_order.process') }}',
                        method: 'GET',
                        data: {
                            id: id
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Approve Purchase Order Success!',
                                    icon: "success",
                                }).then((i) => {
                                    window.location.reload();
                                });
                            }
                        }
                    });

                }
            });
        }

        function cancelPO(id) {
            Swal.fire({
                title: "Are you sure?",
                text: `Cancel Purchase Order`,
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mt-2",
                    cancelButton: "btn btn-danger w-xs mt-2"
                },
                confirmButtonText: "Yes, Cancel!",
                buttonsStyling: false,
                showCloseButton: true
            }).then((i) => {
                if (i.value) {

                    $.ajax({
                        url: '{{ route('purchase_order.cancel') }}',
                        method: 'GET',
                        data: {
                            id: id
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Cancel Purchase Order Success!',
                                    icon: "success",
                                }).then((i) => {
                                    window.location.reload();
                                });
                            }
                        }
                    });

                }
            });
        }
    </script>
@endsection
