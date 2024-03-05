<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checks and Payments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                <form action="{{ route('admin.checks') }}" method="get" class="d-flex mb-5">
                    <div class="form-group mr-5">
                        <label for="from_date">From</label>
                        <input type="datetime-local" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                    </div>

                    <div class="form-group mr-5">
                        <label for="to_date">To</label>
                        <input type="datetime-local" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                    </div>

                    <div class="form-group mr-5">
                        <label for="user_id">User</label>
                        <select name="user_id" id="user_id" class="form-control pr-9 py-2">
                            <option value="">All Users</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == request('user_id') ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label></label>
                        <button type="submit" class="form-control py-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-700">Filter Checks</button>
                    </div>
                </form>


                <!-- Display users and their details here -->

                @if($usersWithFilteredOrders->isEmpty())
                    <p class="text-center text-gray-500">No Data found.</p>
                @else
                    <table class="table table-bordered   mb-0">
                        <tbody>
                            @foreach($usersWithFilteredOrders as $user)
                                <thead>
                                    <tr class="table-dark text-center">
                                        <th>Customer Name</th>
                                        <th>Total Orders Amount</th>
                                    </tr>
                                </thead>
                                <tr class="text-center">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->orders_sum_total_amount }} LE</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p>
                                            <a class="text-primary" data-bs-toggle="collapse" href="#orders{{ $user->id }}" role="button" aria-expanded="false" aria-controls="orders{{ $user->id }}">
                                                View Orders 
                                            </a>
                                        </p>
                                        <div class="collapse" id="orders{{ $user->id }}" style="visibility:visible">
                                            <div class="row my-3 px-5 py-2">
                                                <table class="table table-bordered table-striped border-dark mb-0 text-sm">
                                                    <tbody>
                                                        @foreach($user->orders as $order)
                                                            <thead>
                                                                <tr>
                                                                    <th>Order ID</th>
                                                                    <th>Customer Name</th>
                                                                    <th>Date</th>
                                                                    <th style="width: 200px;">Notes</th> 
                                                                    <th>Order Total</th>
                                                                    <th>Status</th>
                                                                    <th>Transaction ID</th>
                                                                    <th>Payment Method</th>
                                                                </tr>
                                                            </thead>
                                                            <tr>
                                                                <td>{{ $order->id }}</td>
                                                                <td>{{ $order->user->name }}</td>
                                                                <td>{{ $order->created_at->format('F d, Y h:i A') }}</td>
                                                                <td>{{ $order->notes }}</td>
                                                                <td>{{ $order->total_amount }} LE</td>
                                                                <td class="{{ getStatusColorClass($order->status) }}">{{ $order->status }}</td>
                                                                <td>{{ $order->payment->transaction_id }}</td>
                                                                <td>{{ $order->payment->method }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="8">
                                                                    <p>
                                                                        <a class="text-primary" data-bs-toggle="collapse" href="#orderDetails{{ $order->id }}" role="button" aria-expanded="false" aria-controls="orderDetails{{ $order->id }}">
                                                                            View Order Items
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
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $usersWithFilteredOrders->links() }} 
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
                return 'text-danger';
            case 'out_for_delivery':
                return 'text-info';
            case 'delivered':
                return 'text-success';
            case 'cancelled':
                return 'text-secondary';
            default:
                return '';
        }
    }
@endphp
