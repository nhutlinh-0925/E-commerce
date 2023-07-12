<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;

use App\Models\ThuongHieu;

class KhachhangController extends Controller
{
    public function index(){
        $brands = ThuongHieu::all()->sortByDesc("id");
        return view('back-end.user.index2',[
            'brands' => $brands]);
}

public function index2(){

    return view('back-end.user.index');
}

// public function getUsers(UsersDataTable $dataTable){
//     return $dataTable->render('back-end.user.index');
// }
}
