<?php

namespace App\Http\Controllers;

use App\Models\User;


class usermanagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $usermanagement = User::all();



        return view('user.index', compact('usermanagement'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'Data telah dihapus');
    }
}
