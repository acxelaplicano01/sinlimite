<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductList extends Component
{
    public $products;
    public $selectedId = null;
    public $showModal = false;
    public $viewMode = 'cards'; // 'cards' o 'table'
    public $categoria = null; // Para filtrar por categoría

    protected $listeners = ['productUpdated' => 'refreshProducts', 'productSaved' => 'handleProductSaved'];

    public function mount($categoria = null)
    {
        $this->categoria = $categoria;
        $this->refreshProducts();
    }

    public function refreshProducts()
    {
        if ($this->categoria) {
            $this->products = Product::where('categoria', $this->categoria)->get();
        } else {
            $this->products = Product::all();
        }
    }

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'cards' ? 'table' : 'cards';
    }

    public function create()
    {
        $this->selectedId = null;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->selectedId = $id;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedId = null;
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        $this->refreshProducts();
        session()->flash('message', 'Producto eliminado correctamente.');
    }

    public function handleProductSaved()
    {
        $this->showModal = false;
        $this->selectedId = null;
        $this->refreshProducts();
    }

    public function render()
    {
        return view('livewire.product-list')->layout('layouts.app');
    }
}
