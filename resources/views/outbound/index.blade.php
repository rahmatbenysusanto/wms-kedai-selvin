@extends('layout.index')
@section('title', 'Outbound')

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
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label">Number</label>
                                <input type="text" class="form-control" name="number" value="{{ request()->get('number') }}" placeholder="Number ...">
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
                                    <th>Outlet</th>
                                    <th class="text-center">QTY</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($outbound as $index => $item)
                                <tr>
                                    <td>{{ $outbound->firstItem() + $index }}</td>
                                    <td>{{ $item->outlet_po_number }}</td>
                                    <td>{{ $item->outlet }}</td>
                                    <td class="text-center fw-bold">{{ $item->qty }}</td>
                                    <td>
                                        @if($item->status == 'Open')
                                            <span class="badge bg-info">Open</span>
                                        @elseif($item->status == 'Close')
                                            <span class="badge bg-success">Close</span>
                                        @else
                                            <span class="badge bg-danger">Cancel</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('outbound.detail', ['id' => $item->id]) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($item->status == 'Open')
                                                <a class="btn btn-secondary btn-sm" onclick="processOutbound('{{ $item->id }}')">
                                                    <i class="fa fa-right-left"></i>
                                                </a>
                                                <a class="btn btn-danger btn-sm" onclick="cancelOutbound('{{ $item->id }}')">
                                                    <i class="fa fa-delete-left"></i>
                                                </a>
                                            @endif
                                        </div>
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

@section('js')
    <script>
        function processOutbound(id) {
            Swal.fire({
                title: "Are you sure?",
                text: 'Process Outbound',
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mt-2",
                    cancelButton: "btn btn-danger w-xs mt-2"
                },
                confirmButtonText: "Yes, Process it!",
                buttonsStyling: false,
                showCloseButton: true
            }).then((i) => {
                if (i.value) {

                    $.ajax({
                        url: '{{ route('outbound.process') }}',
                        method: 'GET',
                        data: {
                            id: id
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Successfully processing Outbound',
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

        function cancelOutbound(id) {
            function processOutbound(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: 'Cancel Outbound',
                    icon: "warning",
                    showCancelButton: true,
                    customClass: {
                        confirmButton: "btn btn-primary w-xs me-2 mt-2",
                        cancelButton: "btn btn-danger w-xs mt-2"
                    },
                    confirmButtonText: "Yes, Cancel it!",
                    buttonsStyling: false,
                    showCloseButton: true
                }).then((i) => {
                    if (i.value) {

                        $.ajax({
                            url: '{{ route('outbound.cancel') }}',
                            method: 'GET',
                            data: {
                                id: id
                            },
                            success: (res) => {
                                if (res.status) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Cancel Outbound successfully',
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
