<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class=" m-2 ">
    <div class="row">
        <div class="col-12  ">
<form method="post" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
@csrf
@method('PUT') <!-- Adding method field for PUT request -->

    {{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif --}}

    <div class="mb-3">
        <label for="name" class="form-label">name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{old('name')??  $product->name}}">
        @error('name')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label for="body" class="form-label">description</label>
        <input type="text" class="form-control" id="description" name="description" value="{{old('description')??$product->description }}">
        @error('description')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">price</label>
        <input type="text" class="form-control" id="price" name="price" value="{{old('price')??$product->price }}">
        @error('price')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">quantity</label>
        <input type="text" class="form-control" id="quantity" name="quantity" value="{{old('quantity')??$product->quantity }}">
        @error('quantity')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-3">
        <label for="existing-image" class="form-label">Existing Image</label><br>
        <img style="width: 100px" src="{{ asset('product/' . $product->image) }}" alt="Existing Image" ><br>
        <label for="image" class="form-label">Change Image</label>
        <input type="file" class="form-control" id="image" name="image" value="{{old('image')??$product->image}}" >
        @error('image')
            <p class="text-danger">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">Submit</button>
</form>
        </div>
    </div>
</div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
