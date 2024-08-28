<?php

namespace App\Http\Controllers;

use App\Models\dataunit;
use App\Models\kirimunit;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class updatestatusKirimUnitController extends Controller
{
    public function save(Request $request)
    {
        // Validate the incoming request data
        $this->validate($request, [
            'kirimunit_no_rangka' => 'required|exists:kirimunits,no_rangka',
            'status_id' => ['required', Rule::in([1, 6, 4, 7])], // Adjust the array to include valid status IDs
            'keterangan' => 'required', // Adjust the rule based on your requirements
        ]);

        // If the validation passes, proceed to update the status
        $kirimunit = Kirimunit::find($request->kirimunit_no_rangka);

        // Gunakan Carbon untuk mendapatkan tanggal dan waktu saat ini
        $formattedDate = Carbon::now();

        $kirimunit->statuses()->attach($request->status_id, ['tanggal_status_kirimunit' => $formattedDate, 'keterangan' => $request->keterangan]);

        alert()->success('Success', 'Status Berhasil Update');
        return redirect()->route('kirimunit');
    }

    public function show($tanggal_status_kirimunit)
    {
        $dataunit = dataunit::all(); // Assuming you have a Dataunit model
        $kirimunit = kirimunit::find(decrypt($tanggal_status_kirimunit));
        return view('kirimunit.updatestatus', compact('kirimunit', 'dataunit'));
    }
}
