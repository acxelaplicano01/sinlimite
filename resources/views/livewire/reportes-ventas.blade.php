<div class="min-h-screen transition-colors duration-300 relative z-10">
    <!-- Header de Reportes -->
    <div class="bg-gradient-to-r from-green-600 via-blue-600 to-purple-600 py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-white mb-2">Reportes de Ventas</h1>
            <p class="text-green-100">Análisis detallado de tus ventas y métricas de negocio</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Controles de Filtros -->
        <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <div class="grid md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Período de Tiempo
                    </label>
                    <select wire:model="dateRange" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                        <option value="7">Últimos 7 días</option>
                        <option value="30">Últimos 30 días</option>
                        <option value="90">Últimos 90 días</option>
                        <option value="365">Último año</option>
                        <option value="custom">Personalizado</option>
                    </select>
                </div>

                @if($dateRange === 'custom')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fecha Inicio
                        </label>
                        <input type="date" wire:model="startDate" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fecha Fin
                        </label>
                        <input type="date" wire:model="endDate" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                    </div>
                @endif

                <div class="flex justify-end">
                    <button wire:click="exportCSV" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Exportar CSV
                    </button>
                </div>
            </div>
        </div>

        <!-- Métricas Principales -->
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <!-- Total de Ingresos -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ingresos Totales</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($totalRevenue, 2) }}</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
                @if(isset($monthlyComparison['growth']))
                    <div class="mt-4 flex items-center">
                        <span class="text-sm font-medium {{ $monthlyComparison['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $monthlyComparison['growth'] >= 0 ? '+' : '' }}{{ number_format($monthlyComparison['growth'], 1) }}%
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">vs mes anterior</span>
                    </div>
                @endif
            </div>

            <!-- Total de Pedidos -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Pedidos</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalOrders) }}</p>
                    </div>
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Valor Promedio del Pedido -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Valor Promedio</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($averageOrderValue, 2) }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total de Productos Vendidos -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Productos Vendidos</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($totalProducts) }}</p>
                    </div>
                    <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-full">
                        <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos y Análisis -->
        <div class="grid lg:grid-cols-2 gap-8 mb-8">
            <!-- Gráfico de Ventas Diarias -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ventas Diarias</h3>
                <div class="space-y-3">
                    @if(count($dailySales) > 0)
                        @php $maxRevenue = max(array_column($dailySales, 'revenue')); @endphp
                        @foreach($dailySales as $sale)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400 w-16">{{ $sale['date'] }}</span>
                                <div class="flex-1 mx-4">
                                    <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $maxRevenue > 0 ? ($sale['revenue'] / $maxRevenue) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white w-20 text-right">
                                    ${{ number_format($sale['revenue'], 0) }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 w-12 text-right">
                                    {{ $sale['orders'] }} ord
                                </span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No hay datos de ventas para el período seleccionado</p>
                    @endif
                </div>
            </div>

            <!-- Ventas por Estado -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pedidos por Estado</h3>
                <div class="space-y-4">
                    @if(count($salesByStatus) > 0)
                        @foreach($salesByStatus as $statusData)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full bg-{{ $statusData['color'] }}-500 mr-3"></div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $statusData['status_label'] }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $statusData['count'] }} pedidos
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        ${{ number_format($statusData['revenue'], 0) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">No hay datos de pedidos para el período seleccionado</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Productos -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Productos Más Vendidos</h3>
            @if(count($topProducts) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b dark:border-gray-700">
                                <th class="text-left py-3 text-sm font-medium text-gray-600 dark:text-gray-400">Producto</th>
                                <th class="text-center py-3 text-sm font-medium text-gray-600 dark:text-gray-400">Categoría</th>
                                <th class="text-center py-3 text-sm font-medium text-gray-600 dark:text-gray-400">Cantidad Vendida</th>
                                <th class="text-right py-3 text-sm font-medium text-gray-600 dark:text-gray-400">Ingresos Totales</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($topProducts as $index => $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $index + 1 }}</span>
                                            </div>
                                            <img src="{{ $product['imagen'] ?? 'https://dummyimage.com/40x40' }}" 
                                                 alt="{{ $product['nombre'] }}" 
                                                 class="w-10 h-10 object-cover rounded mr-3">
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $product['nombre'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center py-4">
                                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full text-xs">
                                            {{ $product['categoria'] }}
                                        </span>
                                    </td>
                                    <td class="text-center py-4">
                                        <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ number_format($product['total_quantity']) }}
                                        </span>
                                    </td>
                                    <td class="text-right py-4">
                                        <span class="text-lg font-bold text-green-600 dark:text-green-400">
                                            ${{ number_format($product['total_revenue'], 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400 text-center py-8">No hay datos de productos para el período seleccionado</p>
            @endif
        </div>
    </div>
</div>
