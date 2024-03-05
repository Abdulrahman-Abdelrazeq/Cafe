<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                @if(session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ route('admin.orders') }}" method="get" class="d-flex mb-5">
                    <div class="form-group mr-5">
                        <label for="from_datetime">From</label>
                        <input type="datetime-local" name="from_datetime" id="from_datetime" class="form-control" value="{{ request('from_datetime') }}" placeholder="From Date and Time">
                    </div>

                    <div class="form-group mr-5">
                        <label for="to_datetime">To</label>
                        <input type="datetime-local" name="to_datetime" id="to_datetime" class="form-control" value="{{ request('to_datetime') }}" placeholder="To Date and Time">
                    </div>

                    <div class="form-group mr-5">
                        <label for="order_id">Order ID</label>
                        <input type="text" name="order_id" id="order_id" class="form-control" value="{{ request('order_id') }}">
                    </div>

                    <div class="form-group mr-5">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control pr-9 py-2">
                            <option value="">All</option>
                            <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="out_for_delivery" {{ request('status') === 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                            <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label></label>
                        <button type="submit" class="form-control py-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-700">Filter Orders</button>
                    </div>
                </form>
                @if($orders->isEmpty())
                    <p class="text-center text-gray-500">No orders found.</p>
                @else
                    <table class="table table-bordered border-dark table-striped mb-0 text-sm">
                        <tbody>
                            @foreach($orders as $order)
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer Name</th>
                                        <th>Date</th>
                                        <th style="width: 200px;">Notes</th> 
                                        <th>Order Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->created_at->format('F d, Y h:i A') }}</td>
                                    <td>{{ $order->notes }}</td>
                                    <td>{{ $order->total_amount }} LE</td>
                                    <td class="{{ getStatusColorClass($order->status) }}">{{ $order->status }}</td>
                                    <td>
                                        @if(Auth::user()->role === 'admin')
                                            <form method="POST" action="{{ route('orders.update-status', ['order' => $order]) }}" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <select name="newStatus" class="form-control">
                                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                                    <option value="out_for_delivery" {{ $order->status === 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                                <div class="mt-2 text-center">
                                                    <button type="submit" class="bg-blue-500 text-white w-100 px-3 py-1 rounded hover:bg-blue-700">Update Status</button>
                                                </div>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <p>
                                            <a class="text-primary" data-bs-toggle="collapse" href="#orderDetails{{ $order->id }}" role="button" aria-expanded="false" aria-controls="orderDetails{{ $order->id }}">
                                                View Details 
                                            </a>
                                        </p>
                                        <div class="collapse" id="orderDetails{{ $order->id }}" style="visibility:visible">
                                            <div class="row my-3">
                                                @foreach($order->items as $item)
                                                    <!-- Display Order Items Content in Cards -->
                                                    <div class="col-3">
                                                        <div class="mb-2 relative text-center">
                                                            <div class="rounded-circle overflow-hidden mx-auto" style="width: 150px; height: 150px;">
                                                                <img src="{{ asset('products/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-100 h-100 object-cover" style="object-fit: cover;">
                                                            </div>
                                                            
                                                            <!-- Circle for Price -->
                                                            <div class="absolute top-0 right-7 bg-blue-500 text-white rounded-full p-2">
                                                                {{ $item->product->price }} LE
                                                            </div>
                                                            
                                                            <h3 class="text-xl font-semibold my-2 text-muted">{{ $item->product->name }}</h3>
                                                            <p class="text-xl text-danger font-bold">{{ $item->quantity }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>                                            
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $orders->links() }} 
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

@php
    function getStatusColorClass($status) {
        switch ($status) {
            case 'processing':
                return 'text-danger text-xl';
            case 'out_for_delivery':
                return 'text-info text-xl';
            case 'delivered':
                return 'text-success text-xl';
            case 'cancelled':
                return 'text-secondary text-xl';
            default:
                return '';
        }
    }
@endphp
