<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Venta_detalleController extends Controller
{
    public function index()
    {
        return view('admin.venta_detalle.index');
    }
}
