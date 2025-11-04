@extends('layout.index')
@section('title', 'Create Purchase Order')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Create Purchase Order</h4>
            </div>
        </div>
        <div class="page-btn">
            <a class="btn btn-primary" onclick="processCreatePO()">
                <i class="ti ti-circle-plus me-1"></i>
                Create Purchase Order
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Purchase Order Information</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label">Supplier</label>
                            <select class="form-control" id="supplier">
                                <option value="">-- Choose Supplier --</option>
                                @foreach($suppliers as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Purchase Order Date</label>
                            <input type="date" class="form-control" id="date" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Material Purchase Order</h4>
                        <a class="btn btn-info btn-sm">Add Material</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="listMaterial">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addMaterialModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel">List Material</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SKU</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($material as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" onclick="processAddMaterial('{{ $item->id }}')">Add Material</a>
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
        localStorage.clear();

        function addMaterial() {
            $('#addMaterialModal').modal('show');
        }

        function processAddMaterial(materialId) {
            $.ajax({
                url: '{{ route('material.find') }}',
                method: 'GET',
                data: {
                    id: materialId,
                },
                success: (res) => {
                    const data = res.data;
                    const material = JSON.parse(localStorage.getItem('material')) ?? [];
                    const find = material.find((item) => item.id === parseInt(materialId));
                    if (find !== undefined) {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Material already exists!',
                            icon: 'warning',
                        });

                        return true;
                    }

                    material.push({
                        id: data.id,
                        sku: data.sku,
                        name: data.name,
                        category: data.category.name,
                        qty: 1,
                        price: 0,
                        total: 0,
                    });

                    localStorage.setItem('material', JSON.stringify(material));
                    viewMaterial();
                    $('#addMaterialModal').modal('hide');
                }
            });
        }

        function viewMaterial() {
            const material = JSON.parse(localStorage.getItem('material')) ?? [];
            let html = '';

            material.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.sku}</td>
                        <td>${item.name}</td>
                        <td>${item.category}</td>
                        <td>
                            <input type="number" class="form-control" value="${item.qty}" onchange="changeQTY(${index}, this.value)">
                        </td>
                        <td>
                            <input type="number" class="form-control" value="${item.price}" onchange="changePrice(${index}, this.value)">
                        </td>
                        <td>${item.total}</td>
                        <td><a class="btn btn-danger btn-sm" onclick="deleteMaterial(${index})"><i class="fa fa-trash"></i></a></td>
                    </tr>
                `;
            });

            document.getElementById('listMaterial').innerHTML = html;
        }

        function changeQTY(index, value) {
            const material = JSON.parse(localStorage.getItem('material')) ?? [];

            material[index].qty = parseInt(value);
            material[index].total = parseInt(value) * parseInt(material[index].price);

            localStorage.setItem('material', JSON.stringify(material));
            viewMaterial();
        }

        function changePrice(index, value) {
            const material = JSON.parse(localStorage.getItem('material')) ?? [];

            material[index].price = parseInt(value);
            material[index].total = parseInt(value) * parseInt(material[index].qty);

            localStorage.setItem('material', JSON.stringify(material));
            viewMaterial();
        }

        function deleteMaterial(index) {
            const material = JSON.parse(localStorage.getItem('material')) ?? [];
            material.splice(index, 1);
            localStorage.setItem('material', JSON.stringify(material));
            viewMaterial();
        }

        function processCreatePO() {
            Swal.fire({
                title: "Are you sure?",
                text: `Create Purchase Order`,
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mt-2",
                    cancelButton: "btn btn-danger w-xs mt-2"
                },
                confirmButtonText: "Yes, Create it!",
                buttonsStyling: false,
                showCloseButton: true
            }).then((i) => {
                if (i.value) {

                    $.ajax({
                        url: '{{ route('purchase_order.store') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            material: JSON.parse(localStorage.getItem('material')) ?? [],
                            supplier: document.getElementById('supplier').value,
                            date: document.getElementById('date').value,
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Create Purchase Order Success!',
                                    icon: 'success',
                                }).then((i) => {
                                    window.location.href = '{{ route('purchase_order.index') }}';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Create Purchase Order Failed!',
                                    icon: 'error',
                                });
                            }
                        }
                    });

                }
            });
        }
    </script>
@endsection
