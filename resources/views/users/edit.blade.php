<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="container">
        <h1 class="text-success m-5" style="display: flex;justify-content:center ">Update User</h1>

<div class="container m-5 my-5" style="display:flex;justify-content:center">
{{-- action="{{route('posts.update',$post -> id)}}" --}}
<form method="POST" action="{{route('users.edit',$user -> id)}}">
    @csrf
  @method('patch')


  <div class="row mb-3 ">
    <label for="exampleInputEmail1" class="form-label">Name</label>
    <input type="text" class="form-control form-control-lg" name="name"
      value="{{old('name')??$user->name }}" >
@error('Name')
<p class="text-danger"> {{$message}}</p>
@enderror
</div>
  <div class="row mb-3">
    <label for="exampleInputEmail1" class="form-label">Email</label>
    <input  class="form-control form-control-lg" value="{{old('email')??$user->email }}"
   name="email"></input>
   @error('Email')
<p class="text-danger"> {{$message}}</p>
@enderror
  </div>
<div class="row mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="Password" class="form-control form-control-lg"
       name="password">
    @error('Password')
<p class="text-danger"> {{$message}}</p>
@enderror


<button class="btn btn-success mb-3"> Submit </button>

{{-- <a type="submit" class="btn btn-success" href="{{route('posts.save')}}">Submit</a> --}}
</form>
</div>
</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



