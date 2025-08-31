<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Favoritos extends Component
{
    public $favorites = [];

    protected $listeners = ['favoritesUpdated' => 'loadFavorites'];

    public function mount()
    {
        $this->loadFavorites();
    }

    public function loadFavorites()
    {
        $userId = Auth::id();

        if (!$userId) {
            $this->favorites = collect();
            return;
        }

        $this->favorites = Favorite::with('product')
            ->where('user_id', $userId)
            ->get();
    }

    public function removeFavorite($favoriteId)
    {
        $favorite = Favorite::find($favoriteId);
        if ($favorite) {
            $favorite->delete();
            $this->loadFavorites();
            session()->flash('favorite_success', 'Producto eliminado de favoritos.');
            $this->dispatch('favoritesUpdated');
        }
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product) {
            session()->flash('error', 'Producto no encontrado.');
            return;
        }

        $userId = Auth::id();

        // Verificar si el producto ya está en el carrito
        $existingItem = CartItem::where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += 1;
            $existingItem->save();
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1,
                'price' => $product->precio,
            ]);
        }

        session()->flash('cart_success', '¡Producto añadido al carrito!');
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.favoritos')->layout('layouts.app');
    }
}
