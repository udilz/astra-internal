<?php

namespace App\Http\Controllers;

use App\Models\dataunit;
use App\Models\prosespenagihan;
use App\Models\Status;
use Illuminate\Http\Request;

use Carbon\Carbon;


class prosespenagihanController extends Controller
{
    public function index()
    {
        $prosespenagihan = prosespenagihan::all();
        $statuses = status::all();
        $dataunit = dataunit::all(); // Assuming you have a Dataunit model

        return view('prosespenagihan.prosespenagihan', compact('prosespenagihan', 'statuses', 'dataunit'));
    }

    public function tambah()
    {


        // Retrieve the list of used no_faktur values from the prosespenagihan table
        $usedNoFakturs = Prosespenagihan::pluck('dataunit_no_faktur')->toArray();



        // Retrieve all dataunit
        $dataunit = Dataunit::all();

        return view('prosespenagihan.tambah', compact('dataunit', 'usedNoFakturs'));
    }

    public function simpan(Request $request)
    {
        $this->validate($request, [
            'dataunit_no_faktur' => 'required|unique:prosespenagihans,dataunit_no_faktur',
            'no_tagihan' => 'required|unique:prosespenagihans|min:4',
            'jatuh_tempo' => 'required|date',
            'payment_type' => 'required|regex:/^[\pL\s\-]+$/u|min:4',
        ]);

        $prosespenagihan = new prosespenagihan;

        $prosespenagihan->dataunit_no_faktur = $request->input('dataunit_no_faktur');
        $prosespenagihan->no_tagihan = $request->input('no_tagihan');
        $prosespenagihan->jatuh_tempo = $request->input('jatuh_tempo');
        $prosespenagihan->payment_type = $request->input('payment_type');


        $prosespenagihan->save();

        alert()->success('Success', 'Data Berhasil Ditambah');
        return redirect()->route('prosespenagihan');
    }



    public function edit($no_tagihan)
    {
        $prosespenagihan = prosespenagihan::find($no_tagihan);

        return view('prosespenagihan.edit', compact('prosespenagihan'));
    }


    public function update($no_tagihan, Request $request)
    {

        $this->validate($request, [
            'no_tagihan' => 'required|min:4 ',
            'jatuh_tempo' => 'required|date',
            'payment_type' => 'required|regex:/^[\pL\s\-]+$/u|min:4',
        ]);




        $prosespenagihan = prosespenagihan::find($no_tagihan);

        // Gunakan Carbon untuk mengubah format tanggal
        $request->merge(['tanggal_faktur' => Carbon::parse($request->tanggal_faktur)]);

        if ($request->hasFile('dokumen')) {
            $dokumen_file = $request->file('dokumen');
            $dokumen_ekstensi = $dokumen_file->extension();
            $dokumen_nama = date('ymdhis') . '.' . $dokumen_ekstensi;
            $dokumen_file->move(public_path('dokumens'), $dokumen_nama);


            $prosespenagihan->update([
                'no_tagihan' => $request->no_tagihan,
                'jatuh_tempo' => $request->jatuh_tempo,
                'payment_type' => $request->payment_type,
                'dokumen' => $dokumen_nama
            ]);
        } else {
            $prosespenagihan->update([
                'no_tagihan' => $request->no_tagihan,
                'jatuh_tempo' => $request->jatuh_tempo,
                'payment_type' => $request->payment_type,
            ]);
        }
        alert()->success('Success', 'Data Berhasil Update');
        return redirect()->route('prosespenagihan');
    }

    public function delete($no_tagihan)
    {
        // Find the prosespenagihan
        $prosespenagihan = prosespenagihan::find($no_tagihan);

        // Delete related records in prosespenagihan_status table
        $prosespenagihan->statuses()->detach();

        // Now, you can safely delete the prosespenagihan
        $prosespenagihan->delete();
        alert()->success('Success', 'Data Berhasil Dihapus');
        return redirect()->back();
    }

    public function upload($no_tagihan, Request $request)
    {
        $prosespenagihan = prosespenagihan::find($no_tagihan);
        if ($dokumen_file = $request->file('dokumen')) {
            $dokumen_ekstensi = $dokumen_file->extension();
            $dokumen_nama = date('ymdhis') . '.' . $dokumen_ekstensi;
            $dokumen_file->move(public_path('dokumens'), $dokumen_nama);

            //hapus file dokumen lama jika ada
            if ($prosespenagihan->dokumen) {
                $OldFilePath = public_path('dokumens') . '/' . $prosespenagihan->dokumen;
                if (file_exists($OldFilePath)) {
                    unlink($OldFilePath);
                }
            }

            $data = [
                'dokumen' => $dokumen_nama,
            ];

            prosespenagihan::find($no_tagihan)->update($data);
            alert()->success('Success', 'Dokumen Berhasil Diupload');
        }

        return redirect()->back();
    }

    public function updateDokumen(Request $request, $no_tagihan)
    {
        $prosespenagihan = prosespenagihan::find($no_tagihan);
        if ($dokumen_file = $request->file('dokumen')) {
            $dokumen_ekstensi = $dokumen_file->extension();
            $dokumen_nama = date('ymdhis') . '.' . $dokumen_ekstensi;
            $dokumen_file->move(public_path('dokumens'), $dokumen_nama);

            //hapus file dokumen lama jika ada
            if ($prosespenagihan->dokumen) {
                $OldFilePath = public_path('dokumens') . '/' . $prosespenagihan->dokumen;
                if (file_exists($OldFilePath)) {
                    unlink($OldFilePath);
                }
            }

            $data = [
                'dokumen' => $dokumen_nama,
            ];

            prosespenagihan::find($no_tagihan)->update($data);
            alert()->success('Success', 'Dokumen Berhasil Update');
        }

        return redirect()->back();
    }

    public function deleteStatus($statusid, $prosespenagihanid)
    {
        $prosespenagihan = prosespenagihan::find($prosespenagihanid);
        $prosespenagihan->statuses()->detach($statusid);
        alert()->success('success', 'Status Berhasil Dihapus');
        return redirect()->back();
    }

    public function updatestatustanggal(Request $request)
    {
        $prosespenagihan = prosespenagihan::find($request->prosespenagihan_no_tagihan);
        $prosespenagihan->statuses()->updateExistingPivot($request->status_id, ['tanggal_status_penagihan' => $request->tanggal_status_penagihan]);

        alert()->success('Success', 'Tanggal Berhasil Update');
        return redirect()->back();
    }
}
