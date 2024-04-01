<?php

namespace App\Http\Controllers;



use App\Http\Requests\AdminUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function index()
    {
        $users = user::all();
        return view('admin.index', ['users' => $users]);
    }
    public function listOrders(Request $request)
    {
        // Start with a base query including relationships
        $query = Order::with(['user', 'items.product']);

        // Check and apply filters
        if ($request->filled('from_datetime')) {
            $query->where('created_at', '>=', $request->input('from_datetime'));
        }

        if ($request->filled('to_datetime')) {
            $query->where('created_at', '<=', $request->input('to_datetime'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('order_id')) {
            $query->where('id', $request->input('order_id'));
        }

        // Order the results to show newest orders first
        $query->orderBy('created_at', 'desc');

        // Get the filtered orders
        $orders = $query->paginate(3);

        return view('admin.orders', compact('orders'));
    }


    public function updateStatus(Request $request, Order $order)
    {
        // Validate the new status to prevent unauthorized changes
        $allowedStatuses = ['processing', 'out_for_delivery', 'delivered', 'cancelled'];
        $request->validate([
            'newStatus' => 'required|in:' . implode(',', $allowedStatuses),
        ]);

        $newStatus = $request->input('newStatus');
        $order->update(['status' => $newStatus]);

        return redirect()->route('admin.orders')->with('status', 'Order status updated successfully.');
    }

    public function checks(Request $request)
    {
        // Get all users for the dropdown
        $users = User::where('role', 'user')->get();
    
        // Get the selected user ID and date range from the request
        $selectedUserId = $request->input('user_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
    
        // Start with a base query including relationships
        $query = User::where('role', 'user')->withSum('orders', 'total_amount');
    
        // Apply user filter if selected
        if ($selectedUserId) {
            $query->where('id', $selectedUserId);
        }
    
        // Check and apply date range filter
        if ($fromDate && $toDate) {
            $query->whereHas('orders', function ($orderQuery) use ($fromDate, $toDate) {
                $orderQuery->whereBetween('created_at', [$fromDate, $toDate]);
            });
        } else {
            // If only one of fromDate or toDate is set, apply individual filters
            if ($fromDate) {
                $query->whereHas('orders', function ($orderQuery) use ($fromDate) {
                    $orderQuery->where('created_at', '>=', $fromDate);
                });
            }

            if ($toDate) {
                $query->whereHas('orders', function ($orderQuery) use ($toDate) {
                    $orderQuery->where('created_at', '<=', $toDate);
                });
            }
        }
    
        // Get the filtered users with their filtered orders
        $usersWithFilteredOrders = $query->with(['orders' => function ($orderQuery) use ($fromDate, $toDate) {
            // Apply date range filter for orders
            if ($fromDate) {
                $orderQuery->where('created_at', '>=', $fromDate);
            }
    
            if ($toDate) {
                $orderQuery->where('created_at', '<=', $toDate);
            }
    
            // Include items and product information for each order
            $orderQuery->with(['items.product']);
        }])->paginate(3);
    
        // Calculate total amount for each user based on filtered orders
        foreach ($usersWithFilteredOrders as $user) {
            $user->orders_sum_total_amount = $user->orders->sum('total_amount');
        }
    
        return view('admin.checks', compact('usersWithFilteredOrders', 'users'));
    }

    public function createOrder()
    {
        $products = Product::all();
        $users = User::where('role', 'user')->get();

        return view('admin.createOrder', compact('products','users'));
    }
    
    public function submitOrder(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'quantities' => 'required|array',
            'products.*' => 'exists:products,id', // Ensure that each product exists in the database
            'quantities.*' => 'integer|min:1', // Ensure that quantities are positive integers
        ]);

        // Calculate total amount
        $totalAmount = 0;
        foreach ($request->input('products') as $productId => $productName) {
            $quantity = $request->input('quantities.' . $productId, 1);
            $product = Product::find($productId); // Assuming you have a Product model

            $totalAmount += $product->price * $quantity;
        }

        // Create a new order
        $order = Order::create([
            'user_id' => $request->input('user_id'),
            'total_amount' => $totalAmount,
            // Add other order details as needed
        ]);

        // Attach order items to the order
        foreach ($request->input('products') as $productId => $productName) {
            $quantity = $request->input('quantities.' . $productId, 1);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                // Add other order item details as needed
            ]);
        }

        return redirect()->route('admin.orders')->with('status', 'Order created successfully.');
    }

    public function getusers()
    {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }
    public function showuser($id)
    {
        $users = user::find($id); //if id wrong return 404page
        return view('users.show', ['users'=> $users]);
    }

    public function createuser()
    {

         return view('users.create');
    }

    public function storeuser(Request $request)
    {
        User::create($request->all());

        return redirect()->route('users.index')->with('success','User added successfuly');

        // $this->validate($request, [
        //     'Name' => 'reqiured',
        //     'email' => 'reqiured',
        // ]);

    }


    public function edituser(Request $request , $user)
    {
        $user = User::find($request->id);
        return view('users.edit',['user'=>$user] );

        // return view('admin.edit', [
        //     'user' => $request->user(),
        // ]);
    }


     public function updateuser(Request $request, $id )
    {

        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('users.index')->with('success','User updated successfully');

    //     $request->user()->fill($request->validated());
    //      if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('admin.edit')->with('status', 'user-updated');
     }



    public function destroyuser($id , Request $request)
    {
        // $this->validate($request , [''=> '']);
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'User deleted successfully.');
        }

    }

}
