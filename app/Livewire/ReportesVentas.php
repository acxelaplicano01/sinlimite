<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportesVentas extends Component
{
    public $dateRange = '30';
    public $selectedMetric = 'revenue';
    public $startDate;
    public $endDate;
    
    // Métricas principales
    public $totalRevenue = 0;
    public $totalOrders = 0;
    public $averageOrderValue = 0;
    public $totalProducts = 0;
    
    // Datos para gráficos
    public $dailySales = [];
    public $topProducts = [];
    public $salesByStatus = [];
    public $monthlyComparison = [];
    
    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->loadReports();
    }

    public function updatedDateRange()
    {
        switch ($this->dateRange) {
            case '7':
                $this->startDate = now()->subDays(7)->format('Y-m-d');
                break;
            case '30':
                $this->startDate = now()->subDays(30)->format('Y-m-d');
                break;
            case '90':
                $this->startDate = now()->subDays(90)->format('Y-m-d');
                break;
            case '365':
                $this->startDate = now()->subDays(365)->format('Y-m-d');
                break;
            case 'custom':
                return; // No hacer nada, el usuario establecerá las fechas
        }
        $this->endDate = now()->format('Y-m-d');
        $this->loadReports();
    }

    public function updatedStartDate()
    {
        if ($this->dateRange === 'custom') {
            $this->loadReports();
        }
    }

    public function updatedEndDate()
    {
        if ($this->dateRange === 'custom') {
            $this->loadReports();
        }
    }

    public function loadReports()
    {
        $this->loadMainMetrics();
        $this->loadDailySales();
        $this->loadTopProducts();
        $this->loadSalesByStatus();
        $this->loadMonthlyComparison();
    }

    private function loadMainMetrics()
    {
        $orders = Order::whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59'])
            ->whereNotIn('status', ['cancelled']);

        $this->totalRevenue = $orders->sum('total_amount');
        $this->totalOrders = $orders->count();
        $this->averageOrderValue = $this->totalOrders > 0 ? $this->totalRevenue / $this->totalOrders : 0;
        $this->totalProducts = OrderItem::whereHas('order', function($query) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59'])
                ->whereNotIn('status', ['cancelled']);
        })->sum('quantity');
    }

    private function loadDailySales()
    {
        $sales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as revenue'),
            DB::raw('COUNT(*) as orders')
        )
        ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59'])
        ->whereNotIn('status', ['cancelled'])
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $this->dailySales = $sales->map(function($sale) {
            return [
                'date' => Carbon::parse($sale->date)->format('d/m'),
                'revenue' => (float) $sale->revenue,
                'orders' => $sale->orders,
            ];
        })->toArray();
    }

    private function loadTopProducts()
    {
        $this->topProducts = OrderItem::select(
            'products.nombre',
            'products.imagen',
            'products.categoria',
            DB::raw('SUM(order_items.quantity) as total_quantity'),
            DB::raw('SUM(order_items.total_price) as total_revenue')
        )
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->whereBetween('orders.created_at', [$this->startDate, $this->endDate . ' 23:59:59'])
        ->whereNotIn('orders.status', ['cancelled'])
        ->groupBy('products.id', 'products.nombre', 'products.imagen', 'products.categoria')
        ->orderBy('total_revenue', 'desc')
        ->limit(10)
        ->get()
        ->toArray();
    }

    private function loadSalesByStatus()
    {
        $this->salesByStatus = Order::select(
            'status',
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(total_amount) as revenue')
        )
        ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59'])
        ->groupBy('status')
        ->get()
        ->map(function($item) {
            return [
                'status' => $item->status,
                'status_label' => $this->getStatusLabel($item->status),
                'count' => $item->count,
                'revenue' => (float) $item->revenue,
                'color' => $this->getStatusColor($item->status)
            ];
        })
        ->toArray();
    }

    private function loadMonthlyComparison()
    {
        $currentMonth = Order::whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ])->whereNotIn('status', ['cancelled'])->sum('total_amount');

        $previousMonth = Order::whereBetween('created_at', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth()
        ])->whereNotIn('status', ['cancelled'])->sum('total_amount');

        $this->monthlyComparison = [
            'current' => (float) $currentMonth,
            'previous' => (float) $previousMonth,
            'growth' => $previousMonth > 0 ? (($currentMonth - $previousMonth) / $previousMonth) * 100 : 0
        ];
    }

    private function getStatusLabel($status)
    {
        return match($status) {
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmado',
            'paid' => 'Pagado',
            'shipped' => 'Enviado',
            'delivered' => 'Entregado',
            'cancelled' => 'Cancelado',
            default => 'Desconocido',
        };
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'paid' => 'green',
            'shipped' => 'purple',
            'delivered' => 'emerald',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    public function exportCSV()
    {
        $orders = Order::with(['items.product', 'user'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59'])
            ->get();

        $csvData = "Número de Pedido,Cliente,Email,Estado,Total,Fecha de Creación,Productos\n";
        
        foreach ($orders as $order) {
            $products = $order->items->map(function($item) {
                return $item->product->nombre . ' (x' . $item->quantity . ')';
            })->implode('; ');
            
            $csvData .= sprintf(
                "%s,%s,%s,%s,%.2f,%s,\"%s\"\n",
                $order->order_number,
                $order->user->name,
                $order->user->email,
                $this->getStatusLabel($order->status),
                $order->total_amount,
                $order->created_at->format('d/m/Y H:i'),
                $products
            );
        }

        return response()->streamDownload(function() use ($csvData) {
            echo $csvData;
        }, 'reporte_ventas_' . $this->startDate . '_' . $this->endDate . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function render()
    {
        return view('livewire.reportes-ventas')->layout('layouts.app');
    }
}
