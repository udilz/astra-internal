@extends('layout.app')
@section('title', 'imt-astraudso | Proses Penagihan')
@section('content')
    <!-- Page Heading -->
    @include('sweetalert::alert')
    <h1 class="h3 mb-2 text-gray-800 mb-4">Proses Penagihan</h1>

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

            <h6 class="m-0 font-weight-bold text-primary">Proses Penagihan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>No Faktur</th>
                            <th>No Tagihan</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Payment Type</th>
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
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($prosespenagihan as $row)
                            <tr class="text-center">
                                <td>{{ $no++ }}</td>
                                <td>{{ $row->dataunit_no_faktur }}</td>
                                <td>{{ $row->no_tagihan }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->jatuh_tempo)->format('d F Y, H:i:s') }}</td>
                                <td>{{ $row->payment_type }}</td>
                                <td>{{ $row->dataunit->nama_sales }}</td>
                                <td>{{ $row->dataunit->nama_supervisor }}</td>
                                <td>{{ $row->dataunit->nama_customer }}</td>
                                <td>{{ $row->dataunit->material_type }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->dataunit->tanggal_faktur)->format('d F Y, H:i:s') }}</td>
                                <td>{{ $row->dataunit->warna_plat }}</td>
                                <td>{{ $row->dataunit->nama_leasing }}</td>
                                <td>{{ $row->dataunit->alur_proses_penjualan }}</td>
                                <td>
                                    @if ($row->dokumen)
                                        <span class="badge badge-primary">
                                            <a href="{{ route('download.file', $row->dokumen) }}"
                                                style="color: #ffffff">{{ $row->dokumen }}</a>
                                        </span>
                                        <!-- Tambah tombol untuk mengganti dokumen -->
                                        <form action="{{ route('prosespenagihan.update.dokumen', $row->no_tagihan) }}"
                                            method="post" id="form-{{ \Str::slug($row->no_tagihan) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="file" class="form-control upload" name="dokumen"
                                                    id="{{ \Str::slug($row->no_tagihan) }}">
                                                @error('dokumen')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </form>
                                    @else
                                        <form class="d-inline"
                                            action="{{ route('prosespenagihan.upload', $row->no_tagihan) }}" method="post"
                                            id="form-{{ \Str::slug($row->no_tagihan) }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">

                                                <input type="file" class="form-control upload" name="dokumen"
                                                    id="{{ \Str::slug($row->no_tagihan) }}">
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
                                            $prosespenagihanStatus = $row
                                                ->statuses()
                                                ->orderBy('prosespenagihan_status.tanggal_status_penagihan', 'DESC')
                                                ->first();

                                        @endphp
                                        {{ $prosespenagihanStatus ? $prosespenagihanStatus->nama : '' }}
                                    </span>
                                    <br>
                                    <!-- Button trigger modal -->
                                    <div class="header__right">
                                        @if (auth()->user()->level == 'Admin')
                                            <a class="pencil btn btn-info btn-sm mb-2" type="button"
                                                row-no_tagihan="{{ $row->no_tagihan }}"><i class="fa fa-pen-nib"></i>
                                            </a>
                                        @endif
                                    </div>

                                </td>

                                @if (auth()->user()->level == 'Admin')
                                    <td class="text-center">
                                        <div class="d-inline">
                                            <button type="button" class="btn btn-warning btn-sm mb-2" data-toggle="modal"
                                                data-target="#modalEditData"><i class="fas fa-edit"></i> Edit</button>
                                            <a href="/prosespenagihan/{{ encrypt($row->no_tagihan) }}"
                                                class="btn btn-info btn-sm mb-2"><i class="fa fa-info"></i>
                                                Status</a>

                                            <form class="d-inline"
                                                action="{{ route('prosespenagihan.delete', $row->no_tagihan) }}"
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
                    <form action="/prosespenagihan/save-status" method="POST" id="formUpdate">
                        @method('put')
                        @csrf

                        <input type="hidden" name="prosespenagihan_no_tagihan">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Pilih Status</label>
                            <select class="form-control  @error('status_id') is-invalid @enderror" name="status_id">
                                <option value="" disabled selected hidden>-- Pilih Status --</option>
                                @foreach ($statuses->whereIn('id', [1, 6, 5, 2]) as $status)
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
                            <input style="margin-top:10px" name="tanggal_status_penagihan" type="datetime-local"
                                class="form-control @error('tanggal_status_penagihan') is-invalid @enderror"
                                id="">
                            @error('tanggal_status_prosespenagihan')
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Proses Penagihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('prosespenagihan.tambah.simpan') }}" method="POST"
                        enctype="multipart/form-data">
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
                            <label for="" class="font-weight-bold">No Tagihan</label>
                            <input style="margin-top:10px" name="no_tagihan" type="text"
                                class="form-control @error('no_tagihan') is-invalid @enderror" id="no_tagihan">
                            @error('no_tagihan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group mb-3">
                            <label for="" class="font-weight-bold">Tanggal Jatuh Tempo</label>
                            <input style="margin-top:10px" name="jatuh_tempo" type="datetime-local"
                                class="form-control @error('jatuh_tempo') is-invalid @enderror" id="jatuh_tempo">
                            @error('jatuh_tempo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="" class="font-weight-bold">Payment Type</label>
                            <input style="margin-top:10px" name="payment_type" type="text"
                                class="form-control @error('payment_type') is-invalid @enderror" id="payment_type">
                            @error('payment_type')
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

    @foreach ($prosespenagihan as $no => $row)
        <!-- Modal Untuk Edit Data Proses STNK -->
        <div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Proses Penagihan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('prosespenagihan.update', $row->no_tagihan) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="editPaymentType" class="font-weight-bold">No Tagihan</label>
                                    <input style="margin-top:10px" type="text"
                                        class="form-control @error('no_tagihan') is-invalid @enderror"
                                        name="no_tagihan" value="{{ $row->no_tagihan }}">
                                    @error('no_tagihan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="editPlatNomor" class="font-weight-bold">Tangagl Jatuh Tempo</label>
                                    <input style="margin-top:10px" type="datetime-local"
                                        class="form-control @error('jatuh_tempo') is-invalid @enderror" name="jatuh_tempo"
                                        value="{{ $row->jatuh_tempo }}">
                                    @error('jatuh_tempo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="editPaymentType" class="font-weight-bold">Payment Type</label>
                                    <input style="margin-top:10px" type="text"
                                        class="form-control @error('payment_type') is-invalid @enderror"
                                        name="payment_type" value="{{ $row->payment_type }}">
                                    @error('payment_type')
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
                    'spacer',
                    'colvis'
                ]
            });

            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');

            table.on('click', '.pencil', function() {
                $('#exampleModal').modal({
                    show: true
                })

                var prosespenagihan_id = $(this).attr('row-id');
                console.log(prosespenagihan_id)
                $("input[name=prosespenagihan_id]").val(prosespenagihan_id);
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
                var prosespenagihan_no_tagihan = $(this).attr('row-no_tagihan');
                $("input[name=prosespenagihan_no_tagihan]").val(prosespenagihan_no_tagihan);
            });
            $('body').on('change', '.upload', function() {
                var inputid = $(this).attr('id')
                $('form#form-' + inputid).submit()

            });
        });
    </script>
@endpush
