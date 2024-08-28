@extends('layout.app')
@section('title', 'imt-astraudso | Update Status')
@section('content')
    @include('sweetalert::alert')
    <div class="row">
        <div class="col-6 ">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <div class="row ">
                        <div class="col-md-6">
                            <h5 class="mb-3 font-weight-bold text-primary">Unit Details</h5>
                        </div>
                        <div class=" col-md-6 d-flex justify-content-end align-items-center">
                            <i class="far fa-calendar-alt me-2 px-2" aria-hidden="true"></i>
                            <small>{{ $prosesstnk->dataunit->tanggal_faktur }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <ul class="list-group">
                        <li
                            class="bg-gradient-light list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <button
                                    class="btn btn-icon-only btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i
                                        class="fa fa-user" aria-hidden="true"></i></button>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Nama Sales</h6>
                                    <span class="text-gray-800">{{ $prosesstnk->dataunit->nama_sales }}</span>
                                </div>
                            </div>
                        </li>

                        <li
                            class="bg-gradient-light list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <button
                                    class="btn btn-icon-only btn-rounded  mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i
                                        class="fa fa-user" aria-hidden="true"></i></button>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Nama Supervisor</h6>
                                    <span class="text-gray-800">{{ $prosesstnk->dataunit->nama_supervisor }}</span>
                                </div>
                            </div>
                        </li>

                        <li
                            class="bg-gradient-light list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <button
                                    class="btn btn-icon-only btn-rounded  mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i
                                        class="fa fa-user" aria-hidden="true"></i></button>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Nama Customer</h6>
                                    <span class="text-gray-800">{{ $prosesstnk->dataunit->nama_customer }}</span>
                                </div>
                            </div>
                        </li>

                        <li
                            class="bg-gradient-light list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <button
                                    class="btn btn-icon-only btn-rounded  mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i
                                        class="fa fa-file" aria-hidden="true"></i></button>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">No Faktur</h6>
                                    <span class="text-gray-800">{{ $prosesstnk->dataunit->no_faktur }}</span>
                                </div>
                            </div>
                        </li>

                        </li>
                        <li
                            class="bg-gradient-light list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <button
                                    class="btn btn-icon-only btn-rounded  mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i
                                        class="fa fa-bookmark" aria-hidden="true"></i></button>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Alur Proses Penjualan</h6>
                                    <span class="text-gray-800">{{ $prosesstnk->dataunit->alur_proses_penjualan }}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <br>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Kirim Unit</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-center">
                                    <th>Material Type</th>

                                    <th>Tanggal Faktur</th>
                                    <th>Warna Plat</th>
                                    <th>Nama Leasing</th>
                                    <th>Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr class="text-center">
                                    <td>{{ $prosesstnk->dataunit->material_type }}</td>
                                    <td>{{ $prosesstnk->dataunit->tanggal_faktur }}</td>
                                    <td>{{ $prosesstnk->dataunit->warna_plat }}</td>
                                    <td>{{ $prosesstnk->dataunit->nama_leasing }}</td>
                                    <td>
                                        @if ($prosesstnk->dokumen)
                                            <span class="badge badge-primary">
                                                <a href="{{ route('download.file', $prosesstnk->dokumen) }}"
                                                    style="color: #ffffff">{{ $prosesstnk->dokumen }}</a>
                                            </span>
                                        @else
                                        @endif

                                    </td>

                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-6">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-3 font-weight-bold text-primary">Status</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    <ul class="list-group">
                        @foreach ($prosesstnk->statuses()->orderBy('prosesstnk_status.tanggal_status_prosesstnk', 'DESC')->get() as $status)
                            <li class="list-group-item border-0 p-3 mb-2 bg-gray-200 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="mb-3 text-dark font-weight-bold">{{ $status->nama }}</h6>
                                    <span class="mb-2 text">Description : <span
                                            class="text-dark font-weight-bold ms-sm-3 ">{{ $status->description }}</span>
                                        <br>
                                        <span class="mb-2 text">Keterangan : <span
                                                class="text-dark font-weight-bold ms-sm-3 ">{{ $status->pivot->keterangan }}</span>

                                </div>

                                <div class="header__right col-md-15 d-flex justify-content-end align-items-center">
                                    @if (auth()->user()->level == 'Admin')
                                        <form
                                            action="{{ route('prosesstnk.delete-status', ['statusid' => $status->id, 'prosesstnk_plat_nomor' => $prosesstnk->plat_nomor]) }}">
                                            <a class="fas fa-trash text-dark px-2  confirm-delete"aria-hidden="true"></a>
                                        </form>
                                    @endif
                                    <a href="#" class="pencil" type="button" data-toggle="modal"
                                        data-target="#exampleModal" status-id="{{ $status->id }}">
                                        {{ \Carbon\Carbon::parse($status->pivot->tanggal_status_prosesstnk)->format('d F Y, H:i:s') }}</a>


                                </div>

                            </li>
                        @endforeach
                    </ul>

                </div>

            </div>

        </div>

    </div>

    <!-- Modal Untuk Update Status -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Tanggal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/prosesstnk/updatestatustanggal" method="POST" id="formUpdate">
                        @method('put')
                        @csrf
                        <input type="hidden" name="prosesstnk_plat_nomor" value="{{ $prosesstnk->plat_nomor }}">
                        <input type="hidden" name="status_id">
                        <input style="margin-top:10px" name="tanggal_status_prosesstnk" type="datetime-local" class="form-control"
                            id="exampleInputEmail">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnUpdate">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $("#btnUpdate").click(function() {
                $("#formUpdate").submit();
            });
            $(".pencil").click(function() {
                var status_id = $(this).attr('status-id');
                $("input[name=status_id]").val(status_id);
            });

        });
    </script>
@endpush
