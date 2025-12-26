@extends('layout.index')
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-xxl-4 col-md-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-inline-flex align-items-center">
                        <span class="title-icon bg-soft-danger fs-16 me-2"><i class="ti ti-alert-triangle"></i></span>
                        <h5 class="card-title mb-0">Low Stock Products</h5>
                    </div>
                    <a href="{{ route('inventory.index') }}" class="fs-13 fw-medium text-decoration-underline">View All</a>
                </div>
                <div class="card-body">
                    @foreach($lowStockProducts as $item)
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="avatar avatar-lg">
                                    <img src="assets/img/products/product-06.jpg" alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fw-bold mb-1"><a href="javascript:void(0);">{{ $item->name }}</a></h6>
                                    <p class="fs-13">SKU : {{ $item->sku }}</p>
                                </div>
                            </div>
                            <div class="text-end">
                                <p class="fs-13 mb-1">Instock</p>
                                <h6 class="text-orange fw-medium">{{ $item->stock }}</h6>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
