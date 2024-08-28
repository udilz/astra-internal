<?php

namespace App\Http\Controllers;

use App\Models\dataunit;
use App\Models\prosesstnk;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class prosesstnkController extends Controller
{
    public function index()
    {
        $prosesstnk = prosesstnk::all();
        $statuses = status::all();
        $dataunit = dataunit::all(); // Assuming you have a Dataunit model

        return view('prosesstnk.prosesstnk', compact('prosesstnk', 'statuses', 'dataunit'));
    }

    public function tambah()
    {


        // Retrieve the list of used no_faktur values from the prosesstnk table
        $usedNoFakturs = ProsesSTNK::pluck('dataunit_no_faktur')->toArray();

        // Retrieve all dataunit
        $dataunit = Dataunit::all();

        return view('prosesstnk.tambah', compact('dataunit', 'usedNoFakturs'));
    }



    public function simpan(Request $request)
    {
        $this->validate($request, [
            'dataunit_no_faktur' => 'required|unique:prosesstnks,dataunit_no_faktur',
            'plat_nomor' => 'required|min:4|max:9|unique:prosesstnks,plat_nomor,NULL,id,dataunit_no_faktur,' . $request->input('dataunit_no_faktur'),
        ]);

        $prosesstnk = new prosesstnk;

        $prosesstnk->dataunit_no_faktur = $request->input('dataunit_no_faktur');
        $prosesstnk->plat_nomor = $request->input('plat_nomor');

        $prosesstnk->save();

        alert()->success('Success', 'Data Berhasil Ditambah');
        return redirect()->route('prosesstnk');
    }


    public function edit($plat_nomor)
    {
        $prosesstnk = prosesstnk::find($plat_nomor);

        return view('prosesstnk.edit', compact('prosesstnk'));
    }


    public function update($plat_nomor, Request $request)
    {

        $this->validate($request, [
            'plat_nomor' => 'required|min:4|max:9',
        ]);

        $prosesstnk = prosesstnk::find($plat_nomor);

        if ($request->hasFile('dokumen')) {
            $dokumen_file = $request->file('dokumen');
            $dokumen_ekstensi = $dokumen_file->extension();
            $dokumen_nama = date('ymdhis') . '.' . $dokumen_ekstensi;
            $dokumen_file->move(public_path('dokumens'), $dokumen_nama);


            $prosesstnk->update([
                'plat_nomor' => $request->plat_nomor,
                'dokumen' => $dokumen_nama
            ]);
        } else {
            $prosesstnk->update([

                'plat_nomor' => $request->plat_nomor,
            ]);
        }
        alert()->success('Success', 'Data Berhasil Update');
        return redirect()->route('prosesstnk');
    }

    public function delete($plat_nomor)
    {
        // Find the prosesstnk
        $prosesstnk = prosesstnk::find($plat_nomor);

        // Delete related records in prosesstnk_status table
        $prosesstnk->statuses()->detach();

        // Now, you can safely delete the prosesstnk
        $prosesstnk->delete();
        alert()->success('Success', 'Data Berhasil Dihapus');
        return redirect()->back();
    }

    public function upload($plat_nomor, Request $request)
    {
        $prosesstnk = prosesstnk::find($plat_nomor);
        if ($dokumen_file = $request->file('dokumen')) {
            $dokumen_ekstensi = $dokumen_file->extension();
            $dokumen_nama = date('ymdhis') . '.' . $dokumen_ekstensi;
            $dokumen_file->move(public_path('dokumens'), $dokumen_nama);

            //hapus file dokumen lama jika ada
            if ($prosesstnk->dokumen) {
                $OldFilePath = public_path('dokumens') . '/' . $prosesstnk->dokumen;
                if (file_exists($OldFilePath)) {
                    unlink($OldFilePath);
                }
            }

            $data = [
                'dokumen' => $dokumen_nama,
            ];

            prosesstnk::find($plat_nomor)->update($data);
            alert()->success('Success', 'Dokumen Berhasil Diupload');
        }

        return redirect()->back();
    }

    public function updateDokumen(Request $request, $plat_nomor)
    {
        $prosesstnk = prosesstnk::find($plat_nomor);
        if ($dokumen_file = $request->file('dokumen')) {
            $dokumen_ekstensi = $dokumen_file->extension();
            $dokumen_nama = date('ymdhis') . '.' . $dokumen_ekstensi;
            $dokumen_file->move(public_path('dokumens'), $dokumen_nama);

            //hapus file dokumen lama jika ada
            if ($prosesstnk->dokumen) {
                $OldFilePath = public_path('dokumens') . '/' . $prosesstnk->dokumen;
                if (file_exists($OldFilePath)) {
                    unlink($OldFilePath);
                }
            }

            $data = [
                'dokumen' => $dokumen_nama,
            ];

            prosesstnk::find($plat_nomor)->update($data);
            alert()->success('Success', 'Dokumen Berhasil Update');
        }

        return redirect()->back();
    }

    public function deleteStatus($statusid, $prosesstnkid)
    {
        $prosesstnk = prosesstnk::find($prosesstnkid);
        $prosesstnk->statuses()->detach($statusid);
        alert()->success('success', 'Status Berhasil Dihapus');
        return redirect()->back();
    }

    public function updatestatustanggal(Request $request)
    {
        $prosesstnk = prosesstnk::find($request->prosesstnk_plat_nomor);
        $prosesstnk->statuses()->updateExistingPivot($request->status_id, ['tanggal_status_prosesstnk' => $request->tanggal_status_prosesstnk]);

        alert()->success('Success', 'Tanggal Berhasil Update');
        return redirect()->back();
    }
}
