<div class="min-h-screen  transition-colors duration-300 relative z-0">
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                @if($categoria)
                    Productos - {{ $categoria }}
                @else
                    Gestión de Productos
                @endif
            </h1>
            @if($categoria)
                <p class="text-gray-600 dark:text-gray-400 mt-2">Mostrando productos de la categoría: {{ $categoria }}</p>
                <a href="{{ route('productos') }}" class="text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 underline mt-1 inline-block transition-colors">
                    ← Ver todos los productos
                </a>
            @endif
        </div>
        <div class="flex space-x-4">
            <button wire:click="toggleViewMode" class="bg-gray-500 dark:bg-gray-600 hover:bg-gray-700 dark:hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition-colors">
                {{ $viewMode === 'cards' ? 'Vista Tabla' : 'Vista Tarjetas' }}
            </button>
            @if(!$categoria)
                <button wire:click="create" class="bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors">
                    Nuevo Producto
                </button>
            @endif
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if($viewMode === 'cards')
        <!-- Vista de Tarjetas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-gray-700 overflow-hidden hover:shadow-lg dark:hover:shadow-gray-600 transition-shadow duration-300">
                    <div class="relative h-48 bg-gray-200 dark:bg-gray-700">
                        @if($product->imagen)
                            <img src="{{ Storage::url($product->imagen) }}" alt="{{ $product->nombre }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400 dark:text-gray-500">
                                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2">
                            <span class="bg-blue-500 dark:bg-blue-600 text-white px-2 py-1 rounded-full text-xs">{{ $product->categoria }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-2">{{ $product->nombre }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">{{ $product->descripcion ?? 'Sin descripción' }}</p>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">${{ number_format($product->precio, 2) }}</span>
                            @if($product->color || $product->talla)
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    @if($product->color)
                                        <span class="mr-2">{{ $product->color }}</span>
                                    @endif
                                    @if($product->talla)
                                        <span>{{ $product->talla }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('detalleProducto', $product->id) }}" class="flex-1 bg-indigo-500 dark:bg-indigo-600 hover:bg-indigo-600 dark:hover:bg-indigo-700 text-white font-bold py-2 px-3 rounded text-sm text-center transition-colors">
                                Ver
                            </a>
                            <button wire:click="edit({{ $product->id }})" class="flex-1 bg-yellow-500 dark:bg-yellow-600 hover:bg-yellow-600 dark:hover:bg-yellow-700 text-white font-bold py-2 px-3 rounded text-sm transition-colors">
                                Editar
                            </button>
                            <button wire:click="delete({{ $product->id }})" onclick="return confirm('¿Estás seguro?')" class="flex-1 bg-red-500 dark:bg-red-600 hover:bg-red-600 dark:hover:bg-red-700 text-white font-bold py-2 px-3 rounded text-sm transition-colors">
                                Eliminar
                            </button>
                        </div>
                        @if($product->linkfacebook)
                            <a href="{{ $product->linkfacebook }}" target="_blank" class="block mt-2 text-center bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 text-white py-1 px-2 rounded text-sm transition-colors">
                                Ver en Facebook
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-6l-4 4-4-4H4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No hay productos</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comienza creando tu primer producto.</p>
                    <div class="mt-6">
                        <button wire:click="create" class="bg-blue-500 dark:bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-colors">
                            Nuevo Producto
                        </button>
                    </div>
                </div>
            @endforelse
        </div>
    @else
        <!-- Vista de Tabla -->
        <div class="bg-white dark:bg-gray-800 shadow-md dark:shadow-gray-700 rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Color</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Talla</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Imagen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $product->categoria }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${{ number_format($product->precio, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $product->color }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $product->talla }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if($product->imagen)
                                    <img src="{{ Storage::url($product->imagen) }}" class="h-12 w-12 object-cover rounded" />
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">Sin imagen</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('detalleProducto', $product->id) }}" class="bg-indigo-500 dark:bg-indigo-600 hover:bg-indigo-700 dark:hover:bg-indigo-700 text-white font-bold py-1 px-3 rounded mr-2 transition-colors">
                                    Ver
                                </a>
                                <button wire:click="edit({{ $product->id }})" class="bg-yellow-500 dark:bg-yellow-600 hover:bg-yellow-700 dark:hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded mr-2 transition-colors">
                                    Editar
                                </button>
                                <button wire:click="delete({{ $product->id }})" onclick="return confirm('¿Estás seguro?')" class="bg-red-500 dark:bg-red-600 hover:bg-red-700 dark:hover:bg-red-700 text-white font-bold py-1 px-3 rounded transition-colors">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No hay productos registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    <!-- Modal para Crear/Editar Producto -->
    @if($showModal)
        <div class="fixed inset-0 bg-gray-600 dark:bg-gray-900 bg-opacity-50 dark:bg-opacity-75 overflow-y-auto h-full w-full z-50 transition-opacity" wire:click="closeModal">
            <div class="relative top-20 mx-auto p-5 border dark:border-gray-600 w-11/12 md:w-3/4 lg:w-1/2 shadow-lg dark:shadow-gray-800 rounded-md bg-white dark:bg-gray-800" wire:click.stop>
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $selectedId ? 'Editar Producto' : 'Nuevo Producto' }}</p>
                    <button wire:click="closeModal" class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="mt-3">
                    @livewire('product-form', ['productId' => $selectedId], key($selectedId))
                </div>
            </div>
        </div>
    @endif
</div>
</div>
