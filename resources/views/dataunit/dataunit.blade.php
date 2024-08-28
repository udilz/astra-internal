@extends('layout.app')
@section('title', ' imt-astraudso | Create Data Unit')
@section('content')
    <!-- Page Heading -->
    @include('sweetalert::alert')
    <h1 class="h3 mb-2 text-gray-800 mb-4">Create Data Unit</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @if (auth()->user()->level == 'Admin')
                <a href="{{ route('dataunit.tambah') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i>
                    Tambah Data</a>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>No Faktur</th>
                            <th>Tanggal Faktur</th>
                            <th>Nama Sales</th>
                            <th>Nama Supervisor</th>
                            <th>Nama Customer</th>
                            <th>Nama Leasing</th>
                            <th>Material Type</th>
                            <th>Warna Plat</th>
                            <th>Alur Proses Penjualan</th>
                            @if (auth()->user()->level == 'Admin')
                                <th>
                                    Action
                                </th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($dataunit as $row)
                            <tr class="text-center">
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->no_faktur }}</a></td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal_faktur)->format('d F Y, H:i:s') }} </td>
                                <td>{{ $row->nama_sales }}</td>
                                <td>{{ $row->nama_supervisor }}</td>
                                <td>{{ $row->nama_customer }}</td>
                                <td>{{ $row->nama_leasing }}</td>
                                <td>{{ $row->material_type }}</td>
                                <td>{{ $row->warna_plat }}</td>
                                <td>{{ $row->alur_proses_penjualan }}</td>
                                @if (auth()->user()->level == 'Admin')
                                    <td class="text-center">
                                        <div class="container">
                                            <div class="row">
                                                <a href="{{ route('dataunit.edit', encrypt($row->no_faktur)) }}"
                                                    class="btn btn-warning btn-sm mb-2"><i class="fas fa-edit"></i> Edit</a>
                                                <form action="{{ route('dataunit.delete', $row->no_faktur) }}"
                                                    class="ml-10">
                                                    <button class="btn btn-danger  btn-sm confirm-delete"><i
                                                            class="fa fa-trash"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            </tr>
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
