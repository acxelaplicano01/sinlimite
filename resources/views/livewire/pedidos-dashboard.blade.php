<div class="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-300 relative z-10">
    <!-- Header del Dashboard -->
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-white mb-2">Dashboard de Pedidos</h1>
            <p class="text-indigo-100">Gestiona y confirma todos los pedidos de la tienda</p>
        </div>
    </div>

    <!-- Notificaciones -->
    @if (session()->has('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" 
             x-data="{ show: true }" 
             x-show="show" 
             x-transition
             x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="container mx-auto px-4 py-8">
        <!-- Filtros -->
        <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="flex flex-wrap items-center gap-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Filtrar por estado:</h2>
                <select wire:model="statusFilter" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="all">Todos los estados</option>
                    <option value="pending">Pendientes</option>
                    <option value="confirmed">Confirmados</option>
                    <option value="paid">Pagados</option>
                    <option value="shipped">Enviados</option>
                    <option value="delivered">Entregados</option>
                    <option value="cancelled">Cancelados</option>
                </select>
            </div>
        </div>

        <!-- Lista de Pedidos -->
        <div class="space-y-6">
            @forelse($orders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-{{ $order->status_color }}-500">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                Pedido #{{ $order->order_number }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Cliente: {{ $order->user->name }} ({{ $order->user->email }})
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-500">
                                Creado: {{ $order->created_at->format('d/m/Y H:i') }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-500 flex items-center">
                                <strong>Pago:</strong>&nbsp;
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ml-1
                                    {{ $order->payment_method === 'transferencia' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                    {{ $order->payment_method === 'pago_movil' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200' : '' }}
                                    {{ $order->payment_method === 'efectivo' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                    {{ !$order->payment_method ? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200' : '' }}
                                ">
                                    {{ $order->payment_method_label }}
                                </span>
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800 dark:bg-{{ $order->status_color }}-900 dark:text-{{ $order->status_color }}-200">
                                {{ $order->status_label }}
                            </span>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-2">
                                ${{ number_format($order->total_amount, 2) }}
                            </p>
                        </div>
                    </div>

                    <!-- Productos del pedido -->
                    <div class="border-t dark:border-gray-700 pt-4 mb-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Productos:</h4>
                        <div class="space-y-2">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 p-3 rounded">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $item->product->imagen ?? 'https://dummyimage.com/60x60' }}" 
                                             alt="{{ $item->product_snapshot['nombre'] ?? $item->product->nombre }}" 
                                             class="w-12 h-12 object-cover rounded">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">
                                                {{ $item->product_snapshot['nombre'] ?? $item->product->nombre }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Cantidad: {{ $item->quantity }}
                                                @if($item->color) • Color: {{ $item->color }} @endif
                                                @if($item->size) • Talla: {{ $item->size }} @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            ${{ number_format($item->total_price, 2) }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            ${{ number_format($item->unit_price, 2) }} c/u
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="flex flex-wrap gap-2 pt-4 border-t dark:border-gray-700">
                        <button wire:click="viewOrder({{ $order->id }})" 
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            Ver Detalles
                        </button>

                        @if($order->status === 'pending')
                            <button wire:click="confirmOrder({{ $order->id }})" 
                                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                Confirmar Pedido
                            </button>
                        @endif

                        @if(in_array($order->status, ['confirmed', 'pending']))
                            <button wire:click="markAsPaid({{ $order->id }})" 
                                    class="px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                                Marcar como Pagado
                            </button>
                        @endif

                        @if($order->status === 'paid')
                            <button wire:click="markAsShipped({{ $order->id }})" 
                                    class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors">
                                Marcar como Enviado
                            </button>
                        @endif

                        @if($order->status === 'shipped')
                            <button wire:click="markAsDelivered({{ $order->id }})" 
                                    class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors">
                                Marcar como Entregado
                            </button>
                        @endif

                        @if(!in_array($order->status, ['delivered', 'cancelled']))
                            <button wire:click="cancelOrder({{ $order->id }})" 
                                    onclick="return confirm('¿Estás seguro de que quieres cancelar este pedido?')"
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                Cancelar Pedido
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No hay pedidos</h3>
                    <p class="text-gray-600 dark:text-gray-400">Cuando los clientes hagan pedidos, aparecerán aquí.</p>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if($orders->hasPages())
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    <!-- Modal de Detalles del Pedido -->
    @if($selectedOrder)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Detalles del Pedido #{{ $selectedOrder->order_number }}
                        </h2>
                        <button wire:click="closeOrderDetails" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <!-- Información del Cliente -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Información del Cliente</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <strong>Nombre:</strong> {{ $selectedOrder->user->name }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <strong>Email:</strong> {{ $selectedOrder->user->email }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Dirección:</strong> {{ $selectedOrder->shipping_address['address'] ?? 'Por definir' }}
                            </p>
                        </div>

                        <!-- Información del Pedido -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Información del Pedido</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <strong>Estado:</strong> {{ $selectedOrder->status_label }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <strong>Total:</strong> ${{ number_format($selectedOrder->total_amount, 2) }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <strong>Método de Pago:</strong> 
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $selectedOrder->payment_method === 'transferencia' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                    {{ $selectedOrder->payment_method === 'pago_movil' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                    {{ $selectedOrder->payment_method === 'efectivo' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                    {{ !$selectedOrder->payment_method ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' : '' }}
                                ">
                                    @if($selectedOrder->payment_method === 'transferencia')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                        </svg>
                                    @elseif($selectedOrder->payment_method === 'pago_movil')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    @elseif($selectedOrder->payment_method === 'efectivo')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    @endif
                                    {{ $selectedOrder->payment_method_label }}
                                </span>
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <strong>Creado:</strong> {{ $selectedOrder->created_at->format('d/m/Y H:i') }}
                            </p>
                            @if($selectedOrder->confirmed_at)
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    <strong>Confirmado:</strong> {{ $selectedOrder->confirmed_at->format('d/m/Y H:i') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Productos del Pedido -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Productos del Pedido</h3>
                        <div class="space-y-4">
                            @foreach($selectedOrder->items as $item)
                                <div class="flex items-center space-x-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <img src="{{ $item->product->imagen ?? 'https://dummyimage.com/80x80' }}" 
                                         alt="{{ $item->product_snapshot['nombre'] ?? $item->product->nombre }}" 
                                         class="w-20 h-20 object-cover rounded">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900 dark:text-white">
                                            {{ $item->product_snapshot['nombre'] ?? $item->product->nombre }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $item->product_snapshot['descripcion'] ?? $item->product->descripcion }}
                                        </p>
                                        <div class="flex items-center space-x-4 mt-2">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                                Cantidad: {{ $item->quantity }}
                                            </span>
                                            @if($item->color)
                                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                                    Color: {{ $item->color }}
                                                </span>
                                            @endif
                                            @if($item->size)
                                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                                    Talla: {{ $item->size }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900 dark:text-white">
                                            ${{ number_format($item->total_price, 2) }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            ${{ number_format($item->unit_price, 2) }} c/u
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Resumen del Total -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex justify-between items-center text-lg font-semibold text-gray-900 dark:text-white">
                            <span>Total del Pedido:</span>
                            <span>${{ number_format($selectedOrder->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
