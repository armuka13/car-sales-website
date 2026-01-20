<?php
namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $cars = Car::orderBy('created_at', 'desc')->get();
        $settings = SiteSetting::first();
        return view('admin.dashboard', compact('cars', 'settings'));
    }

    public function create()
    {
        $settings = SiteSetting::first();
        // $categories = DB::table('cars')->select('category')->distinct()->get();  
        return view('admin.create', compact('settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array|max:10',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'condition' => 'required|in:new,used',
            'mileage' => 'nullable|integer|min:0',
            'transmission' => 'required|in:automatic,manual',
            'fuel_type' => 'required|in:petrol,diesel,electric,hybrid',
            'performance' => 'nullable|numeric|min:0',
            'consumption' => 'nullable|numeric|min:0',
            'number_of_seats' => 'nullable|integer|min:0',
            'color' => 'nullable|string|max:50',
        ]);

        // Handle main image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('cars', 'public');
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('cars', 'public');
            }
            $validated['images'] = $imagePaths;
        }

        Car::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Car added successfully!');
    }

    public function edit(Car $car)
    {
        $settings = SiteSetting::first();
        return view('admin.edit', compact('car', 'settings'));
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'images' => 'nullable|array|max:10',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'condition' => 'required|in:new,used',
            'mileage' => 'nullable|integer|min:0',
            'transmission' => 'required|in:automatic,manual',
            'fuel_type' => 'required|in:petrol,diesel,electric,hybrid',
            'performance' => 'nullable|numeric|min:0',
            'consumption' => 'nullable|numeric|min:0',
            'number_of_seats' => 'nullable|integer|min:0',
            'color' => 'nullable|string|max:50',
        ]);

        // Handle main image
        if ($request->hasFile('image')) {
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }
            $validated['image'] = $request->file('image')->store('cars', 'public');
        } else {
            unset($validated['image']);
        }

        // Handle multiple images
        if ($request->hasFile('images')) {
            $imagePaths = $car->images ?? []; // Keep existing images
            
            foreach ($request->file('images') as $image) {
                if (count($imagePaths) < 10) { // Limit to 10 images
                    $imagePaths[] = $image->store('cars', 'public');
                }
            }
            $validated['images'] = $imagePaths;
        } else {
            unset($validated['images']);
        }

        $car->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Car updated successfully!');
    }

    public function deleteImage(Car $car, $index)
    {
        $images = $car->images ?? [];
        
        if (isset($images[$index])) {
            // Delete the file from storage
            Storage::disk('public')->delete($images[$index]);
            
            // Remove from array
            array_splice($images, $index, 1);
            
            // Update car
            $car->update(['images' => array_values($images)]); // Re-index array
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    public function destroy(Car $car)
    {
        // Delete main image
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }
        
        // Delete all additional images
        if ($car->images) {
            foreach ($car->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $car->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Car deleted successfully!');
    }

    public function settings()
    {
        $settings = SiteSetting::first();
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
        ]);

        $settings = SiteSetting::first();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($settings->image) {
                Storage::disk('public')->delete($settings->image);
            }
            
            // Store new image
            $validated['image'] = $request->file('image')->store('settings', 'public');
        } else {
            // Remove image from validated array if no new image uploaded
            unset($validated['image']);
        }

        $settings->update($validated);

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully!');
    }
}