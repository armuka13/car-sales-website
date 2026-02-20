<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->json('images')->nullable(); // Added for multiple images
            $table->text('description');
            $table->string('condition'); // new, used
            $table->integer('mileage')->nullable();
            $table->string('transmission'); // automatic, manual
            $table->string('fuel_type'); // petrol, diesel, electric, hybrid
            $table->string('performance')->nullable();
            $table->decimal('consumption', 8, 2)->nullable();
            $table->integer('number_of_seats')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('whatsapp');            
            $table->string('image')->nullable(); // Add this if you want the hero image
            $table->text('description')->nullable(); // Add this for the hero description
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cars');
        Schema::dropIfExists('site_settings');
    }
};