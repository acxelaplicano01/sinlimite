<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DetalleProducto extends Component
{
    public $productId;
    public $product;
    public $relatedProducts;
    public $selectedColor;
    public $selectedSize;
    public $quantity = 1;
    public $isFavorite = false;

    public function mount($id = null)
    {
        $this->productId = $id;
        $this->loadProduct();
        $this->loadRelatedProducts();
        $this->checkIfFavorite();
    }

    public function loadProduct()
    {
        if ($this->productId) {
            $this->product = Product::find($this->productId);
        } else {
            // Si no se proporciona ID, obtener el primer producto o crear uno de ejemplo
            $this->product = Product::first() ?? $this->createExampleProduct();
        }
    }

    public function checkIfFavorite()
    {
        if (!$this->product || !Auth::check()) {
            $this->isFavorite = false;
            return;
        }

        $userId = Auth::id();

        $favorite = Favorite::where('product_id', $this->product->id)
            ->where('user_id', $userId)
            ->exists();

        $this->isFavorite = $favorite;
    }

    public function addToCart()
    {
        // Solo ejecutar si el usuario está autenticado
        if (!Auth::check()) {
            return;
        }

        if (!$this->product) {
            session()->flash('error', 'Producto no encontrado.');
            return;
        }

        $userId = Auth::id();

        // Verificar si el producto ya está en el carrito
        $existingItem = CartItem::where('product_id', $this->product->id)
            ->where('user_id', $userId)
            ->where('color', $this->selectedColor)
            ->where('size', $this->selectedSize)
            ->first();

        if ($existingItem) {
            // Actualizar cantidad
            $existingItem->quantity += $this->quantity;
            $existingItem->save();
        } else {
            // Crear nuevo item en el carrito
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $this->product->id,
                'quantity' => $this->quantity,
                'price' => $this->product->precio,
                'color' => $this->selectedColor,
                'size' => $this->selectedSize,
            ]);
        }

        session()->flash('cart_success', '¡Producto añadido al carrito!');
        
        // Emitir evento para actualizar contador del carrito si existe
        $this->dispatch('cartUpdated');
    }

    public function toggleFavorite()
    {
        // Solo ejecutar si el usuario está autenticado
        if (!Auth::check()) {
            return;
        }

        if (!$this->product) return;

        $userId = Auth::id();

        $favorite = Favorite::where('product_id', $this->product->id)
            ->where('user_id', $userId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $this->isFavorite = false;
            session()->flash('favorite_success', 'Producto eliminado de favoritos.');
        } else {
            Favorite::create([
                'user_id' => $userId,
                'product_id' => $this->product->id,
            ]);
            $this->isFavorite = true;
            session()->flash('favorite_success', '¡Producto añadido a favoritos!');
        }

        // Emitir evento para actualizar contador de favoritos si existe
        $this->dispatch('favoritesUpdated');
    }

    public function loadRelatedProducts()
    {
        if ($this->product) {
            // Obtener productos relacionados de la misma categoría, excluyendo el producto actual
            $this->relatedProducts = Product::where('categoria', $this->product->categoria)
                ->where('id', '!=', $this->product->id)
                ->take(4)
                ->get();

            // Si no hay suficientes productos relacionados, completar con otros productos
            if ($this->relatedProducts->count() < 4) {
                $additionalProducts = Product::where('id', '!=', $this->product->id)
                    ->whereNotIn('id', $this->relatedProducts->pluck('id'))
                    ->take(4 - $this->relatedProducts->count())
                    ->get();
                
                $this->relatedProducts = $this->relatedProducts->merge($additionalProducts);
            }
        } else {
            $this->relatedProducts = collect();
        }
    }

    private function createExampleProduct()
    {
        return (object) [
            'id' => 0,
            'nombre' => 'Producto de Ejemplo',
            'categoria' => 'SIN LÍMITE',
            'precio' => 29.99,
            'descripcion' => 'Este es un producto de ejemplo para mostrar el diseño de la página de detalles.',
            'color' => 'negro,blanco,azul',
            'talla' => 'S,M,L,XL',
            'reviews' => 4,
            'linkfacebook' => '#',
            'imagen' => 'https://dummyimage.com/400x400'
        ];
    }

    public function render()
    {
        return view('livewire.detalle-producto')->layout('layouts.app');
    }
}
