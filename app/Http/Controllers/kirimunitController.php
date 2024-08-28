<?php

namespace App\Http\Controllers;

use App\Models\dataunit;
use App\Models\kirimunit;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class kirimunitController extends Controller
{
    public function index()
    {
        $kirimunit = kirimunit::all();
        $statuses = status::all();
        $dataunit = dataunit::all(); // Assuming you have a Dataunit model

        return view('kirimunit.kirimunit', compact('kirimunit', 'statuses', 'dataunit'));
    }

    public function tambah()
    {
        // Retrieve the list of used no_faktur values from the kirimunit table
        $usedNoFakturs = Kirimunit::pluck('dataunit_no_faktur')->toArray();
        // Retrieve all dataunit
        $dataunit = Dataunit::all();

        return view('kirimunit.tambah', compact('dataunit', 'usedNoFakturs'));
    }



    public function simpan(Request $request)
    {
        $this->validate($request, [

            'dataunit_no_faktur' => 'required',
            'no_rangka' => 'required|unique:kirimunits|min:17',
            'no_mesin' => 'required|min:16|unique:kirimunits',
            'lokasi_tujuan' => 'required|min:5',
        ]);

        kirimunit::create($request->all());

        alert()->success('Success', 'Data Berhasil Ditambah');
        return redirect()->route('kirimunit');
    }

    public function edit($no_rangka)
    {
        $kirimunit = kirimunit::find(decrypt($no_rangka));

        // Retrieve $dataunit from the database or wherever you get it
        $dataunit = dataunit::all();

        return view('kirimunit.edit', compact('kirimunit', 'dataunit'));
    }


    public function update($no_rangka, Request $request)
    {

        $this->validate($request, [
            'no_rangka' => 'required|min:17',
            'no_mesin' => 'required|min:16',
            'lokasi_tujuan' => 'required|min:5',
        ]);

        $kirimunit = kirimunit::find($no_rangka);

        if ($request->hasFile('dokumen')) {
            $dokumen_file = $request->file('dokumen');
            $dokumen_ekstensi = $dokumen_file->extension();
            $dokumen_nama = date('ymdhis') . '.' . $dokumen_ekstensi;
            $dokumen_file->move(public_path('dokumens'), $dokumen_nama);


            $kirimunit->update([

                'no_rangka' => $request->no_rangka,
                'no_mesin' => $request->no_mesin,
                'lokasi_tujuan' => $request->lokasi_tujuan,
                'dokumen' => $dokumen_nama
            ]);
        } else {
            $kirimunit->update([

                'no_rangka' => $request->no_rangka,
                'no_mesin' => $request->no_mesin,
                'lokasi_tujuan' => $request->lokasi_tujuan,
            ]);
        }
        alert()->success('Success', 'Data Berhasil Update');
        return redirect()->route('kirimunit');
    }

    public function delete($no_rangka)
    {
        // Find the kirimunit
        $kirimunit = kirimunit::find($no_rangka);

        // Delete related records in kirimunit_status table
        $kirimunit->statuses()->detach();

        // Now, you can safely delete the kirimunit
        $kirimunit->delete();
        alert()->success('Success', 'Data Berhasil Dihapus');
        return redirect()->back();
    }

    public function upload($no_rangka, Request $request)
    {
        $kirimunit = kirimunit::find($no_rangka);
        if ($dokumen_file = $request->file('dokumen')) {
            $dokumen_ekstensi = $dokumen_file->extension();
            $dokumen_nama = date('ymdhis') . '.' . $dokumen_ekstensi;
            $dokumen_file->move(public_path('dokumens'), $dokumen_nama);

            //hapus file dokumen lama jika ada
            if ($kirimunit->dokumen) {
                $OldFilePath = public_path('dokumens') . '/' . $kirimunit->dokumen;
                if (file_exists($OldFilePath)) {
                    unlink($OldFilePath);
                }
            }

            $data = [
                'dokumen' => $dokumen_nama,
            ];

            kirimunit::find($no_rangka)->update($data);
            alert()->success('Success', 'Dokumen Berhasil Diupload');
        }

        return redirect()->back();
    }

    public function updateDokumen(Request $request, $no_rangka)
    {
        $kirimunit = kirimunit::find($no_rangka);
        if ($dokumen_file = $request->file('dokumen')) {
            $dokumen_ekstensi = $dokumen_file->extension();
            $dokumen_nama = date('ymdhis') . '.' . $dokumen_ekstensi;
            $dokumen_file->move(public_path('dokumens'), $dokumen_nama);

            //hapus file dokumen lama jika ada
            if ($kirimunit->dokumen) {
                $OldFilePath = public_path('dokumens') . '/' . $kirimunit->dokumen;
                if (file_exists($OldFilePath)) {
                    unlink($OldFilePath);
                }
            }

            $data = [
                'dokumen' => $dokumen_nama,
            ];

            kirimunit::find($no_rangka)->update($data);
            alert()->success('Success', 'Dokumen Berhasil Update');
        }

        return redirect()->back();
    }

    public function deleteStatus($statusid, $kirimunitid)
    {
        $kirimunit = kirimunit::find($kirimunitid);
        $kirimunit->statuses()->detach($statusid);
        alert()->success('success', 'Status Berhasil Dihapus');
        return redirect()->back();
    }

    public function updatestatustanggal(Request $request)
    {
        $kirimunit = kirimunit::find($request->kirimunit_no_rangka);



        $kirimunit->statuses()->updateExistingPivot($request->status_id, ['tanggal_status_kirimunit' => $request->tanggal_status_kirimunit]);

        alert()->success('Success', 'Tanggal Berhasil Update');
        return redirect()->back();
    }
}
