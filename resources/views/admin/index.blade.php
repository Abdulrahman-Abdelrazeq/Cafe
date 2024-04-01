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
                    {{ __("You're logged in as admin!") }}
                </div>
            </div>
        </div>
    </div>

 <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
<a  class="btn btn-primary m-3" href="{{route('admin.create')}}"> Add User </a>

<table class="table text-dark text table-bordered border-dark table-striped mb-0 text-sm">
    <tr>
        <th>
        Name
        </th>
        <th> Action
        <th></th>
        <th></th>
        <th></th>
        </th>
    </tr>

    <tr>
@foreach ($users as $user)
<tr>
    <td>
      {{$user["Users"]}}

    </td>
    <th>
    <th>          Show
        <a href="{{route('admin.show',$user['id'])}} "
        class="btn btn-success"> show </a>
    </th>
    <th>   Edit
         {{-- <form  action="{{route('posts.update',$post['id'])}}">
            @csrf
            @method("put")
     <button  class="btn btn-warning"> Edit</button>
     </form> --}}
       <a href="{{route('admin.update',$user['id'])}}" class="btn btn-warning">Edit</a>
    </th>
    <th>   Delete
        <form method="POST" action="{{route('admin.delete',$user['id'])}}" id="delete">
            @csrf
            @method("delete")
            <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">
                Delete </button>
</th>
    </th>
        </form>
 {{-- <a href="{{route('posts.delete',$post['id'])}}" class="btn btn-danger">Delete</a> --}}


</tr>
@endforeach
    </tr>
</table>


                </div>
            </div>
        </div>
</x-app-layout>





