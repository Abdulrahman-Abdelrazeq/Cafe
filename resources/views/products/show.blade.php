
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Show Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="container ">
    <h3  class="card-text text-primary m-5" >product : {{$product['name']}} </h3>

    <div class="row align-items-center">
<div class="card" style="width: 18rem;">
    <img  src="{{asset('product/'.$product['image'])}}">
    <div class="card-body">
      <h5 class="card-title">Name:{{$product['name']}}</h5>
      <p class="card-text">Description:{{$product['description']}}</p>
      <p class="card-text">Quantity:{{$product['quantity']}}</p>
      <p class="card-text">Price:{{$product['price']}}</p>
      <p class="card-text">
      category:<a href="{{route('categories.show',$product->category->id)}}">{{$product->category->name}}</a>
      </p>
      <a href="{{route('products.index') }}" class="btn btn-primary">Back</a>
    </div>
  </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>

