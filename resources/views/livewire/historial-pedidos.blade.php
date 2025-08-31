
<div class="min-h-screen transition-colors duration-300 relative z-10">
    <!-- Notificaciones -->
    @if (session()->has('orders_success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" 
             x-data="{ show: true }" 
             x-show="show" 
             x-transition
             x-init="setTimeout(() => show = false, 3000)">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('orders_success') }}
            </div>
        </div>
    @endif

    @if (session()->has('orders_error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" 
             x-data="{ show: true }" 
             x-show="show" 
             x-transition
             x-init="setTimeout(() => show = false, 3000)">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ session('orders_error') }}
            </div>
        </div>
    @endif

    <!-- Encabezado -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mis Pedidos</h1>
            <div class="flex space-x-4">
                <a href="{{ route('carrito') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                    <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5L17 8m0 0l2 4"></path>
                    </svg>
                    Ver Carrito
                </a>
                <a href="{{ route('welcome') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                    ← Seguir Comprando
                </a>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-wrap gap-3">
                <button wire:click="filterOrders('all')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter === 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    Todos
                </button>
                <button wire:click="filterOrders('pending')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter === 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    Pendientes
                </button>
                <button wire:click="filterOrders('confirmed')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter === 'confirmed' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    Confirmados
                </button>
                <button wire:click="filterOrders('paid')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter === 'paid' ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    Pagados
                </button>
                <button wire:click="filterOrders('shipped')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter === 'shipped' ? 'bg-purple-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    Enviados
                </button>
                <button wire:click="filterOrders('delivered')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter === 'delivered' ? 'bg-green-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    Entregados
                </button>
                <button wire:click="filterOrders('cancelled')" 
                        class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $filter === 'cancelled' ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    Cancelados
                </button>
            </div>
        </div>

        <!-- Lista de Pedidos -->
        @if(count($orders) > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <!-- Header del Pedido -->
                        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Pedido #{{ $order->order_number }}
                                    </h3>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $this->getStatusBadgeClass($order->status) }}">
                                        {{ $this->getStatusLabel($order->status) }}
                                    </span>
                                    @if($order->payment_method)
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                            {{ $order->payment_method_label }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">
                                        ${{ number_format($order->total_amount, 2) }}
                                    </div>
                                    @if($order->status === 'pending')
                                        <button wire:click="cancelOrder({{ $order->id }})"
                                                wire:confirm="¿Estás seguro de que quieres cancelar este pedido?"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                                            Cancelar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Productos del Pedido -->
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                    <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <!-- Imagen del Producto -->
                                        <div class="flex-shrink-0">
                                            @if($item->product && $item->product->imagen)
                                                <img src="{{ asset('storage/' . $item->product->imagen) }}" 
                                                     alt="{{ $item->product_snapshot['nombre'] ?? 'Producto' }}" 
                                                     class="w-16 h-16 object-cover rounded-md">
                                            @else
                                                <div class="w-16 h-16 bg-gray-300 dark:bg-gray-600 rounded-md flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Información del Producto -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                {{ $item->product_snapshot['nombre'] ?? 'Producto no disponible' }}
                                            </h4>
                                            <div class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <span>Cantidad: {{ $item->quantity }}</span>
                                                @if($item->color)
                                                    <span class="mx-2">•</span>
                                                    <span>Color: {{ $item->color }}</span>
                                                @endif
                                                @if($item->size)
                                                    <span class="mx-2">•</span>
                                                    <span>Talla: {{ $item->size }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Precio -->
                                        <div class="flex-shrink-0 text-right">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                ${{ number_format($item->total_price, 2) }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                ${{ number_format($item->unit_price, 2) }} c/u
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Resumen del Pedido -->
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        Total de productos: {{ $order->items->sum('quantity') }}
                                    </div>
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">
                                        Total: ${{ number_format($order->total_amount, 2) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Información de Entrega -->
                            @if($order->shipping_address)
                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                    <h5 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Dirección de entrega:</h5>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        @php
                                            $address = is_array($order->shipping_address) ? $order->shipping_address : json_decode($order->shipping_address, true);
                                        @endphp
                                        <p>{{ $address['name'] ?? 'No especificado' }}</p>
                                        @if(isset($address['address']) && $address['address'] !== 'Por definir')
                                            <p>{{ $address['address'] }}</p>
                                        @endif
                                        @if(isset($address['city']) && $address['city'] !== 'Por definir')
                                            <p>{{ $address['city'] }}, {{ $address['country'] ?? '' }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Estado Vacío -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12 text-center">
                <svg class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                    @if($filter === 'all')
                        No tienes pedidos aún
                    @else
                        No tienes pedidos {{ $this->getStatusLabel($filter) }}
                    @endif
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    @if($filter === 'all')
                        Cuando realices tu primera compra, aparecerá aquí.
                    @else
                        No hay pedidos con el estado seleccionado.
                    @endif
                </p>
                <a href="{{ route('welcome') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Comenzar a Comprar
                </a>
            </div>
        @endif
    </div>
</div>

