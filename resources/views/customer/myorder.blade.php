<x-app-layout>
    <div class="container myorder">
        <div class="rounded-3 bg-white p-4 mt-5 mb-4 shadow">
            <h1 class="fs-1 mb-4">My Orders</h1>
            <form method="GET" action="{{ route('orders.betweenDates') }}">
                <div class="d-flex align-items-center gap-3">
                    <span>Date from</span>
                    <input style="max-width: 450px" class="form-control" type="datetime-local" name="start_date" id="">
                    <span class="ms-5">Date to</span>
                    <input style="max-width: 450px" class="form-control" type="datetime-local" name="end_date" id="">
                    <button type="submit" class="btn btn-outline-dark py-2 px-4">Search</button>
                </div>
            </form>
        </div>
        <div class="product-myorder rounded-3 bg-white p-4 my-4 shadow" style="min-height: 550px">
            <table class="table table-striped mb-5">
                <thead>
                  <tr>
                    <th scope="col" class="p-3">Order Date</th>
                    <th scope="col" class="p-3">Status</th>
                    <th scope="col" class="p-3">Amount</th>
                    <th scope="col" class="p-3">Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                        $orders_total_amount = 0;
                    ?>
                    @foreach ($orders as $order)
                    <?php
                        $orders_total_amount += $order->total_amount;
                    ?>
                    <tr>
                        <th class="p-3">{{$order->created_at}}</th>
                        <td class="p-3">{{$order->status}}</td>
                        <td class="p-3">EGP {{$order->total_amount}}</td>
                        <td>
                            @if($order->status == 'processing')
                            <form action="{{ route('order.remove', $order->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button type="button" class="btn btn-danger btn-outline-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{$order->id}}">Cancel</button>
                                  <!-- Modal -->
                                  <div class="modal fade" id="staticBackdrop{{$order->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="staticBackdropLabel">Cancel !</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          Are you sure?
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>
                                          <button type="submit" class="btn btn-outline-danger">Yes</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="products-list row py-3" style="min-height: 300px">
                @if($order_items)
                @foreach ($order_items as $order_item)
                <div class="prdct col-3  text-light mb-3">
                    <div class="rounded-3 bg-warning position-relative overflow-hidden">
                        <img class="top" src="{{ asset('images/'.$order_item->product->image) }}" style="height: 260px; width: 100%;">
                        <h1 class="fs-2 text-center py-2" style="position: absolute; right: 12px; top: 0; font-size: 86px !important; font-weight: bold;">{{$order_item->quantity}}</h1>
                        <h1 class="fs-2 text-center py-2">{{$order_item->product->name}}</h1>
                        <div class="price bg-warning text-center">{{$order_item->product->price}} LE</div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <div class="border-dark border-3 w-25 p-4 fs-3 float-right d-flex justify-content-between">
                Total
                <span>EGP {{$orders_total_amount}}</span>
            </div>
            <div class="clearfix"></div>
            @if($order_items)
            {{ $order_items->links('pagination::bootstrap-5', ['route' => 'order_items']) }}
            @endif
        </div>
    </div>
</x-app-layout>