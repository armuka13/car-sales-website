<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::query();

        // Filtering
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }
        if ($request->filled('model')) {
            $query->where('model', $request->model);
        }
        if ($request->filled('year')) {
            $query->where('year', '>=', $request->year);
        }
        if ($request->filled('mileage')) {
            $query->where('mileage', '<=', $request->mileage);
        }
        if ($request->filled('price')) {
            $query->where('price', '<=', $request->price);
        }
        if ($request->filled('fuel') && $request->fuel === 'electric') {
            $query->where('fuel_type', 'electric');
        }
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $cars = $query->orderBy('created_at', 'desc')->paginate(10);
        $allCars = Car::all(); // For filters and Top Deals
        $settings = SiteSetting::first();

        return view('home', compact('cars', 'allCars', 'settings'));
    }

    public function favorites()
    {
        $settings = SiteSetting::first();
        return view('favorites', compact('settings'));
    }

    public function getFavorites(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        $cars = Car::whereIn('id', $validated['ids'])->get();
        return response()->json($cars);
    }

    public function getCount(Request $request)
    {
        $query = Car::query();

        if ($request->filled('category'))
            $query->where('category', $request->category);
        if ($request->filled('brand'))
            $query->where('brand', $request->brand);
        if ($request->filled('model'))
            $query->where('model', $request->model);
        if ($request->filled('year'))
            $query->where('year', '>=', $request->year);
        if ($request->filled('mileage'))
            $query->where('mileage', '<=', $request->mileage);
        if ($request->filled('price'))
            $query->where('price', '<=', $request->price);
        if ($request->filled('fuel') && $request->fuel === 'electric')
            $query->where('fuel_type', 'electric');
        if ($request->filled('condition'))
            $query->where('condition', $request->condition);

        return response()->json(['count' => $query->count()]);
    }

    public function show(Car $car)
    {
        $settings = SiteSetting::first();
        return view('car-details', compact('car', 'settings'));
    }

    public function searchAjax(Request $request)
    {
        $query = Car::query();

        // Filtering
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }
        if ($request->filled('model')) {
            $query->where('model', $request->model);
        }
        if ($request->filled('year')) {
            $query->where('year', '>=', $request->year);
        }
        if ($request->filled('mileage')) {
            $query->where('mileage', '<=', $request->mileage);
        }
        if ($request->filled('price')) {
            $query->where('price', '<=', $request->price);
        }
        if ($request->filled('fuel') && $request->fuel === 'electric') {
            $query->where('fuel_type', 'electric');
        }
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        $cars = $query->orderBy('created_at', 'desc')->paginate(10);

        // Generate HTML for cars
        $carsHtml = view('partials.cars-grid', ['cars' => $cars])->render();

        // Generate pagination HTML
        $paginationHtml = $cars->appends($request->query())->links('pagination::bootstrap-5');

        return response()->json([
            'html' => $carsHtml,
            'pagination' => (string)$paginationHtml,
            'total' => $cars->total(),
            'count' => $cars->count()
        ]);
    }
}