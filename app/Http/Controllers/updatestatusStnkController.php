<?php

namespace App\Http\Controllers;

use App\Models\dataunit;

use App\Models\prosesstnk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class updatestatusStnkController extends Controller
{
    public function save(Request $request)
    {

        // Validate the incoming request data
        $this->validate($request, [
            'prosesstnk_plat_nomor' => 'required|exists:prosesstnks,plat_nomor',
            'status_id' => ['required', Rule::in([1, 6, 8])], // Adjust the array to include valid status IDs
            'tanggal_status_prosesstnk' => 'required|date', // You might want to adjust the date format based on your needs
            'keterangan' => 'required', // Adjust the rule based on your requirements
        ]);


        $prosesstnk = prosesstnk::find($request->prosesstnk_plat_nomor);

        // Gunakan Carbon untuk mendapatkan tanggal dan waktu saat ini
        $formattedDate = Carbon::now();
        $prosesstnk->statuses()->attach($request->status_id,  ['tanggal_status_prosesstnk' => $formattedDate, 'keterangan' => $request->keterangan]);

        alert()->success('Success', 'Status Berhasil Update');
        return redirect()->route('prosesstnk');
    }



    public function show($tanggal_status_prosesstnk)
    {

        $dataunit = dataunit::all(); // Assuming you have a Dataunit model
        $prosesstnk = prosesstnk::find(decrypt($tanggal_status_prosesstnk));
        return view('prosesstnk.updatestatus', compact('prosesstnk', 'dataunit'));
    }
}
