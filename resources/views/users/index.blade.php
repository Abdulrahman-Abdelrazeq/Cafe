<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="container">


<a  class="btn btn-primary m-3" href="{{route('users.create')}}"> Add User </a>

<table class="table text-dark text table-bordered border-dark table-striped mb-0 text-sm">
<tr>
   <th>
   Name
   </th>
   <th>
   Email
   </th>
   <th>
    Password
   </th>

   <th> Details </th>
   <th> Edit </th>
   <th> Delete </th>

</tr>

<tr>
@foreach ($users as $user)

<td>
 {{$user["name"]}}

</td>
<td>
{{$user["email"]}}
</td>
<td>
{{$user["password"]}}
</td>

<th>
   <a href="{{route('users.show',$user['id'])}} "
   class="btn btn-success"> show </a>
</th>
<th>
   {{-- <form  action="{{route('admin.update',$post['id'])}}">
       @csrf
       @method("put")
<button  class="btn btn-warning"> Edit</button>
</form> --}}
<a href="{{route('users.edit',$user['id'])}}" class="btn btn-warning">Edit</a>
</th>
<th>
   <form method="POST" action="{{route('users.destroy',$user['id'])}}" id="delete">
       @csrf
       @method("delete")
       <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
           Delete </button>
</th>
   </form>

</tr>
@endforeach
</tr>
</table>
   </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


