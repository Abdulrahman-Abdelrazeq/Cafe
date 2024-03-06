<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class=" m-2 ">
    <div class="row">
        <div class="col-12  ">
<h1>Create new category</h1>
<form method="post" action="{{route("categories.store")}}"
 enctype="multipart/form-data">
@csrf


    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">category name</label>
        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name" value="{{old('name')}}">
        @error('name')
            <p class="text-danger">{{$message}}</p>
        @enderror
    </div>
    {{-- <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">description</label>
      <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="description" value="{{old('description')}}">
      @error('description')
      <p class="text-danger">{{$message}}</p>
     @enderror
    </div> --}}
    {{-- <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">image</label>
      <input type="file" class="form-control" id="exampleInputPassword1" name="image" value="{{old('image')}}">
      @error('image')
      <p class="text-danger">{{$message}}</p>
  @enderror
    </div> --}}
    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">submit</button>
  </form>
        </div>
    </div>
</div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
