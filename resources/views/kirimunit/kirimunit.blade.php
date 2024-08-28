@extends('layout.app')
@section('title', 'imt-astraudso | Kirim Unit')
@section('content')

    <!-- Page Heading -->
    @include('sweetalert::alert')
    <div id="success_message"></div>
    <h1 class="h3 mb-2 text-gray-800 mb-4">Kirim Unit</h1>
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
                <a href="{{ route('kirimunit.tambah') }}" class="btn btn-primary btn-sm float-right"><i
                        class="fas fa-plus"></i>
                    Tambah Data</a>
            @endif
            <h6 class="m-0 font-weight-bold text-primary">Kirim Unit</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Tanggal Faktur</th>
                            <th>No Faktur</th>
                            <th>No Rangka</th>
                            <th>No Mesin</th>
                            <th>Nama Sales</th>
                            <th>Nama Supervisor</th>
                            <th>Nama Customer</th>
                            <th>Nama Leasing</th>
                            <th>Material Type</th>
                            <th>Warna Plat</th>
                            <th>Alur Proses Penjualan</th>
                            <th>Lokasi Tujuan</th>
                            <th>Dokumen</th>
                            <th>Status</th>
                            @if (auth()->user()->level == 'Admin')
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                        <?php $no = 1; ?>
                        @foreach ($kirimunit as $row)
                            <tr class="text-center">
                                <td>{{ $no++ }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->dataunit->tanggal_faktur)->format('d F Y, H:i:s') }}</td>
                                <td>{{ $row->dataunit_no_faktur }}</td>
                                <td>{{ $row->no_rangka }}</td>
                                <td>{{ $row->no_mesin }}</td>
                                <td>{{ $row->dataunit->nama_sales }}</td>
                                <td>{{ $row->dataunit->nama_supervisor }}</td>
                                <td>{{ $row->dataunit->nama_customer }}</td>
                                <td>{{ $row->dataunit->nama_leasing }}</td>
                                <td>{{ $row->dataunit->material_type }}</td>
                                <td>{{ $row->dataunit->warna_plat }}</td>
                                <td>{{ $row->dataunit->alur_proses_penjualan }}</td>
                                <td>{{ $row->lokasi_tujuan }}</td>
                                <td>
                                    @if ($row->dokumen)
                                        <span class="badge badge-primary">
                                            <a href="{{ route('download.file', $row->dokumen) }}"
                                                style="color: #ffffff">{{ $row->dokumen }}</a>
                                        </span>
                                        <br>
                                        <!-- Tambah tombol untuk mengganti dokumen -->
                                        <form action="{{ route('kirimunit.update.dokumen', $row->no_rangka) }}"
                                            method="post" id="form-{{ \Str::slug($row->no_rangka) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="file" class="form-control upload" name="dokumen"
                                                    id="{{ \Str::slug($row->no_rangka) }}">
                                                @error('dokumen')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </form>
                                    @else
                                        <form action="{{ route('kirimunit.upload', $row->no_rangka) }}" method="post"
                                            id="form-{{ \Str::slug($row->no_rangka) }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="file" class="form-control upload" name="dokumen"
                                                    id="{{ \Str::slug($row->no_rangka) }}">
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
                                            $kirimunitStatus = $row
                                                ->statuses()
                                                ->orderBy('kirimunit_status.tanggal_status_kirimunit', 'DESC')
                                                ->first();

                                        @endphp
                                        {{ $kirimunitStatus ? $kirimunitStatus->nama : '' }}


                                    </span>
                                    <br>
                                    <!-- Button trigger modal -->
                                    <div class="header__right">
                                        @if (auth()->user()->level == 'Admin')
                                            <a class="pencil btn btn-info btn-sm mb-2" type="button"
                                                row-no_rangka="{{ $row->no_rangka }}"><i class="fa fa-pen-nib"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>

                                @if (auth()->user()->level == 'Admin')
                                    <td class="text-center">
                                        <div class="d-inline">
                                            <a href="{{ route('kirimunit.edit', encrypt($row->no_rangka)) }}"
                                                class="btn btn-warning btn-sm mb-2"><i class="fas fa-edit"></i> Edit</a>
                                            <a href="/kirimunit/{{ encrypt($row->no_rangka) }}"
                                                class="btn btn-info btn-sm mb-2"><i class="fa fa-info"></i>
                                                Status</a>
                                            <form action="{{ route('kirimunit.delete', $row->no_rangka) }}" class="ml-2">
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
                    <form action="/kirimunit/save-status" method="POST" id="formUpdate">
                        @method('put')
                        @csrf

                        <input type="hidden" name="kirimunit_no_rangka">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Pilih Status</label>
                            <select class="form-control  @error('status_id') is-invalid @enderror" name="status_id">
                                <option value="" disabled selected hidden>-- Pilih Status --</option>
                                @foreach ($statuses->whereIn('id', [1, 6, 4, 7]) as $status)
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
                            <input style="margin-top:10px" name="tanggal_status_kirimunit" type="datetime-local"
                                class="form-control @error('tanggal_status_kirimunit') is-invalid @enderror"
                                id="">
                            @error('tanggal_status_kirimunit')
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

                var kirimunit_id = $(this).attr('row-id');
                console.log(kirimunit_id)
                $("input[name=kirimunit_id]").val(kirimunit_id);
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
                var kirimunit_no_rangka = $(this).attr('row-no_rangka');
                $("input[name=kirimunit_no_rangka]").val(kirimunit_no_rangka);
            });

            $('body').on('change', '.upload', function() {
                var inputid = $(this).attr('id')
                $('form#form-' + inputid).submit()

            });

        });
    </script>
@endpush
