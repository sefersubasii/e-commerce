<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;

use App\Http\Requests;

class BrandPageController extends Controller
{
    public function index()
    {
        $brands = Brand::with('productsCount')->orderBy('name')->get();

        return view('frontEnd.blades.brands.index', compact('brands'));
    }
}
