<?php

namespace App\Http\Controllers;

use App\Models\dataunit;
use App\Models\prosespenagihan;
use App\Models\prosesstnk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class updatestatusPenagihanController extends Controller
{
    public function save(Request $request)
    {

        // Validate the incoming request data
        $this->validate($request, [
            'prosespenagihan_no_tagihan' => 'exists:prosespenagihans,no_tagihan',
            'status_id' => ['required', Rule::in([1, 6, 5, 2])], // Adjust the array to include valid status IDs
            'tanggal_status_penagihan' => 'required|date', // You might want to adjust the date format based on your needs
            'keterangan' => 'required', // Adjust the rule based on your requirements
        ]);


        $prosespenagihan = prosespenagihan::find($request->prosespenagihan_no_tagihan);

        // Gunakan Carbon untuk mendapatkan tanggal dan waktu saat ini
        $formattedDate = Carbon::now();
        $prosespenagihan->statuses()->attach($request->status_id,  ['tanggal_status_penagihan' => $formattedDate, 'keterangan' => $request->keterangan]);

        alert()->success('Success', 'Status Berhasil Update');
        return redirect()->route('prosespenagihan');
    }



    public function show($tanggal_status_penagihan)
    {

        $dataunit = dataunit::all(); // Assuming you have a Dataunit model
        $prosespenagihan = prosespenagihan::find(decrypt($tanggal_status_penagihan));
        return view('prosespenagihan.updatestatus', compact('prosespenagihan', 'dataunit'));
    }
}
