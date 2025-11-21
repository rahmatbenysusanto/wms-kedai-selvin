@extends('layout.index')
@section('title', 'Supplier')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Supplier</h4>
                <h6>Manage your supplier</h6>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSupplierModal">
                <i class="ti ti-circle-plus me-1"></i>
                Create Supplier
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ request()->get('name') }}" placeholder="Supplier ...">
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
                                <th>Name</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($supplier as $index => $item)
                                <tr>
                                    <td>{{ $supplier->firstItem() + $index }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a class="btn btn-info btn-sm" onclick="editSupplier('{{ $item->id }}')">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" onclick="deleteSupplier('{{ $item->id }}')">
                                                <i class="fa fa-trash"></i>
                                            </a>
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

    <div id="editSupplierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Edit Supplier</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('supplier.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Supplier Name ..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="Address ...">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="createSupplierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">Create Supplier</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('supplier.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Supplier Name ..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Address ...">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function editSupplier(id) {
            $.ajax({
                url: '{{ route('supplier.find') }}',
                method: 'GET',
                data: {
                    id: id
                },
                success: (res) => {
                    const data = res.data;

                    document.getElementById('id').value = data.id;
                    document.getElementById('name').value = data.name;
                    document.getElementById('address').value = data.address;

                    $('#editSupplierModal').modal('show');
                }
            })
        }

        function deleteSupplier(id) {
            Swal.fire({
                title: "Are you sure?",
                text: `Delete Supplier`,
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mt-2",
                    cancelButton: "btn btn-danger w-xs mt-2"
                },
                confirmButtonText: "Yes, Delete it!",
                buttonsStyling: false,
                showCloseButton: true
            }).then((i) => {
                if (i.value) {

                    $.ajax({
                        url: '{{ route('supplier.delete') }}',
                        method: 'GET',
                        data: {
                            id: id,
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success!",
                                    text: `Delete Supplier Successfully!`,
                                }).then((i) => {
                                    window.location.reload();
                                })
                            }
                        }
                    });

                }
            });
        }
    </script>
@endsection
