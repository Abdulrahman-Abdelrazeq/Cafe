<x-app-layout>
    <div class="container myorder">
        <div class="rounded-3 bg-white p-4 mt-5 mb-4 shadow">
            <h1 class="fs-1 mb-4">My Orders</h1>
            <div class="d-flex align-items-center gap-3">
                <span>Date from</span>
                <input style="max-width: 450px" class="form-control" type="datetime-local" name="" id="">
                <span class="ms-5">Date to</span>
                <input style="max-width: 450px" class="form-control" type="datetime-local" name="" id="">
            </div>
        </div>
        <div class="product-myorder rounded-3 bg-white p-4 my-4 shadow" style="min-height: 550px">
            <table class="table table-striped mb-5">
                <thead>
                  <tr>
                    <th scope="col">Order Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>2015/02/02 10</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                </tbody>
            </table>
            <div class="products-list row py-3">
                @foreach ($products as $product)
                <div class="prdct col-3  text-light mb-3">
                    <div class="rounded-3 bg-warning position-relative overflow-hidden">
                        <img class="top" src="{{ asset('images/'.$product->image) }}" style="height: 260px; width: 100%;">
                        <h1 class="fs-2 text-center py-2">{{$product->name}}</h1>
                        <div class="price bg-warning text-center">{{$product->price}} LE</div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="border-dark border-3 w-25 p-4 fs-3 float-right d-flex justify-content-between">
                Total
                <span>EGP 105</span>
            </div>
            <div class="clearfix"></div>
            {{ $products->links('pagination::bootstrap-5', ['route' => 'products']) }}
        </div>
    </div>
</x-app-layout>