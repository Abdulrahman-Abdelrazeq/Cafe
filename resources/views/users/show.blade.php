
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Show User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="container">
<h1 class="text-success m-5" style="display: flex;justify-content:center "> User Details</h1>
<div class="card m-5" style="width: 20rem;" >
  <div class="card-body">
    {{-- @foreach ($users as $user) --}}
 <h1 class="card-title">{{$users["name"]}}</h1>
    <h2> {{$users["email"]}}</h2>
    <p> {{$users["password"]}}</p>
    {{-- @endforeach --}}


    <a href="{{route('users.index')}}" class="btn btn-success">Go Back</a>
  </div>
</div>
</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


