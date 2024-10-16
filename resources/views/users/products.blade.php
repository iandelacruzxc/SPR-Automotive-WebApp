@include('users.nav')
<div class="container mx-auto p-4">
    <!-- Identifier for product list -->
    <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">Product List</h1> <!-- Title -->

    <!-- Carousel for product 1 -->
    <section class="my-8 relative group">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h2 class="text-xl font-bold text-gray-800">{{ $product->name }}</h2>
                    <p class="mt-2 text-gray-600">{{ $product->description }}</p> <!-- Product description -->
                    <p class="mt-4 text-lg font-semibold text-gray-900">${{ number_format($product->price, 2) }}</p> <!-- Product price -->

                    <!-- Form for adding to cart -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf <!-- CSRF token for security -->
                        <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
            @endforeach

        </div>
    </section>
</div>

</main>

@include('users.user-script')


</body>

</html>