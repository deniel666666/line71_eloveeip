<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{
    public function index (Request $request) {
//    	var_dump(Session::all());
        return view("admin.index")->with('pageTitle','後台');
    }
}
