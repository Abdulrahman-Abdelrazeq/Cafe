<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}
    <div class="py-12">
        <div class="container mx-auto d-flex gap-3">
            <div class="order p-6 bg-white rounded-3 shadow w-25">
                <div class="orders overflow-y-scroll" style="max-height: 265px;">
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                    <div>fsssssssssss</div>
                </div>
                <div class="noted">
                    <h3>Notes</h3>
                    <textarea class="form-control mt-1 mb-2 resize-none" name="" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="room d-flex align-items-center gap-3 mb-3">
                    <h3 class="">Room</h3>
                    <select class="form-control" name="" id="">
                        <option value=""></option>
                    </select>
                </div>
                <hr class="">
                <h1 class="price mt-3 fs-3 mb-5 text-end">EGP 55</h1>
                <button class="btn btn-light btn-outline-dark float-right">Confirm</button>
                <div class="clear-both"></div>
            </div>
            <div class="products p-6 bg-white rounded-3 shadow">
                <div class="latest-order py-3">
                    <h1>Latest Order</h1>
                </div>
                <hr>
                <div class="products-list row py-3">
                    <div class="prdct col-3  text-light">
                        <div class="rounded-3 bg-warning position-relative">
                            <img class="rounded-3" src="{{ asset('images/tea1.png') }}" alt="">
                            <h1 class="fs-2 text-center py-2">Tea</h1>
                            <div class="price bg-warning text-center">9 LE</div>
                            <button class="add bg-warning">Add to order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>