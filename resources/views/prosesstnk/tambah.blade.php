@extends('layout.app')

@section('title', 'page')

@section('content')
    <form action="{{ route('prosesstnk.tambah.simpan') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            {{ isset($prosesstnk) ?: 'Form Tambah Proses STNK' }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">

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
                                <label for="plat_nomor" class="font-weight-bold">Plat Nomor</label>
                                <input type="text" class="form-control @error('plat_nomor') is-invalid @enderror"
                                        id="plat_nomor" name="plat_nomor"
                                        value="{{ isset($prosesstnk) ? $prosesstnk->plat_nomor : old('plat_nomor') }}">
                                @error('plat_nomor')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="card-footer float-end">
                        <a href="{{ route('prosesstnk') }}" class="btn btn-danger float-end float-right">Cancel</a>
                        <button type="submit" class="btn btn-primary float-end float-right mx-2">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
