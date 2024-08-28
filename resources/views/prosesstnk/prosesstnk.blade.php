@extends('layout.app')
@section('title', 'imt-astraudso | Kirim Unit')
@section('content')

    <!-- Page Heading -->
    @include('sweetalert::alert')
    <div id="success_message"></div>
    <h1 class="h3 mb-2 text-gray-800 mb-4">Proses STNK</h1>
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @if (auth()->user()->level == 'Admin')
                <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modalTambahData">
                    <i class="fas fa-plus"></i> Tambah Data
                </button>
            @endif
            <h6 class="m-0 font-weight-bold text-primary">Proses STNK</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>No Faktur</th>
                            <th>Plat Nomor</th>
                            <th>Nama Sales</th>
                            <th>Nama Supervisor</th>
                            <th>Nama Customer</th>
                            <th>Material Type</th>

                            <th>Tanggal Faktur</th>

                            <th>Warna Plat</th>
                            <th>Nama Leasing</th>
                            <th>Alur Proses Penjualan</th>
                            <th>Dokumen</th>
                            <th>Status</th>
                            @if (auth()->user()->level == 'Admin')
                                <th>
                                    Action
                                </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                        <?php $no = 1; ?>
                        @foreach ($prosesstnk as $row)
                            <tr class="text-center">
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->dataunit_no_faktur }}</td>
                                <td>{{ $row->plat_nomor }}</td>
                                <td>{{ $row->dataunit->nama_sales }}</td>
                                <td>{{ $row->dataunit->nama_supervisor }}</td>
                                <td>{{ $row->dataunit->nama_customer }}</td>
                                <td>{{ $row->dataunit->material_type }}</td>

                                <td> {{ \Carbon\Carbon::parse($row->dataunit->tanggal_faktur)->format('d F Y, H:i:s') }}
                                </td>

                                <td>{{ $row->dataunit->warna_plat }}</td>
                                <td>{{ $row->dataunit->nama_leasing }}</td>
                                <td>{{ $row->dataunit->alur_proses_penjualan }}</td>
                                <td>
                                    @if ($row->dokumen)
                                        <span class="badge badge-primary">
                                            <a href="{{ route('download.file', $row->dokumen) }}"
                                                style="color: #ffffff">{{ $row->dokumen }}</a>
                                        </span>
                                        <br>
                                        <!-- Tambah tombol untuk mengganti dokumen -->
                                        <form action="{{ route('prosesstnk.update.dokumen', $row->plat_nomor) }}"
                                            method="post" id="form-{{ \Str::slug($row->plat_nomor) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="file" class="form-control upload" name="dokumen"
                                                    id="{{ \Str::slug($row->plat_nomor) }}">
                                                @error('dokumen')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </form>
                                    @else
                                        <form action="{{ route('prosesstnk.upload', $row->plat_nomor) }}" method="post"
                                            id="form-{{ \Str::slug($row->plat_nomor) }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="file" class="form-control upload" name="dokumen"
                                                    id="{{ \Str::slug($row->plat_nomor) }}">
                                                @error('dokumen')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <span class="mb-2 badge badge-rounded-pill bg-{{ $row->status_style }}"
                                        style="color: #ffffff">
                                        @php
                                            $prosesstnkStatus = $row
                                                ->statuses()
                                                ->orderBy('prosesstnk_status.tanggal_status_prosesstnk', 'DESC')
                                                ->first();

                                        @endphp
                                        {{ $prosesstnkStatus ? $prosesstnkStatus->nama : '' }}
                                    </span>
                                    <br>
                                    <!-- Button trigger modal -->
                                    <div class="header__right">
                                        @if (auth()->user()->level == 'Admin')
                                            <a class="pencil btn btn-info btn-sm mb-2" type="button"
                                                row-plat_nomor="{{ $row->plat_nomor }}"><i class="fa fa-pen-nib"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>

                                @if (auth()->user()->level == 'Admin')
                                    <td class="text-center">
                                        <div class="d-inline">
                                            <button type="button" class="btn btn-warning btn-sm mb-2" data-toggle="modal"
                                                data-target="#modalEditData{{ $row->plat_nomor }}"><i
                                                    class="fas fa-edit"></i> Edit</button>
                                            <a href="/prosesstnk/{{ encrypt($row->plat_nomor) }}"
                                                class="btn btn-info btn-sm mb-2"><i class="fa fa-info"></i>
                                                Status</a>
                                            <form action="{{ route('prosesstnk.delete', $row->plat_nomor) }}"
                                                class="ml-2">
                                                <button class="btn btn-danger  btn-sm confirm-delete"><i
                                                        class="fa fa-trash"></i> Delete</button>
                                            </form>
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

    <!-- Modal Untuk Update Status -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/prosesstnk/save-status" method="POST" id="formUpdate">
                        @method('put')
                        @csrf

                        <input type="hidden" name="prosesstnk_plat_nomor">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Pilih Status</label>
                            <select class="form-control  @error('status_id') is-invalid @enderror" name="status_id">
                                <option value="" disabled selected hidden>-- Pilih Status --</option>
                                @foreach ($statuses->whereIn('id', [1, 6, 8]) as $status)
                                    <option value="{{ $status->id }}">{{ $status->nama }}</option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="" class="font-weight-bold">Tanggal Status</label>
                            <input style="margin-top:10px" name="tanggal_status_prosesstnk" type="datetime-local"
                                class="form-control @error('tanggal_status_prosesstnk') is-invalid @enderror"
                                id="">
                            @error('tanggal_status_prosesstnk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Keterangan</label>
                            <textarea style="margin-top:10px" type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                id="" name="keterangan" rows="5" value=""></textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnUpdate">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Untuk Tambah Data Proses STNK -->
    <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Proses STNK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('prosesstnk.tambah.simpan') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="dataunit_no_faktur" class="font-weight-bold">No Faktur</label>
                            <select class="form-control @error('dataunit_no_faktur') is-invalid @enderror"
                                id="dataunit_no_faktur" name="dataunit_no_faktur">
                                <option value="" disabled selected hidden>-- Pilih No Faktur --</option>
                                @foreach ($dataunit as $data)
                                    <option value="{{ $data->no_faktur }}">{{ $data->no_faktur }}</option>
                                @endforeach
                            </select>
                            @error('dataunit_no_faktur')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="" class="font-weight-bold">Plat Nomor</label>
                            <input style="margin-top:10px" name="plat_nomor" type="text"
                                class="form-control @error('plat_nomor') is-invalid @enderror" id="plat_nomor">
                            @error('plat_nomor')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Tambah Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($prosesstnk as $no => $row)
        <!-- Modal Untuk Edit Data Proses STNK -->
        <div class="modal fade" id="modalEditData{{ $row->plat_nomor }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Proses STNK</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('prosesstnk.update', $row->plat_nomor) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="editPlatNomor" class="font-weight-bold">Plat Nomor</label>
                                    <input style="margin-top:10px" type="text"
                                        class="form-control @error('plat_nomor') is-invalid @enderror" name="plat_nomor"
                                        value="{{ $row->plat_nomor }}">
                                    @error('plat_nomor')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach




@endsection
@push('datatable')
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({

                columnDefs: [{
                    'className': 'text-center',
                    'targets': '_all'
                }],

                buttons: [
                    'excel',
                    'spacer',
                    'spacer',
                    'colvis',
                ]
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');

            table.on('click', '.pencil', function() {
                $('#exampleModal').modal({
                    show: true
                })

                var prosesstnk_id = $(this).attr('row-id');
                console.log(prosesstnk_id)
                $("input[name=prosesstnk_id]").val(prosesstnk_id);
            });

        });
    </script>
@endpush


@push('scripts')
    <script>
        $(document).ready(function() {
            $("#btnUpdate").click(function() {
                $("#formUpdate").submit();
            });

            $(".pencil").click(function() {
                var prosesstnk_plat_nomor = $(this).attr('row-plat_nomor');
                $("input[name=prosesstnk_plat_nomor]").val(prosesstnk_plat_nomor);
            });

            $('body').on('change', '.upload', function() {
                var inputid = $(this).attr('id')
                $('form#form-' + inputid).submit()

            });

        });
    </script>
@endpush
