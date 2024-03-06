
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class=" m-2 ">
    <div class="row">
        <div class="col-12  ">
            <a href="{{route("products.create")}}" class="btn btn-primary m-3">create product</a>

<table class="table table border" style="vertical-align: middle;">

<thead class="table-dark">
    <tr class="bg-warning bg-gradient text-white">
        <th>ID</th>
        <th>name</th>
        <th>description</th>
        <th>price</th>
        <th>category</th>
        <th>quantity</th>
        <th>image</th>
        <th>Insert</th>
        <th>edit</th>
        <th>delete</th>
    </tr>
</thead>
    @foreach ($products as $product)
    <tr>
        <td>
            {{$product["id"]}}
        </td>
        <td>
            {{$product["name"]}}
        </td>
        <td>
            {{$product["description"]}}
        </td>
        <td>
            {{$product["price"]}}
        </td>
        <td>
            @if ($product->category)
            <a href="{{route('categories.show',$product["category_id"])}}">{{$product->category->name}}</a>

            @else
            <P class="text-danger">no category</p>
            @endif
        </td>
        <td>
            {{$product["quantity"]}}
        </td>

        <td>
            <img style="width: 70px" src="{{asset('product/'.$product['image'])}}">
            {{$product["image"]}}
        </td>
        <td><a href="{{route('products.show',$product['id'])}}" class="btn btn-primary">show</a></td>
        <td>
            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success">Edit</a>
        </td>
        {{-- <td> --}}
            {{-- <a class="btn btn-danger" href="{{route('student.destroy',$student['id'])}}">delete</a> --}}
            {{-- <form method="post" action="{{route('student.destroy',$student['id'])}}">
                @csrf
                @method("delete")
                <button class="btn btn-danger">delete</button>
            </form>
        </td> --}}
        <td>
            <form id="deleteForm" method="post" action="{{ route('products.destroy', $product['id']) }}">
                @csrf
                @method("delete")
                <button class="btn btn-danger" onclick="return confirmDelete()">Delete</button>
            </form>
        </td>

        <script>
            function confirmDelete() {
                if (confirm("Are you sure you want to delete this product?")) {
                    document.getElementById("deleteForm").submit();
                    return true;
                } else {
                    return false;
                }
            }
        </script>

    </tr>

    @endforeach

</table>
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
