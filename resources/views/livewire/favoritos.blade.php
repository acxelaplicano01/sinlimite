<div class="min-h-screen transition-colors duration-300 relative z-10">
    <!-- Notificaciones -->
    @if (session()->has('favorite_success'))
        <div class="fixed top-4 right-4 bg-pink-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" 
             x-data="{ show: true }" 
             x-show="show" 
             x-transition
             x-init="setTimeout(() => show = false, 3000)">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                </svg>
                {{ session('favorite_success') }}
            </div>
        </div>
    @endif

    @if (session()->has('cart_success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" 
             x-data="{ show: true }" 
             x-show="show" 
             x-transition
             x-init="setTimeout(() => show = false, 3000)">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('cart_success') }}
            </div>
        </div>
    @endif

    <!-- Encabezado de Favoritos -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mis Favoritos</h1>
            <a href="{{ route('welcome') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                ← Seguir Explorando
            </a>
        </div>

        @if(count($favorites) > 0)
            <!-- Grid de productos favoritos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($favorites as $favorite)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300">
                        <!-- Imagen del producto -->
                        <div class="relative">
                            <img src="{{ $favorite->product->imagen ?? 'https://dummyimage.com/300x300' }}" 
                                 alt="{{ $favorite->product->nombre }}" 
                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            <!-- Botón de eliminar favorito -->
                            <button wire:click="removeFavorite({{ $favorite->id }})"
                                    class="absolute top-2 right-2 w-8 h-8 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors shadow-md">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Información del producto -->
                        <div class="p-6">
                            <div class="mb-2">
                                <span class="text-sm text-indigo-600 dark:text-indigo-400 font-medium">
                                    {{ $favorite->product->categoria }}
                                </span>
                            </div>
                            
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                {{ $favorite->product->nombre }}
                            </h3>
                            
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                                {{ $favorite->product->descripcion }}
                            </p>

                            <!-- Precio y calificación -->
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-gray-900 dark:text-white">
                                    ${{ number_format($favorite->product->precio, 2) }}
                                </span>
                                
                                @if($favorite->product->reviews)
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $favorite->product->reviews ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" 
                                                 fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                            </svg>
                                        @endfor
                                        <span class="ml-1 text-sm text-gray-500 dark:text-gray-400">
                                            ({{ $favorite->product->reviews }})
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex space-x-2">
                                <button wire:click="addToCart({{ $favorite->product->id }})"
                                        class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors font-medium">
                                    Añadir al Carrito
                                </button>
                                
                                <a href="{{ route('detalleProducto', $favorite->product->id) }}"
                                   class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    Ver
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <!-- Sin favoritos -->
            <div class="text-center py-16">
                <svg class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <h3 class="mt-4 text-xl font-medium text-gray-900 dark:text-white">No tienes favoritos aún</h3>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Comienza a explorar productos y agrega los que más te gusten a tus favoritos.</p>
                <div class="mt-8">
                    <a href="{{ route('productos') }}" 
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Explorar Productos
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
