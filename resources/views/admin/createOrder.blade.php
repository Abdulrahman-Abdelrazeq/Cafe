<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create custom order') }}
        </h2>
    </x-slot>

    <div class="row py-12 mx-5">
        <div class="col-md-8">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                    <h3 class="text-xl">List of Drinks</h3>
                    <div class="row my-5">
                        @foreach ($products as $product)
                            <div class="col-md-4">
                                <div class="card relative mb-3">
                                    <img src="{{ asset('product/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:250px">
                                    <div class="absolute top-2 right-2 rounded bg-blue-500 text-white text-xs p-2">
                                        {{ $product->price }} LE
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">{{ $product->category->name }}</p>
                                        <button type="button" class="bg-green-500 hover:bg-green-700 text-white text-sm px-4 py-2 rounded-full mt-3" onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ asset('product/' . $product->image) }}')">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>       
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @error ('user_id')
                <div class="alert alert-danger">
                    Please select a user
                </div>
            @enderror
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                    <h3 class="text-xl">Cart Details</h3>
                    <!-- Message when no products are added -->
                    <div class="text-muted text-center my-5">
                        <p id="empty-products-message">Added products will show in here.</p>
                    </div>
    

                    <!-- Cart section -->
                    <div id="cart-section" class="my-5 text-center text-muted">

                        <!-- Products list -->
                        <div id="selected-products"></div>

                        <div id="order-total" class="text-lg font-bold mt-5"></div>

                        <!-- Display the form only if products are added -->
                        <form action="{{ route('admin.submitOrder') }}" method="POST" class="my-5" id="order-form" style="display:none">
                            @csrf
                            <div class="form-group" id="user-select-group">
                                <label for="user_id">User</label>
                                <select class="form-control" name="user_id" id="user_id">
                                    <option value="" disabled selected>Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Add hidden input fields for selected products -->
                            <div id="selected-products-input"></div>
                            <button type="submit" class="form-control py-2 bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-700 mt-3" id="submit-button">Create Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    let quantities = {};

    // Function to dynamically update the selected products list
    function updateSelectedProducts(product) {
        const selectedProductsDiv = document.getElementById('selected-products');
        const emptyProductsMessage = document.getElementById('empty-products-message');
        const orderForm = document.getElementById('order-form');
        const cartSection = document.getElementById('cart-section');

        if (selectedProductsDiv.children.length === 0) {
            emptyProductsMessage.style.display = 'none';
            orderForm.style.display = 'block';
            cartSection.style.display = 'block';
        }

        const existingProduct = document.getElementById(`product-${product.id}`);
        if (existingProduct) {
            const quantityElement = existingProduct.querySelector('.quantity');
            let quantity = parseInt(quantityElement.innerText, 10);
            quantity++;
            quantityElement.innerText = quantity;
            updateQuantityInForm(product.id, quantity);
        } else {
            const productDiv = document.createElement('div');
            productDiv.className = 'mb-3 p-4 border rounded bg-gray-100'; // Add Tailwind CSS classes for styling
            productDiv.id = `product-${product.id}`;
            productDiv.innerHTML = `
                <div class="flex items-center">
                    <div class="w-1/3">
                        <img src="${product.image}" alt="${product.name}" class="w-full rounded" style="height: 100px;">
                    </div>
                    <div class="w-2/3">
                        <p class="text-lg font-bold">${product.name}</p>
                        <p class="text-sm text-gray-500">${product.price} LE</p>
                    </div>
                </div>
                <div class="flex items-center mt-3">
                    <div class="w-1/3">
                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white text-sm px-2 py-1 rounded" onclick="increaseQuantity(${product.id})">+</button>
                        <span class="quantity text-lg mx-2">1</span>
                        <button type="button" class="bg-orange-500 hover:bg-orange-700 text-white text-sm px-2 py-1 rounded" onclick="decreaseQuantity(${product.id})">-</button>
                    </div>
                    <div class="w-2/3">
                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white text-sm px-2 py-1 rounded ml-2" onclick="removeProduct(${product.id})">Remove</button>
                    </div>                    
                </div>
            `;
            selectedProductsDiv.appendChild(productDiv);
            updateQuantityInForm(product.id, 1); // Set the initial quantity to 1
        }

        calculateTotal();
    }

    // Function to increase the quantity of a product
    function increaseQuantity(productId) {
        const quantityElement = document.getElementById(`product-${productId}`).querySelector('.quantity');
        let quantity = parseInt(quantityElement.innerText, 10);
        quantity++;
        quantityElement.innerText = quantity;
        updateQuantityInForm(productId, quantity);
        calculateTotal();
    }

    // Function to decrease the quantity of a product
    function decreaseQuantity(productId) {
        const quantityElement = document.getElementById(`product-${productId}`).querySelector('.quantity');
        let quantity = parseInt(quantityElement.innerText, 10);
        if (quantity > 1) {
            quantity--;
            quantityElement.innerText = quantity;
            updateQuantityInForm(productId, quantity);
            calculateTotal();
        }
    }

    // Function to remove a product from the cart
    function removeProduct(productId) {
        const productElement = document.getElementById(`product-${productId}`);
        productElement.parentNode.removeChild(productElement);
        updateQuantityInForm(productId, 0); // Set quantity to 0 when removing
        calculateTotal();

        // If no products are left, hide the form and display the 'Add products here' message
        const selectedProductsDiv = document.getElementById('selected-products');
        const emptyProductsMessage = document.getElementById('empty-products-message');
        const orderForm = document.getElementById('order-form');
        const cartSection = document.getElementById('cart-section');

        if (selectedProductsDiv.children.length === 0) {
            emptyProductsMessage.style.display = 'block'; // Display 'Add products here' message
            orderForm.style.display = 'none'; // Hide the form
            cartSection.style.display = 'none'; // Hide the entire cart section
        }
    }

    // Function to add a product to the cart
    function addToCart(productId, productName, productPrice, productImage) {
        const product = { id: productId, name: productName, price: productPrice, image: productImage };
        updateSelectedProducts(product);
    }

    // Function to update the quantity in the form
    function updateQuantityInForm(productId, quantity) {
        quantities[productId] = quantity; // Update the quantity in the object

        // Add the selected product to hidden input fields
        const selectedProductsInput = document.getElementById('selected-products-input');
        selectedProductsInput.innerHTML = ''; // Clear existing input fields

        Object.entries(quantities).forEach(([productId, quantity]) => {
            const inputName = `products[${productId}]`;
            const inputQuantity = `quantities[${productId}]`;

            const inputProduct = document.createElement('input');
            inputProduct.type = 'hidden';
            inputProduct.name = inputName;
            inputProduct.value = productId;
            selectedProductsInput.appendChild(inputProduct);

            const inputQty = document.createElement('input');
            inputQty.type = 'hidden';
            inputQty.name = inputQuantity;
            inputQty.value = quantity;
            selectedProductsInput.appendChild(inputQty);
        });
    }

    // Function to calculate and display the total order amount
    function calculateTotal() {
        const selectedProductsDiv = document.getElementById('selected-products');
        const totalElement = document.getElementById('order-total');

        let total = 0;
        selectedProductsDiv.childNodes.forEach(productDiv => {
            const quantity = parseInt(productDiv.querySelector('.quantity').innerText, 10);
            const price = parseFloat(productDiv.querySelector('.text-sm').innerText); // Assuming the price is in a text element with 'text-sm' class
            total += quantity * price;
        });

        totalElement.innerText = `Total: ${total.toFixed(2)} LE`; // Display the total with two decimal places
    }
</script>

