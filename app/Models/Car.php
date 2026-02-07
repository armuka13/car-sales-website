<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand', 'model', 'year', 'price', 'image', 'images',
        'description', 'condition', 'mileage',
        'transmission', 'fuel_type', 'category', 'performance', 'consumption', 
        'number_of_seats', 'color'
    ];
    protected $casts = [
        'images' => 'array', // Automatically cast JSON to array
    ];
}

// app/Models/SiteSetting.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['name', 'email', 'phone'];
}