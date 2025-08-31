<div class="min-h-screen transition-colors duration-300">
    <!-- Notificaciones -->
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

    <!-- Detalle del Producto -->
    <section class="text-gray-600 dark:text-gray-400 body-font overflow-hidden relative z-10">
        <div class="container px-5 py-24 mx-auto">
            <div class="lg:w-4/5 mx-auto flex flex-wrap">
                <img alt="{{ $product->nombre ?? 'Producto' }}" 
                     class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded shadow-lg dark:shadow-gray-800"
                     src="{{ $product->imagen ?? 'https://dummyimage.com/400x400' }}">
                     
                <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                    <h2 class="text-sm title-font text-gray-500 dark:text-gray-400 tracking-widest">{{ $product->categoria ?? 'SIN LÍMITE' }}</h2>
                    <h1 class="text-gray-900 dark:text-white text-3xl title-font font-medium mb-1">{{ $product->nombre ?? 'Producto' }}</h1>
                    
                    <div class="flex mb-4">
                        <span class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= ($product->reviews ?? 4))
                                    <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" class="w-4 h-4 text-indigo-400" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                @else
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        class="w-4 h-4 text-indigo-400" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                @endif
                            @endfor
                            <span class="ml-3 text-gray-600 dark:text-gray-400">{{ $product->reviews ?? 4 }} Reviews</span>
                        </span>
                        
                        @if($product->linkfacebook)
                        <span class="flex ml-3 pl-3 py-2 border-l-2 border-gray-200 dark:border-gray-800 text-gray-500 dark:text-gray-400 space-x-2">
                            <a href="{{ $product->linkfacebook }}" target="_blank" class="hover:text-indigo-400 transition-colors">
                                <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5"
                                    viewBox="0 0 24 24">
                                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                                </svg>
                            </a>
                            <a href="#" class="hover:text-indigo-400 transition-colors">
                                <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5"
                                    viewBox="0 0 24 24">
                                    <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
                                </svg>
                            </a>
                            <a href="#" class="hover:text-indigo-400 transition-colors">
                                <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5"
                                    viewBox="0 0 24 24">
                                    <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
                                </svg>
                            </a>
                        </span>
                        @endif
                    </div>
                    
                    <p class="leading-relaxed text-gray-700 dark:text-gray-300">
                        {{ $product->descripcion ?? 'Producto de alta calidad disponible en nuestra tienda SIN LÍMITE. Descripción detallada del producto con todas sus características y beneficios.' }}
                    </p>
                    
                    <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-200 dark:border-gray-800 mb-5">
                        @if($product->color)
                        <div class="flex">
                            <span class="mr-3 text-gray-700 dark:text-gray-300">Color</span>
                            @php
                                $colors = explode(',', $product->color);
                                $colorClasses = [
                                    'blanco' => 'bg-white border-gray-300',
                                    'negro' => 'bg-black border-gray-600',
                                    'azul' => 'bg-blue-500 border-blue-600',
                                    'rojo' => 'bg-red-500 border-red-600',
                                    'verde' => 'bg-green-500 border-green-600',
                                    'amarillo' => 'bg-yellow-500 border-yellow-600',
                                    'gris' => 'bg-gray-500 border-gray-600',
                                    'indigo' => 'bg-indigo-500 border-indigo-600'
                                ];
                            @endphp
                            @foreach($colors as $color)
                                @php $colorKey = strtolower(trim($color)); @endphp
                                <button class="border-2 {{ $colorClasses[$colorKey] ?? 'bg-gray-700 border-gray-800' }} rounded-full w-6 h-6 focus:outline-none ml-1 first:ml-0 hover:scale-110 transition-transform"></button>
                            @endforeach
                        </div>
                        @endif

                        @if($product->talla)
                        <div class="flex ml-6 items-center">
                            <span class="mr-3 text-gray-700 dark:text-gray-300">Talla</span>
                            <div class="relative">
                                <select class="rounded border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-900 bg-white dark:bg-transparent appearance-none py-2 focus:outline-none focus:border-indigo-500 text-black dark:text-white pl-3 pr-10">
                                    @php $tallas = explode(',', $product->talla); @endphp
                                    @foreach($tallas as $talla)
                                        <option class="text-black">{{ trim($talla) }}</option>
                                    @endforeach
                                </select>
                                <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 dark:text-gray-400 pointer-events-none flex items-center justify-center">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        class="w-4 h-4" viewBox="0 0 24 24">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="flex items-center">
                        <span class="title-font font-medium text-2xl text-gray-900 dark:text-white">
                            ${{ number_format($product->precio ?? 0, 2) }}
                        </span>
                        
                        @auth
                            <!-- Botón para usuarios autenticados -->
                            <button wire:click="addToCart" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded transition-colors disabled:opacity-50" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="addToCart">
                                    Añadir al Carrito
                                </span>
                                <span wire:loading wire:target="addToCart" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Agregando...
                                </span>
                            </button>
                            
                            <!-- Botón de favoritos para usuarios autenticados -->
                            <button wire:click="toggleFavorite" class="rounded-full w-10 h-10 bg-gray-200 dark:bg-gray-800 p-0 border-0 inline-flex items-center justify-center ml-4 transition-colors disabled:opacity-50 {{ $isFavorite ? 'text-red-500 hover:text-red-600' : 'text-gray-500 dark:text-gray-400 hover:text-red-400' }}" wire:loading.attr="disabled">
                                <div wire:loading.remove wire:target="toggleFavorite">
                                    <svg fill="{{ $isFavorite ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                        <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                                    </svg>
                                </div>
                                <div wire:loading wire:target="toggleFavorite">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </button>
                        @else
                            <!-- Botón para usuarios no autenticados que redirige al login -->
                            <a href="{{ route('login', ['redirect' => urlencode(request()->url())]) }}" class="flex ml-auto text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-600 rounded transition-colors">
                                <svg class="w-4 h-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Iniciar Sesión para Comprar
                            </a>
                            
                            <!-- Botón de favoritos para usuarios no autenticados -->
                            <a href="{{ route('login', ['redirect' => urlencode(request()->url())]) }}" class="rounded-full w-10 h-10 bg-gray-200 dark:bg-gray-800 p-0 border-0 inline-flex items-center justify-center ml-4 transition-colors text-gray-500 dark:text-gray-400 hover:text-red-400">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos Relacionados -->
    <section class="text-gray-600 dark:text-gray-400 body-font relative z-10">
        <div class="container px-5 py-24 mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-3xl font-medium title-font text-gray-900 dark:text-white mb-4">Productos Relacionados</h2>
                <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto text-gray-700 dark:text-gray-300">
                    Descubre más productos de nuestra colección SIN LÍMITE
                </p>
            </div>
            
            <div class="flex flex-wrap -m-4">
                @forelse($relatedProducts as $relatedProduct)
                <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                    <a href="{{ route('detalleProducto', $relatedProduct->id) }}" class="block relative h-48 rounded overflow-hidden cursor-pointer group">
                        <img alt="{{ $relatedProduct->nombre }}" 
                             class="object-cover object-center w-full h-full block transition-transform group-hover:scale-105" 
                             src="{{ $relatedProduct->imagen ?? 'https://dummyimage.com/420x260' }}">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all"></div>
                    </a>
                    <div class="mt-4">
                        <h3 class="text-gray-500 dark:text-gray-400 text-xs tracking-widest title-font mb-1">{{ $relatedProduct->categoria ?? 'SIN LÍMITE' }}</h3>
                        <h2 class="text-gray-900 dark:text-white title-font text-lg font-medium">{{ $relatedProduct->nombre }}</h2>
                        <p class="mt-1 text-indigo-500 dark:text-indigo-400">${{ number_format($relatedProduct->precio, 2) }}</p>
                    </div>
                </div>
                @empty
                <!-- Productos de ejemplo si no hay productos relacionados -->
                <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                    <a href="#" class="block relative h-48 rounded overflow-hidden cursor-pointer group">
                        <img alt="ecommerce" class="object-cover object-center w-full h-full block transition-transform group-hover:scale-105" src="https://dummyimage.com/420x260">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all"></div>
                    </a>
                    <div class="mt-4">
                        <h3 class="text-gray-500 dark:text-gray-400 text-xs tracking-widest title-font mb-1">SIN LÍMITE</h3>
                        <h2 class="text-gray-900 dark:text-white title-font text-lg font-medium">Producto Ejemplo</h2>
                        <p class="mt-1 text-indigo-500 dark:text-indigo-400">$16.00</p>
                    </div>
                </div>
                <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                    <a href="#" class="block relative h-48 rounded overflow-hidden cursor-pointer group">
                        <img alt="ecommerce" class="object-cover object-center w-full h-full block transition-transform group-hover:scale-105" src="https://dummyimage.com/421x261">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all"></div>
                    </a>
                    <div class="mt-4">
                        <h3 class="text-gray-500 dark:text-gray-400 text-xs tracking-widest title-font mb-1">SIN LÍMITE</h3>
                        <h2 class="text-gray-900 dark:text-white title-font text-lg font-medium">Producto Ejemplo</h2>
                        <p class="mt-1 text-indigo-500 dark:text-indigo-400">$21.15</p>
                    </div>
                </div>
                <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                    <a href="#" class="block relative h-48 rounded overflow-hidden cursor-pointer group">
                        <img alt="ecommerce" class="object-cover object-center w-full h-full block transition-transform group-hover:scale-105" src="https://dummyimage.com/422x262">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all"></div>
                    </a>
                    <div class="mt-4">
                        <h3 class="text-gray-500 dark:text-gray-400 text-xs tracking-widest title-font mb-1">SIN LÍMITE</h3>
                        <h2 class="text-gray-900 dark:text-white title-font text-lg font-medium">Producto Ejemplo</h2>
                        <p class="mt-1 text-indigo-500 dark:text-indigo-400">$12.00</p>
                    </div>
                </div>
                <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                    <a href="#" class="block relative h-48 rounded overflow-hidden cursor-pointer group">
                        <img alt="ecommerce" class="object-cover object-center w-full h-full block transition-transform group-hover:scale-105" src="https://dummyimage.com/423x263">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all"></div>
                    </a>
                    <div class="mt-4">
                        <h3 class="text-gray-500 dark:text-gray-400 text-xs tracking-widest title-font mb-1">SIN LÍMITE</h3>
                        <h2 class="text-gray-900 dark:text-white title-font text-lg font-medium">Producto Ejemplo</h2>
                        <p class="mt-1 text-indigo-500 dark:text-indigo-400">$18.40</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
