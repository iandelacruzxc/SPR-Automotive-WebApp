@include('users.nav')
<div class="container mx-auto p-4">
    <!-- Identifier for product list -->
    <!-- Carousel for product 1 -->
    <section class="my-8 relative group">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Our Services</h1>
            <p class="mt-2 text-gray-600">Explore our wide range of services designed to meet your needs.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 p-4">
            @foreach($services as $service)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 transform hover:scale-105 flex flex-col items-center p-4">
                <div class="text-blue-500 text-4xl mb-2">
                    <i class="fas fa-cog"></i> <!-- Replace with your preferred icon -->
                </div>
                <div class="p-4 text-center">
                    <h2 class="text-xl font-bold text-gray-800 hover:text-blue-600 transition duration-200">{{ $service->name }}</h2>
                    <p class="mt-2 text-gray-600">{{ $service->description }}</p>
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