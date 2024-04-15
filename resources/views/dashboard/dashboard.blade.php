@extends('layouts.master')
@push('head_comp')
@endpush
@section('bar_title')
    Dashboard
@endsection

@section('title')
    <h1 class="h3 mb-3">Dashboard</h1>
@endsection

@section('content')
    <div class="card flex-fill mb-1">
        <div class="card-header d-flex">
            <h5 class="card-title mb-0">Count Data</h5>
            <button class="ms-auto btn bg-info"><i class="feather-lg" data-feather="rotate-ccw"></i></button>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Total Mobil Terparkir</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="truck"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">8</h1>
                    {{-- <div class="mb-0">
                                <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> -3.65% </span>
                                <span class="text-muted">Since last week</span>
                            </div> --}}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Slot Parkir Tersedia</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="grid"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">3</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Kendaraan Masuk</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="arrow-left"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">12</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Kendaraan Keluar</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="align-middle" data-feather="arrow-right"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">10</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Data Parkir</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>Nomor Parkir</th>
                        <th>Jenis Kendaraan</th>
                        <th class="d-none d-xl-table-cell">Waktu</th>
                        <th class="d-none d-xl-table-cell">Lama Parkir</th>
                        <th class="d-none d-xl-table-cell">Total Tagihan</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>CA-001</td>
                        <td>Mobil</td>
                        <td class="d-none d-xl-table-cell">01/01/2023, 13.00 WITA</td>
                        <td class="d-none d-xl-table-cell">1 Jam</td>
                        <td class="d-none d-xl-table-cell">3000</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                        <td>
                            <button class="ms-auto btn btn-sm btn-danger"><i class="feather-lg"
                                    data-feather="trash-2"></i></button>
                            <button class="ms-auto btn btn-sm btn-info"><i class="feather-lg"
                                    data-feather="info"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @push('footer_comp')
    @endpush
@endsection
