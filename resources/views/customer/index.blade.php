<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
    <div class="py-12">
        <div class="customer-home container mx-auto d-flex gap-3">
            <div class="order p-6 bg-white rounded-3 shadow">
                <div class="orders overflow-y-auto" style="height: 520px;">
                    <table class="table table-striped text-center">
                        <thead>
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                          <tr >
                            <th class="lh-lg">{{$item->product->name}}</th>
                            <td>
                                <div class="input-group" style="height: 30px;">
                                    <form action="{{ route('cart.reduce', $item->id) }}" method="POST">
                                        @csrf
                                        <button class="input-group-text h-100 btn btn-warning text-white fw-bold fs-5 p-0" id="basic-addon1" style="width: 30px;">-</button>
                                    </form>
                                    <input type="text"  class="h-100" disabled  value="{{$item->quantity}}" style="width: 30px; padding: 0; text-align: center; border-color: #ced4da;">
                                    <form action="{{ route('cart.increase', $item->id) }}" method="POST">
                                        @csrf
                                        <button class="input-group-text h-100 btn btn-warning text-white fw-bold fs-5 p-0" id="basic-addon1" style="width: 30px;">+</button>
                                    </form>
                                </div>
                            </td>
                            <td class="lh-lg">{{$item->product->price * $item->quantity}}</td>
                            <td class="lh-lg">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-danger px-2 py-0 ">x</button>
                                </form>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
                <form action="/session" method="POST">
                    <div class="noted mb-4">
                        <h3 class="fs-4">Notes</h3>
                        <textarea class="form-control mt-1 mb-2 resize-none" name="note" id="" cols="30" rows="10"></textarea>
                    </div>
                    {{-- <div class="room d-flex align-items-center gap-3 mb-3">
                        <h3 class="fs-4">Room</h3>
                        <select class="form-control" name="" id="">
                            <option value=""></option>
                        </select>
                    </div> --}}
                    <hr>
                    <h1 class="price mt-3 fs-3 mb-5 text-end">EGP {{$totalPrice}}</h1>
                    @csrf
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-light btn-outline-dark float-right"><i class="fa fa-money me-2"></i>Confirm</button>
                </form>
                {{-- @if(session('message'))
                    toastr.success("assasas")
                @endif --}}
                @if(session('message') == 'You canceled the order')
                <script>
                    toastr.options = {
                        "progressBar" : true,
                        "closeButton" : true,
                    }
                    toastr.error("{{ session('message') }}", 'Rejected!');
                </script>
                @elseif(session('message') == 'The order was processed successfully')
                <script>
                    toastr.options = {
                        "progressBar" : true,
                        "closeButton" : true,
                    }
                    toastr.success("{{ session('message') }}", 'Success!');
                </script>
                @endif
                <div class="clear-both"></div>
            </div>
            <div class="products p-6 bg-white rounded-3 shadow w-75">
                <div class="latest-order">
                    <div class="d-flex justify-content-between">
                        <h1 class="fs-3">Latest Order</h1>
                        <form method="GET" action="{{ route('home') }}">
                            <div class="input-group mb-3">
                                <input type="text" name="query" class="form-control outline-none border-warning" style="border-radius: 20px 0 0 20px" placeholder="Search...">
                                <button class="btn btn-warning" style="border-radius: 0 20px 20px 0" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex flex-column justify-content-between">
                        <div class="products-list row py-3">
                            @foreach ($order_items as $item)
                            <div class="prdct col-3  text-light mb-3">
                                <div class="rounded-3 bg-warning position-relative overflow-hidden">
                                    <img class="top" src="{{ asset('images/'.$item->product->image) }}" style="height: 190px; width: 100%;">
                                    <h1 class="fs-2 text-center py-2">{{$item->product->name}}</h1>
                                    <div class="price bg-warning text-center">{{$item->product->price}} LE</div>
                                    <form action="{{ route('cart.add', $item->product->id) }}" method="POST">
                                        @csrf
                                        <button class="add bg-warning px-2">Add to order</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        {{ $products->links('pagination::bootstrap-5', ['route' => 'products']) }}
                    </div>
                </div>
                <hr>
                <div class="d-flex flex-column justify-content-between" style="min-height: 630px">
                    <div class="products-list row py-4">
                        @foreach ($products as $product)
                        <div class="prdct col-3  text-light mb-3">
                            <div class="rounded-3 bg-warning position-relative overflow-hidden">
                                <img class="top" src="{{ asset('images/'.$product->image) }}" style="height: 190px; width: 100%;">
                                <h1 class="fs-2 text-center py-2">{{$product->name}}</h1>
                                <div class="price bg-warning text-center">{{$product->price}} LE</div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button class="add bg-warning px-2">Add to order</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{ $products->links('pagination::bootstrap-5', ['route' => 'products']) }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>