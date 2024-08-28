<?php

namespace App\Http\Controllers;


use App\Models\dataunit;
use App\Models\kirimunit;
use App\Models\prosespenagihan;
use App\Models\prosesstnk;
use App\Models\Status;


class dashboardController extends Controller
{
    public function index()
    {


        $statuses = Status::all();
        $totalDataunit = dataunit::count();
        $totalKirimunit = kirimunit::count();
        $totalProsesstnk = prosesstnk::count();
        $totalProsespenagihan = prosespenagihan::count();
        $kirimunit = kirimunit::paginate(5);
        $prosesstnk = prosesstnk::all();
        $prosespenagihan = prosespenagihan::paginate(5);
        $statuses = status::all();



        return view('dashboard.dashboard', compact('statuses', 'totalDataunit', 'totalKirimunit', 'totalProsesstnk', 'totalProsespenagihan', 'kirimunit', 'prosesstnk', 'prosespenagihan', 'statuses'));
    }
}
