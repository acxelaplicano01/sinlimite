<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Carrito extends Component
{
    public $cartItems = [];
    public $total = 0;
    public $showPaymentModal = false;
    public $selectedPaymentMethod = '';
    public $savedPaymentMethod = null;

    protected $listeners = ['cartUpdated' => 'loadCartItems'];

    public function mount()
    {
        $this->loadCartItems();
    }

    public function loadCartItems()
    {
        $userId = Auth::id();

        if (!$userId) {
            $this->cartItems = collect();
            $this->total = 0;
            return;
        }

        $this->cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = $this->cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });
    }

    public function updateQuantity($itemId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeItem($itemId);
            return;
        }

        $item = CartItem::find($itemId);
        if ($item) {
            $item->quantity = $quantity;
            $item->save();
            $this->loadCartItems();
            session()->flash('cart_success', 'Cantidad actualizada.');
        }
    }

    public function removeItem($itemId)
    {
        $item = CartItem::find($itemId);
        if ($item) {
            $item->delete();
            $this->loadCartItems();
            session()->flash('cart_success', 'Producto eliminado del carrito.');
        }
    }

    public function clearCart()
    {
        $userId = Auth::id();

        if ($userId) {
            CartItem::where('user_id', $userId)->delete();
        }

        $this->loadCartItems();
        session()->flash('cart_success', 'Carrito vaciado.');
    }

    public function createOrder()
    {
        $userId = Auth::id();

        if (!$userId || $this->cartItems->isEmpty()) {
            session()->flash('cart_error', 'No puedes crear un pedido con el carrito vacío.');
            return;
        }

        // Verificar si se ha seleccionado un método de pago
        if (!$this->savedPaymentMethod) {
            session()->flash('cart_error', 'Por favor selecciona un método de pago antes de crear el pedido.');
            $this->openPaymentModal();
            return;
        }

        try {
            // Crear el pedido
            $order = Order::create([
                'user_id' => $userId,
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'total_amount' => $this->total,
                'tax_amount' => 0,
                'shipping_amount' => 0,
                'shipping_address' => [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'address' => 'Por definir',
                    'city' => 'Por definir',
                    'country' => 'Por definir',
                    'zip' => 'Por definir'
                ],
                'payment_method' => $this->savedPaymentMethod,
                'payment_status' => 'pending',
            ]);

            // Crear los items del pedido
            foreach ($this->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->price,
                    'total_price' => $cartItem->quantity * $cartItem->price,
                    'color' => $cartItem->color,
                    'size' => $cartItem->size,
                    'product_snapshot' => [
                        'nombre' => $cartItem->product->nombre,
                        'descripcion' => $cartItem->product->descripcion,
                        'imagen' => $cartItem->product->imagen,
                        'categoria' => $cartItem->product->categoria,
                    ]
                ]);
            }

            // Limpiar el carrito
            CartItem::where('user_id', $userId)->delete();
            $this->loadCartItems();

            session()->flash('cart_success', "¡Pedido #{$order->order_number} creado exitosamente!");
            
            // Redirigir al dashboard de pedidos
            return $this->redirectRoute('pedidos.dashboard');

        } catch (\Exception $e) {
            session()->flash('cart_error', 'Error al crear el pedido. Inténtalo de nuevo.');
        }
    }

    public function openPaymentModal()
    {
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedPaymentMethod = '';
    }

    public function selectPaymentMethod($method)
    {
        $this->selectedPaymentMethod = $method;
    }

    public function processPayment()
    {
        if (!$this->selectedPaymentMethod) {
            session()->flash('cart_error', 'Por favor selecciona un método de pago.');
            return;
        }

        // Guardar el método de pago seleccionado
        $this->savedPaymentMethod = $this->selectedPaymentMethod;
        $this->closePaymentModal();
        
        session()->flash('cart_success', "Método de pago seleccionado: {$this->getPaymentMethodName()}. Ahora puedes crear tu pedido.");
    }

    private function getPaymentMethodName()
    {
        $methods = [
            'transferencia' => 'Transferencia Bancaria',
            'pago_movil' => 'Pago Móvil',
            'efectivo' => 'Efectivo'
        ];

        return $methods[$this->selectedPaymentMethod] ?? $this->selectedPaymentMethod;
    }

    public function render()
    {
        return view('livewire.carrito')->layout('layouts.app');
    }
}
