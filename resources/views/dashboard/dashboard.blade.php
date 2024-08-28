@extends('layout.app')
@section('title', 'imt-astraudso | Dashboard')
@section('content')

    <h1 class="h3 mb-2 text-gray-800 mb-4">Dashboard</h1>
    <div class="row">

        <div class="col-lg-9 mb-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h2>Selamat Datang, {{ auth()->user()->nama ?? '' }} </h2>

                </div>
            </div>
        </div>


        <div class="col-3 mb-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="jam">
                        <span id="time"></span>
                        <span id="sec"></span>
                        <span id="mid"></span>
                    </div>

                    <div class="tanggal">

                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Data Unit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDataunit }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4 float-left">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Kirim Unit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKirimunit }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Proses STNK
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $totalProsesstnk }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Proses Penagihan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProsespenagihan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card shadow col-lg-12 mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kirim Unit</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Sales</th>
                            <th>Nama Supervisor</th>
                            <th>Nama Customer</th>
                            <th>No Faktur</th>
                            <th>Material Type</th>
                            <th>Warna Plat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($kirimunit as $data)
                            @php
                                $kirimunitStatus = $data
                                    ->statuses()
                                    ->orderBy('kirimunit_status.tanggal_status_kirimunit', 'DESC')
                                    ->first();
                            @endphp

                            @if ($kirimunitStatus && $kirimunitStatus->nama === 'Delivered')
                                <tr class="text-center">
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->dataunit->nama_sales }}</td>
                                    <td>{{ $data->dataunit->nama_supervisor }}</td>
                                    <td>{{ $data->dataunit->nama_customer }}</td>
                                    <td>{{ $data->dataunit->no_faktur }}</td>
                                    <td>{{ $data->dataunit->material_type }}</td>
                                    <td>{{ $data->dataunit->warna_plat }}</td>
                                    <td>
                                        <span class="badge badge-rounded-pill bg-{{ $data->status_style }}">
                                            <a href="/kirimunit/{{ encrypt($data->no_faktur) }}" style="color: #ffffff">
                                                {{ $kirimunitStatus->nama }}
                                            </a>
                                        </span>

                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="card shadow col-12 mb-4 ">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Proses STNK</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Sales</th>
                            <th>Nama Supervisor</th>
                            <th>Nama Customer</th>
                            <th>No Faktur</th>
                            <th>Material Type</th>
                            <th>Warna Plat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($prosesstnk as $row)
                            @php
                                $prosesstnkStatus = $row
                                    ->statuses()
                                    ->orderBy('prosesstnk_status.tanggal_status_prosesstnk', 'DESC')
                                    ->first();
                            @endphp

                            @if ($prosesstnkStatus && $prosesstnkStatus->nama === 'Finished')
                                <tr class="text-center">
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $row->dataunit->nama_sales }}</td>
                                    <td>{{ $row->dataunit->nama_supervisor }}</td>
                                    <td>{{ $row->dataunit->nama_customer }}</td>
                                    <td>{{ $row->dataunit->no_faktur }}</td>
                                    <td>{{ $row->dataunit->material_type }}</td>
                                    <td>{{ $row->dataunit->warna_plat }}</td>
                                    <td>
                                        <span class="badge badge-rounded-pill bg-{{ $row->status_style }}">
                                            <a href="/prosesstnk/{{ encrypt($row->no_faktur) }}" style="color: #ffffff">
                                                {{ $prosesstnkStatus->nama }}
                                            </a>
                                        </span>

                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="card shadow col-lg-12 mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Proses Penagihan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Sales</th>
                            <th>Nama Supervisor</th>
                            <th>Nama Customer</th>
                            <th>No Faktur</th>
                            <th>Material Type</th>
                            <th>Warna Plat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($prosespenagihan as $data)
                            @php
                                $prosespenagihanStatus = $data
                                    ->statuses()
                                    ->orderBy('prosespenagihan_status.tanggal_status_penagihan', 'DESC')
                                    ->first();
                            @endphp

                            @if ($prosespenagihanStatus && $prosespenagihanStatus->nama === 'Completed')
                                <tr class="text-center">
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->dataunit->nama_sales }}</td>
                                    <td>{{ $data->dataunit->nama_supervisor }}</td>
                                    <td>{{ $data->dataunit->nama_customer }}</td>
                                    <td>{{ $data->dataunit->no_faktur }}</td>
                                    <td>{{ $data->dataunit->material_type }}</td>
                                    <td>{{ $data->dataunit->warna_plat }}</td>
                                    <td>
                                        <span class="badge badge-rounded-pill bg-{{ $data->status_style }}">
                                            <a href="/prosespenagihan/{{ encrypt($data->no_faktur) }}" style="color: #ffffff">
                                                {{ $prosespenagihanStatus->nama }}
                                            </a>
                                        </span>

                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>


                </table>

            </div>
        </div>

    </div>


@endsection

@push('datatable')
    <script src="{{ asset('template/js/datatable.js') }}"></script>
@endpush
