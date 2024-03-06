
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Show Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="container text-center">
    <div class="row justify-content-center">
        <div class="col-6">
    <h3  style="width:fit-content; padding:8px" class="card-text m-5 bg-primary rounded text-white" >products in <span class="text-warning">{{$category['name']}}</span> category</h3>
        </div>
    </div>
  <div class="row justify-content-start">

@foreach($category->products as $products)
<div class="col-4 mt-3">
<div class="card" style="width: 18rem;">
    <img style="height: 200px" src="{{asset('product/'.$products['image'])}}">
    <div class="card-body">

      <h5 class="card-title">{{$products->name}}</h5>



    </div>
</div>
</div>
@endforeach

    </div>

</div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
