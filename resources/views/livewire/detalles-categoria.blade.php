<div class="min-h-screen transition-colors duration-300">
    <!-- Título de la categoría -->
    <div class="container px-5 py-12 mx-auto relative z-10">
        <div class="text-center mb-12">
            @if($categoria)
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ $categoria }}
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    Descubre nuestra selección de productos en {{ $categoria }}
                </p>
                <a href="{{ route('welcome') }}" class="inline-block mt-4 text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 underline transition-colors">
                    ← Volver al inicio
                </a>
            @else
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    Nuestros Productos
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    Explora nuestra amplia gama de productos y servicios
                </p>
            @endif
        </div>
    </div>

    <!-- Productos -->
    <section class="text-gray-600 dark:text-gray-400 body-font relative z-10">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-wrap -m-4">
                @forelse($productos as $producto)
                <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                    <a href="{{ route('detalleProducto', $producto->id) }}" class="block relative h-48 rounded overflow-hidden cursor-pointer group shadow-md dark:shadow-gray-800 hover:shadow-lg dark:hover:shadow-gray-700 transition-shadow">
                        <img alt="{{ $producto->nombre }}" 
                             class="object-cover object-center w-full h-full block transition-transform group-hover:scale-105" 
                             src="{{ $producto->imagen ?? 'https://dummyimage.com/420x260' }}">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all"></div>
                    </a>
                    <div class="mt-4">
                        <h3 class="text-gray-500 dark:text-gray-400 text-xs tracking-widest title-font mb-1">{{ $producto->categoria }}</h3>
                        <h2 class="text-gray-900 dark:text-white title-font text-lg font-medium">{{ $producto->nombre }}</h2>
                        <p class="mt-1 text-indigo-600 dark:text-indigo-400 font-semibold">${{ number_format($producto->precio, 2) }}</p>
                        @if($producto->reviews)
                            <div class="flex items-center mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $producto->reviews)
                                        <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 text-gray-300 dark:text-gray-600 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                                <span class="text-gray-400 dark:text-gray-500 text-xs ml-2">({{ $producto->reviews }})</span>
                            </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="w-full text-center py-12">
                    <div class="mx-auto max-w-md">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2M4 13h2m8-8v2m0 6v2"/>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">No hay productos</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-400">
                            @if($categoria)
                                No se encontraron productos en la categoría "{{ $categoria }}".
                            @else
                                No hay productos disponibles en este momento.
                            @endif
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('welcome') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-700 dark:hover:bg-indigo-800 transition-colors">
                                Volver al inicio
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
