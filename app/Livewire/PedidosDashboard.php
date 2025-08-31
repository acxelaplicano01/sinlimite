<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class PedidosDashboard extends Component
{
    use WithPagination;

    public $selectedOrder = null;
    public $statusFilter = 'all';
    
    protected $listeners = ['orderUpdated' => '$refresh'];

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with(['items.product', 'user'])->find($orderId);
    }

    public function closeOrderDetails()
    {
        $this->selectedOrder = null;
    }

    public function confirmOrder($orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->status === 'pending') {
            $order->update([
                'status' => 'confirmed',
                'confirmed_at' => now()
            ]);
            session()->flash('success', "Pedido #{$order->order_number} confirmado exitosamente.");
            $this->dispatch('orderUpdated');
        }
    }

    public function markAsPaid($orderId)
    {
        $order = Order::find($orderId);
        if ($order && in_array($order->status, ['confirmed', 'pending'])) {
            $order->update([
                'status' => 'paid',
                'payment_status' => 'paid',
                'paid_at' => now()
            ]);
            session()->flash('success', "Pedido #{$order->order_number} marcado como pagado.");
            $this->dispatch('orderUpdated');
        }
    }

    public function markAsShipped($orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->status === 'paid') {
            $order->update([
                'status' => 'shipped',
                'shipped_at' => now()
            ]);
            session()->flash('success', "Pedido #{$order->order_number} marcado como enviado.");
            $this->dispatch('orderUpdated');
        }
    }

    public function markAsDelivered($orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->status === 'shipped') {
            $order->update([
                'status' => 'delivered',
                'delivered_at' => now()
            ]);
            session()->flash('success', "Pedido #{$order->order_number} marcado como entregado.");
            $this->dispatch('orderUpdated');
        }
    }

    public function cancelOrder($orderId)
    {
        $order = Order::find($orderId);
        if ($order && !in_array($order->status, ['delivered', 'cancelled'])) {
            $order->update(['status' => 'cancelled']);
            session()->flash('success', "Pedido #{$order->order_number} cancelado.");
            $this->dispatch('orderUpdated');
        }
    }

    public function render()
    {
        $query = Order::with(['items.product', 'user'])->latest();

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $orders = $query->paginate(10);

        return view('livewire.pedidos-dashboard', compact('orders'))->layout('layouts.app');
    }
}
