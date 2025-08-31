<div class="min-h-screen transition-colors duration-300 relative z-10">
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

    @if (session()->has('cart_error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" 
             x-data="{ show: true }" 
             x-show="show" 
             x-transition
             x-init="setTimeout(() => show = false, 3000)">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ session('cart_error') }}
            </div>
        </div>
    @endif

    <!-- Encabezado del Carrito -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mi Carrito</h1>
            <a href="{{ route('welcome') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                ← Seguir Comprando
            </a>
        </div>

        @if(count($cartItems) > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <!-- Encabezados de tabla -->
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4">
                    <div class="grid grid-cols-12 gap-4 text-sm font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                        <div class="col-span-6">Producto</div>
                        <div class="col-span-2 text-center">Cantidad</div>
                        <div class="col-span-2 text-center">Precio</div>
                        <div class="col-span-2 text-center">Total</div>
                    </div>
                </div>

                <!-- Items del carrito -->
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($cartItems as $item)
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-12 gap-4 items-center">
                                <!-- Producto -->
                                <div class="col-span-6 flex items-center space-x-4">
                                    <img src="{{ $item->product->imagen ?? 'https://dummyimage.com/80x80' }}" 
                                         alt="{{ $item->product->nombre }}" 
                                         class="w-16 h-16 object-cover rounded-lg">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $item->product->nombre }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $item->product->categoria }}
                                        </p>
                                        @if($item->color || $item->size)
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                @if($item->color) Color: {{ $item->color }} @endif
                                                @if($item->color && $item->size) | @endif
                                                @if($item->size) Talla: {{ $item->size }} @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Cantidad -->
                                <div class="col-span-2 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                            -
                                        </button>
                                        <span class="w-12 text-center text-gray-900 dark:text-white font-medium">
                                            {{ $item->quantity }}
                                        </span>
                                        <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                            +
                                        </button>
                                    </div>
                                </div>

                                <!-- Precio unitario -->
                                <div class="col-span-2 text-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-white">
                                        ${{ number_format($item->price, 2) }}
                                    </span>
                                </div>

                                <!-- Total del item -->
                                <div class="col-span-2 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <span class="text-lg font-bold text-gray-900 dark:text-white">
                                            ${{ number_format($item->quantity * $item->price, 2) }}
                                        </span>
                                        <button wire:click="removeItem({{ $item->id }})"
                                                class="text-red-500 hover:text-red-700 transition-colors ml-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Resumen del carrito -->
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-4">
                            <button wire:click="clearCart" 
                                    class="px-4 py-2 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 border border-red-300 dark:border-red-600 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                Vaciar Carrito
                            </button>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total:</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">
                                ${{ number_format($total, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="mt-8 flex justify-between items-center">
                <a href="{{ route('productos') }}" 
                   class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    Continuar Comprando
                </a>
                <div class="flex space-x-4">
                    <button wire:click="createOrder" 
                            class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Crear Pedido
                    </button>
                </div>
            </div>

        @else
            <!-- Carrito vacío -->
            <div class="text-center py-16">
                <svg class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 6.5M7 13l2.5 6.5M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"></path>
                </svg>
                <h3 class="mt-4 text-xl font-medium text-gray-900 dark:text-white">Tu carrito está vacío</h3>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Comienza a agregar productos a tu carrito para verlos aquí.</p>
                <div class="mt-8">
                    <a href="{{ route('productos') }}" 
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Explorar Productos
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal de Métodos de Pago -->
    @if($showPaymentModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <!-- Header del Modal -->
            <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Métodos de Pago</h2>
                <button wire:click="closePaymentModal" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="p-6">
                <!-- Resumen del Pedido -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Resumen del Pedido</h3>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-400">Total a pagar:</span>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <!-- Métodos de Pago -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Selecciona tu método de pago</h3>
                    
                    <!-- Transferencia Bancaria -->
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors {{ $selectedPaymentMethod === 'transferencia' ? 'ring-2 ring-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : '' }}"
                         wire:click="selectPaymentMethod('transferencia')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Transferencia Bancaria</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Transfiere directamente a nuestra cuenta</p>
                                </div>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600 {{ $selectedPaymentMethod === 'transferencia' ? 'bg-indigo-600 border-indigo-600' : '' }}">
                                @if($selectedPaymentMethod === 'transferencia')
                                <div class="w-2 h-2 bg-white rounded-full mx-auto mt-1"></div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Pago Móvil -->
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors {{ $selectedPaymentMethod === 'pago_movil' ? 'ring-2 ring-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : '' }}"
                         wire:click="selectPaymentMethod('pago_movil')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Pago Móvil</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Paga desde tu teléfono móvil</p>
                                </div>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600 {{ $selectedPaymentMethod === 'pago_movil' ? 'bg-indigo-600 border-indigo-600' : '' }}">
                                @if($selectedPaymentMethod === 'pago_movil')
                                <div class="w-2 h-2 bg-white rounded-full mx-auto mt-1"></div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Efectivo -->
                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors {{ $selectedPaymentMethod === 'efectivo' ? 'ring-2 ring-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : '' }}"
                         wire:click="selectPaymentMethod('efectivo')">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Efectivo</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Pago contra entrega</p>
                                </div>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600 {{ $selectedPaymentMethod === 'efectivo' ? 'bg-indigo-600 border-indigo-600' : '' }}">
                                @if($selectedPaymentMethod === 'efectivo')
                                <div class="w-2 h-2 bg-white rounded-full mx-auto mt-1"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información de Cuentas Bancarias -->
                @if($selectedPaymentMethod === 'transferencia')
                <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Datos para Transferencia
                    </h4>
                    <div class="space-y-3">
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Banco Mercantil</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Cuenta Corriente: 0105-0123-456789012345</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Titular: SIN LÍMITE C.A.</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">RIF: J-12345678-9</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Banesco</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Cuenta Corriente: 0134-0987-654321098765</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Titular: SIN LÍMITE C.A.</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">RIF: J-12345678-9</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($selectedPaymentMethod === 'pago_movil')
                <div class="mt-6 bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Datos para Pago Móvil
                    </h4>
                    <div class="space-y-3">
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Banco Mercantil</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Teléfono: 0414-1234567</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">CI: 12.345.678</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Titular: Juan Pérez</p>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">Banesco</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Teléfono: 0426-9876543</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">CI: 98.765.432</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Titular: María González</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($selectedPaymentMethod === 'efectivo')
                <div class="mt-6 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Información de Pago en Efectivo
                    </h4>
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            El pago se realizará al momento de la entrega. Nuestro repartidor llevará una máquina de punto de venta para pagos con tarjeta de débito/crédito o podrás pagar en efectivo.
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            <strong>Importante:</strong> Ten el monto exacto o cercano para facilitar el proceso de entrega.
                        </p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Footer del Modal -->
            <div class="flex justify-end space-x-4 p-6 border-t border-gray-200 dark:border-gray-700">
                <button wire:click="closePaymentModal" 
                        class="px-6 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
                    Cancelar
                </button>
                <button wire:click="processPayment" 
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                        {{ !$selectedPaymentMethod ? 'disabled' : '' }}>
                    Confirmar Método de Pago
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
