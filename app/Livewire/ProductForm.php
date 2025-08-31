<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductForm extends Component
{
    use WithFileUploads;

    public $nombre, $categoria, $precio, $descripcion, $color, $talla, $reviews, $linkfacebook, $imagen;
    public $productId, $editMode = false, $existingImage;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'categoria' => 'required|string|max:255',
        'precio' => 'required|numeric|min:0',
        'descripcion' => 'nullable|string',
        'color' => 'nullable|string|max:100',
        'talla' => 'nullable|string|max:50',
        'reviews' => 'nullable|string',
        'linkfacebook' => 'nullable|url',
        'imagen' => 'nullable|image|max:2048',
    ];

    public function mount($productId = null)
    {
        if ($productId) {
            $this->loadProduct($productId);
        }
    }

    public function loadProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $id;
        $this->nombre = $product->nombre;
        $this->categoria = $product->categoria;
        $this->precio = $product->precio;
        $this->descripcion = $product->descripcion;
        $this->color = $product->color;
        $this->talla = $product->talla;
        $this->reviews = $product->reviews;
        $this->linkfacebook = $product->linkfacebook;
        $this->existingImage = $product->imagen;
        $this->editMode = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nombre' => $this->nombre,
            'categoria' => $this->categoria,
            'precio' => $this->precio,
            'descripcion' => $this->descripcion,
            'color' => $this->color,
            'talla' => $this->talla,
            'reviews' => $this->reviews,
            'linkfacebook' => $this->linkfacebook,
        ];

        if ($this->imagen) {
            // Eliminar imagen anterior si existe
            if ($this->editMode && $this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $data['imagen'] = $this->imagen->store('products', 'public');
        }

        if ($this->editMode) {
            Product::find($this->productId)->update($data);
            session()->flash('message', 'Producto actualizado correctamente.');
        } else {
            Product::create($data);
            session()->flash('message', 'Producto creado correctamente.');
        }

        $this->dispatch('productSaved');
        $this->reset();
    }

    public function cancel()
    {
        $this->dispatch('productSaved');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.product-form')->layout('layouts.app');
    }
}
