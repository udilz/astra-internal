@extends('layout.app')

@section('title', 'imt-astraudso | Kirim Unit')

@section('content')
    <form action="{{ route('kirimunit.tambah.simpan') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            {{ isset($kirimunit) ?: 'Form Tambah Kirim Unit' }}
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
                                        @php
                                            $isDisabled = in_array($data->no_faktur, $usedNoFakturs) ? 'hidden' : '';
                                        @endphp
                                        <option value="{{ $data->no_faktur }}" {{ $isDisabled }}>
                                            {{ $data->no_faktur }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dataunit_no_faktur')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>



                            <div class="form-group mb-3">
                                <label for="no_rangka" class="font-weight-bold">No Rangka</label>
                                <input type="text" class="form-control @error('no_rangka') is-invalid @enderror"
                                    id="no_rangka" name="no_rangka"
                                    value="{{ isset($kirimunit) ? $kirimunit->no_rangka : old('no_rangka') }}">
                                @error('no_rangka')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="no_mesin" class="font-weight-bold">No Mesin</label>
                                <input type="text" class="form-control @error('no_mesin') is-invalid @enderror"
                                    id="no_mesin" name="no_mesin"
                                    value="{{ isset($kirimunit) ? $kirimunit->no_mesin : old('no_mesin') }}">
                                @error('no_mesin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="lokasi_tujuan" class="font-weight-bold">Lokasi Tujuan</label>
                                <textarea class="form-control @error('lokasi_tujuan') is-invalid @enderror" id="lokasi_tujuan" name="lokasi_tujuan"
                                    rows="10" value="{{ old('lokasi_tujuan') }}"></textarea>
                                @error('lokasi_tujuan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                        </div>
                    </div>
                    <div class="card-footer float-end">
                        <a href="{{ route('kirimunit') }}" class="btn btn-danger float-end float-right">Cancel</a>
                        <button type="submit" class="btn btn-primary float-end float-right mx-2">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>



@endsection
