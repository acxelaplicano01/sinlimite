<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class HistorialPedidos extends Component
{
    public $orders = [];
    public $filter = 'all'; // all, pending, delivered, cancelled

    public function mount()
    {
        $this->loadOrders();
    }

    public function loadOrders()
    {
        $userId = Auth::id();

        if (!$userId) {
            $this->orders = collect();
            return;
        }

        $query = Order::with(['items.product'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc');

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        $this->orders = $query->get();
    }

    public function filterOrders($status)
    {
        $this->filter = $status;
        $this->loadOrders();
    }

    public function cancelOrder($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($order) {
            $order->update(['status' => 'cancelled']);
            $this->loadOrders();
            session()->flash('orders_success', "Pedido #{$order->order_number} cancelado exitosamente.");
        } else {
            session()->flash('orders_error', 'No se pudo cancelar el pedido.');
        }
    }

    public function getStatusBadgeClass($status)
    {
        return match($status) {
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'confirmed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'paid' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
            'shipped' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
        };
    }

    public function getStatusLabel($status)
    {
        return match($status) {
            'pending' => 'Pendiente',
            'delivered' => 'Entregado',
            'cancelled' => 'Cancelado',
            'confirmed' => 'Confirmado',
            'paid' => 'Pagado',
            'shipped' => 'Enviado',
            default => ucfirst($status),
        };
    }

    public function render()
    {
        return view('livewire.historial-pedidos')->layout('layouts.app');
    }
}
