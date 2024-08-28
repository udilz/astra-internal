@extends('layout.app')

@section('title', 'imt-astraudso | Update Status')

@section('content')
    <form action="{{ route('prosespenagihan.update', $prosespenagihan->no_faktur) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Edit Data </h6>
                    </div>
                    <div class="card-body">

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                            <label for="nama_sales" class="font-weight-bold">Nama Sales</label>
                                            <input type="text"
                                                class="form-control @error('nama_sales')
                                        is-invalid
                                    @enderror"
                                                id="nama_sales" name="nama_sales"
                                                value="{{ isset($prosespenagihan) ? $prosespenagihan->nama_sales : '' }} ">
                                            @error('nama_sales')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>

                                    <div class="form-group">

                                            <label for="nama_supervisor" class="font-weight-bold">Nama Supervisor</label>
                                            <input type="text"
                                                class="form-control @error('nama_supervisor')
                                        is-invalid
                                    @enderror"
                                                id="nama_supervisor" name="nama_supervisor"
                                                value="{{ isset($prosespenagihan) ? $prosespenagihan->nama_supervisor : '' }} ">
                                            @error('nama_supervisor')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>

                                    <div class="form-group">

                                            <label for="nama_customer" class="font-weight-bold">Nama Customer</label>
                                            <input type="text"
                                                class="form-control @error('nama_customer')
                                        is-invalid
                                    @enderror"
                                                id="nama_customer" name="nama_customer"
                                                value="{{ isset($prosespenagihan) ? $prosespenagihan->nama_customer : '' }} ">
                                            @error('nama_customer')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>

                                    <div class="form-group">

                                            <label for="no_rangka" class="font-weight-bold">No Rangka</label>
                                            <input type="text"
                                                class="form-control @error('no_rangka')
                                        is-invalid
                                    @enderror"
                                                id="no_rangka" name="no_rangka"
                                                value="{{ isset($prosespenagihan) ? $prosespenagihan->no_rangka : '' }} ">
                                            @error('no_rangka')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>

                                    <div class="form-group">

                                            <label for="no_mesin" class="font-weight-bold">No Mesin</label>
                                            <input type="text"
                                                class="form-control @error('no_mesin')
                                        is-invalid
                                    @enderror"
                                                id="no_mesin" name="no_mesin"
                                                value="{{ isset($prosespenagihan) ? $prosespenagihan->no_mesin : '' }} ">
                                            @error('no_mesin')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>

                                    <div class="form-group">

                                            <label for="no_faktur" class="font-weight-bold">No Faktur</label>
                                            <input type="text"
                                                class="form-control  @error('no_faktur')
                                        is-invalid
                                    @enderror"
                                                id="no_faktur" name="no_faktur"
                                                value="{{ isset($prosespenagihan) ? $prosespenagihan->no_faktur : '' }} ">
                                            @error('no_faktur')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>

                                    <div class="form-group">

                                            <label for="material_type" class="font-weight-bold">Material Type</label>
                                            <input type="text"
                                                class="form-control @error('material_type')
                                        is-invalid
                                    @enderror"
                                                id="material_type" name="material_type"
                                                value="{{ isset($prosespenagihan) ? $prosespenagihan->material_type : '' }} ">
                                            @error('material_type')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>

                                    <div class="form-group">

                                            <label for="payment_type" class="font-weight-bold">Payment Type</label>
                                            <input type="text"
                                                class="form-control @error('material_type')
                                        is-invalid
                                    @enderror"
                                                id="payment_type" name="payment_type"
                                                value="{{ isset($prosespenagihan) ? $prosespenagihan->payment_type : '' }} ">
                                            @error('payment_type')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <div class="form-group">

                                            <label for="tanggal_faktur" class="font-weight-bold">Tanggal Faktur</label>
                                            <input type="date"
                                                class="form-control @error('tanggal_faktur')
                                        is-invalid
                                    @enderror"
                                                id="tanggal_faktur " name="tanggal_faktur"
                                                value="{{ isset($prosespenagihan) ? $prosespenagihan->tanggal_faktur : '' }}">
                                            @error('tanggal_faktur')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>

                                    <div class="form-group">

                                            <label for="tanggal_jatuh_tempo" class="font-weight-bold">Tanggal Jatuh
                                                Tempo</label>
                                            <input type="date"
                                                class="form-control @error('tanggal_jatuh_tempo')
                                        is-invalid
                                    @enderror"
                                                id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo"
                                                value="{{ isset($prosespenagihan) ? $prosespenagihan->tanggal_jatuh_tempo : '' }}">
                                            @error('tanggal_jatuh_tempo')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>

                                    <div class="form-group">

                                            <label for="alur_proses_penjualan" class="font-weight-bold">Alur Proses
                                                Penjualan</label>
                                            <textarea type="text"
                                                class="form-control @error('alur_proses_penjualan')
                                        is-invalid
                                    @enderror"
                                                id="alur_proses_penjualan" name="alur_proses_penjualan"  rows="5" value="">{{ isset($prosespenagihan) ? $prosespenagihan->alur_proses_penjualan : '' }}</textarea>
                                            @error('alur_proses_penjualan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>




                                    <div class="form-group">

                                            <label for="warna_plat" class="font-weight-bold">Warna Plat</label>
                                            <input type="text"
                                                class="form-control @error('warna_plat')
                                        is-invalid
                                    @enderror"
                                                id="warna_plat" name="warna_plat"
                                                value="{{ isset($prosespenagihan) ? $prosespenagihan->warna_plat : '' }} ">
                                            @error('warna_plat')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>

                                    <div class="form-group">

                                            <label for="nama_leasing" class="font-weight-bold">Nama Leasing</label>
                                            <input type="text"
                                                class="form-control @error('nama_leasing')
                                        is-invalid
                                    @enderror"
                                                id="nama_leasing" name="nama_leasing"
                                                value="{{ isset($prosespenagihan) ? $prosespenagihan->nama_leasing : '' }} ">
                                            @error('nama_leasing')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>

                                        @enderror
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer float-end">
                        <a href="{{ route('prosespenagihan') }}" class="btn btn-danger float-end float-right ">Cancel</a>
                        <button type="submit" class="btn btn-primary float-end float-right mx-2">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>


@endsection
