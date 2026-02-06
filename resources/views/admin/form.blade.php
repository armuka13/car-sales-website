<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Brand *</label>
        <input type="text" name="brand" class="form-control bg-dark text-white @error('brand') is-invalid @enderror" 
               value="{{ old('brand', $car->brand ?? '') }}" required>
        @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    
    <div class="col-md-6 mb-3">
        <label class="form-label">Model *</label>
        <input type="text" name="model" class="form-control bg-dark text-white @error('model') is-invalid @enderror" 
               value="{{ old('model', $car->model ?? '') }}" required>
        @error('model')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    
    <div class="col-md-4 mb-3">
        <label class="form-label">Year *</label>
        <input type="number" name="year" class="form-control bg-dark text-white @error('year') is-invalid @enderror" 
               value="{{ old('year', $car->year ?? date('Y')) }}" required>
        @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    
    <div class="col-md-4 mb-3">
        <label class="form-label">Price ($) *</label>
        <input type="number" name="price" step="0.01" class="form-control bg-dark text-white @error('price') is-invalid @enderror" 
               value="{{ old('price', $car->price ?? '') }}" required>
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    
    <div class="col-md-4 mb-3">
        <label class="form-label">Mileage</label>
        <input type="number" name="mileage" class="form-control bg-dark text-white @error('mileage') is-invalid @enderror" 
               value="{{ old('mileage', $car->mileage ?? '') }}">
        @error('mileage')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    
    <div class="col-md-4 mb-3">
        <label class="form-label">Condition *</label>
        <select name="condition" class="form-select bg-dark text-white @error('condition') is-invalid @enderror" required>
            <option value="new" {{ old('condition', $car->condition ?? '') == 'new' ? 'selected' : '' }}>New</option>
            <option value="used" {{ old('condition', $car->condition ?? '') == 'used' ? 'selected' : '' }}>Used</option>
        </select>
        @error('condition')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    
    <div class="col-md-4 mb-3">
        <label class="form-label">Transmission *</label>
        <select name="transmission" class="form-select bg-dark text-white @error('transmission') is-invalid @enderror" required>
            <option value="automatic" {{ old('transmission', $car->transmission ?? '') == 'automatic' ? 'selected' : '' }}>Automatic</option>
            <option value="manual" {{ old('transmission', $car->transmission ?? '') == 'manual' ? 'selected' : '' }}>Manual</option>
        </select>
        @error('transmission')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    
    <div class="col-md-4 mb-3">
        <label class="form-label">Fuel Type *</label>
        <select name="fuel_type" class="form-select bg-dark text-white @error('fuel_type') is-invalid @enderror" required>
            <option value="petrol" {{ old('fuel_type', $car->fuel_type ?? '') == 'petrol' ? 'selected' : '' }}>Petrol</option>
            <option value="diesel" {{ old('fuel_type', $car->fuel_type ?? '') == 'diesel' ? 'selected' : '' }}>Diesel</option>
            <option value="electric" {{ old('fuel_type', $car->fuel_type ?? '') == 'electric' ? 'selected' : '' }}>Electric</option>
            <option value="hybrid" {{ old('fuel_type', $car->fuel_type ?? '') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
        </select>
        @error('fuel_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Category *</label>
        <select name="category" class="form-select bg-dark text-white @error('category') is-invalid @enderror" required>
            <option value="">Select Category</option>
            <option value="SUV" {{ old('category', $car->category ?? '') == 'SUV' ? 'selected' : '' }}>SUV</option>
            <option value="Kombi" {{ old('category', $car->category ?? '') == 'Kombi' ? 'selected' : '' }}>Kombi</option>
            <option value="Limousine" {{ old('category', $car->category ?? '') == 'Limousine' ? 'selected' : '' }}>Limousine</option>
            <option value="Roadster" {{ old('category', $car->category ?? '') == 'Roadster' ? 'selected' : '' }}>Roadster</option>
            <option value="Sportwagen/Coupe" {{ old('category', $car->category ?? '') == 'Sportwagen/Coupe' ? 'selected' : '' }}>Sportwagen/Coupe</option>
            <option value="Van/Minibus" {{ old('category', $car->category ?? '') == 'Van/Minibus' ? 'selected' : '' }}>Van/Minibus</option>
            <option value="Kleinwagen" {{ old('category', $car->category ?? '') == 'Kleinwagen' ? 'selected' : '' }}>Kleinwagen</option>
        </select>
        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Performance (kW)</label>
        <input type="number" name="performance" step="0.01" class="form-control bg-dark text-white @error('performance') is-invalid @enderror" 
               value="{{ old('performance', $car->performance ?? '') }}">
        @error('performance')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Consumption (liters / 100km)</label>
        <input type="number" name="consumption" step="0.01" class="form-control bg-dark text-white @error('consumption') is-invalid @enderror" 
               value="{{ old('consumption', $car->consumption ?? '') }}">
        @error('consumption')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Number of seats</label>
        <input type="number" name="number_of_seats" class="form-control bg-dark text-white @error('number_of_seats') is-invalid @enderror" 
               value="{{ old('number_of_seats', $car->number_of_seats ?? '') }}">
        @error('number_of_seats')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Color</label>
        <input type="text" name="color" class="form-control bg-dark text-white @error('color') is-invalid @enderror" 
               value="{{ old('color', $car->color ?? '') }}">
        @error('color')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    
    <div class="col-md-12 mb-3">
        <label class="form-label">Main Image</label>
        <input type="file" name="image" class="form-control bg-dark text-white @error('image') is-invalid @enderror" accept="image/*">
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @if(isset($car) && $car->image)
            <img src="{{ asset('storage/' . $car->image) }}" class="mt-2 img-thumbnail" width="150">
        @endif
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Additional Images (Max 10)</label>
        <input type="file" name="images[]" class="form-control bg-dark text-white @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" accept="image/*" multiple>
        <small class="text-muted">You can select multiple images</small>
        @error('images')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
        
        @if(isset($car) && $car->images)
            <div class="mt-3">
                <label class="form-label">Current Additional Images:</label>
                <div class="row">
                    @foreach($car->images as $index => $img)
                        <div class="col-md-2 mb-2 position-relative">
                            <img src="{{ asset('storage/' . $img) }}" class="img-thumbnail" width="100%">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" 
                                    onclick="deleteImage({{ $car->id }}, {{ $index }})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    
    <div class="col-md-12 mb-3">
        <label class="form-label">Description *</label>
        <textarea name="description" rows="4" class="form-control bg-dark text-white @error('description') is-invalid @enderror" required>{{ old('description', $car->description ?? '') }}</textarea>
        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<script>
function deleteImage(carId, imageIndex) {
    if (confirm('Are you sure you want to delete this image?')) {
        // Send AJAX request to delete image
        fetch(`/admin/cars/${carId}/delete-image/${imageIndex}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>