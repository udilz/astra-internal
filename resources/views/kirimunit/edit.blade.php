@extends('layout.app')

@section('title', 'imt-astraudso | Kirim Unit')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{ route('kirimunit.update', $kirimunit->no_rangka) }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card shadow mb-24">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Edit Data</h6>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editNoRangka" class="font-weight-bold">No Rangka</label>
                                        <input style="margin-top:10px" type="text" class="form-control @error('no_rangka') is-invalid @enderror"
                                            name="no_rangka" value="{{ isset($kirimunit) ? $kirimunit->no_rangka : '' }}">
                                        @error('no_rangka')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editNoMesin" class="font-weight-bold">No Mesin</label>
                                        <input style="margin-top:10px" type="text" class="form-control @error('no_mesin') is-invalid @enderror"
                                            name="no_mesin" value="{{ isset($kirimunit) ? $kirimunit->no_mesin : '' }}">
                                        @error('no_mesin')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="editTujuan" class="font-weight-bold">Lokasi Tujuan</label>
                                        <textarea style="margin-top:10px" type="text" class="form-control @error('lokasi_tujuan') is-invalid @enderror"
                                            name="lokasi_tujuan" rows="10">{{ $kirimunit->lokasi_tujuan }}</textarea>
                                        @error('lokasi_tujuan')
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
                        <a href="{{ route('kirimunit') }}" class="btn btn-danger float-end float-right">Cancel</a>
                        <button type="submit" class="btn btn-primary float-end float-right mx-2">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
