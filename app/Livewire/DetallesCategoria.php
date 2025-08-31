<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class DetallesCategoria extends Component
{
    public $categoria;
    public $productos;

    public function mount($categoria = null)
    {
        $this->categoria = $categoria;
        $this->loadProductos();
    }

    public function loadProductos()
    {
        if ($this->categoria) {
            $this->productos = Product::where('categoria', $this->categoria)->get();
        } else {
            // Si no hay categoría, mostrar algunos productos de ejemplo
            $this->productos = Product::take(8)->get();
        }
    }

    public function render()
    {
        return view('livewire.detalles-categoria')->layout('layouts.app');
    }
}
