<?php

namespace App\Http\Controllers;

use App\Models\ArchiveList;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('admin.home');
    }
    public function list(){
        return view('admin.list');
    }
}
