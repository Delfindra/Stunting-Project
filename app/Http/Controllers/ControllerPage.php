<?php

namespace App\Http\Controllers;

use App\Models\dataAnak;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ControllerPage extends Controller
{
    function index()
    {
        return view("page/index");
    }

    function login()
    {
        return view("page/login");
    }

    // function register()
    // {
    //     return view("page/login");
    // }

    function sebaran()
    {
        return view("page/sebaranStatusGizi");
    }

    function cekStatus()
    {
        return view("page/cekStatus");
    }

    function lihatData()
    {
        $data = dataAnak::all()->map(function ($item) {
            $item->umur = Carbon::parse($item->tanggal_lahir)->diffInMonths(Carbon::now());
            return $item;
        });
        // $data = dataAnak::all();
        return view('page/lihatData')->with('data', $data);
    }
}
