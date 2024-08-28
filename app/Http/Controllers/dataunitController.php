<?php

namespace App\Http\Controllers;

use App\Models\dataunit;
use App\Models\Status;
use Illuminate\Http\Request;
use Carbon\Carbon;

class dataunitController extends Controller
{
    public function index()
    {
        $dataunit = dataunit::all();
        $statuses = status::all();
        return view('dataunit.dataunit', compact('dataunit', 'statuses'));
    }

    public function tambah()
    {
        return view('dataunit.tambah');
    }

    public function simpan(Request $request)
    {
        $this->validate($request, [
            'nama_sales' => 'required|regex:/^[\pL\s\-]+$/u|min:5',
            'nama_customer' => 'required|regex:/^[\pL\s\-]+$/u|min:5',
            'nama_supervisor' => 'required|regex:/^[\pL\s\-]+$/u|min:5',
            'no_faktur' => 'required|unique:dataunits|min:15',
            'material_type' => 'required|min:13',
            'tanggal_faktur' => 'required',
            'alur_proses_penjualan' => 'required',
            'warna_plat' => 'required|regex:/^[\pL\s\-]+$/u|min:5',
            'nama_leasing' => 'required|min:3',
        ]);



        dataunit::create($request->all());

        alert()->success('Success', 'Data Berhasil Ditambah');
        return redirect()->route('dataunit');
    }

    public function edit($no_faktur)
    {
        $dataunit = dataunit::find(decrypt($no_faktur));

        return view('dataunit.edit', ['dataunit' => $dataunit]);
    }

    public function update($no_faktur, Request $request)
    {
        $this->validate($request, [
            'nama_sales' => 'required|regex:/^[\pL\s\-]+$/u|min:5',
            'nama_customer' => 'required|regex:/^[\pL\s\-]+$/u|min:5',
            'nama_supervisor' => 'required|regex:/^[\pL\s\-]+$/u|min:5',
            'no_faktur' => 'required|min:15',
            'material_type' => 'required|min:13',
            'tanggal_faktur' => 'required',
            'alur_proses_penjualan' => 'required',
            'warna_plat' => 'required|regex:/^[\pL\s\-]+$/u|min:5',
            'nama_leasing' => 'required|min:3',
        ]);

        $dataunit = dataunit::find($no_faktur);

        // Gunakan Carbon untuk mengubah format tanggal
        $request->merge(['tanggal_faktur' => Carbon::parse($request->tanggal_faktur)]);

        $dataunit->update([
            'nama_sales' => $request->nama_sales,
            'nama_customer' => $request->nama_customer,
            'nama_supervisor' => $request->nama_supervisor,
            'no_faktur' => $request->no_faktur,
            'material_type' => $request->material_type,
            'tanggal_faktur' => $request->tanggal_faktur,
            'alur_proses_penjualan' => $request->alur_proses_penjualan,
            'warna_plat' => $request->warna_plat,
            'nama_leasing' => $request->nama_leasing,
        ]);

        alert()->success('success', 'Data Berhasil Update');
        return redirect()->route('dataunit');
    }

    public function delete($no_faktur)
    {
        // Find the dataunit
        $dataunit = dataunit::find($no_faktur);

        // Delete the dataunit
        $dataunit->delete();


        alert()->success('Success', 'Data Berhasil Dihapus');
        return redirect()->route('dataunit');
    }
}
