<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $cars = Car::orderBy('created_at', 'desc')->get();
        $settings = SiteSetting::first();
        return view('home', compact('cars', 'settings'));
    }
    
    public function favorites()
    {
        $settings = SiteSetting::first();
        return view('favorites', compact('settings'));
    }
    
    public function getFavorites(Request $request)
    {
        $ids = $request->input('ids', []);
        $cars = Car::whereIn('id', $ids)->get();
        return response()->json($cars);
    }
}