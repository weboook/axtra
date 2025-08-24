<?php

namespace App\Livewire\Admin\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductCreate extends Component
{
    use WithFileUploads;

    public $name = '';
    public $description = '';
    public $category = '';
    public $product_type = '';
    public $price = 0;
    public $manage_stock = false;
    public $stock_quantity = 0;
    public $low_stock_threshold = 5;
    public $image;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|in:food,drinks,equipment,experience',
        'product_type' => 'required|in:upsell,addon',
        'price' => 'required|numeric|min:0',
        'manage_stock' => 'boolean',
        'stock_quantity' => 'required_if:manage_stock,true|nullable|integer|min:0',
        'low_stock_threshold' => 'required_if:manage_stock,true|nullable|integer|min:0',
        'image' => 'nullable|image|max:2048',
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        $this->category = 'food';
        $this->product_type = 'upsell';
    }

    public function updatedManageStock()
    {
        if (!$this->manage_stock) {
            $this->stock_quantity = 0;
            $this->low_stock_threshold = 5;
        }
    }

    public function save()
    {
        $this->validate();

        $productData = [
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'product_type' => $this->product_type,
            'price' => $this->price,
            'manage_stock' => $this->manage_stock,
            'stock_quantity' => $this->manage_stock ? $this->stock_quantity : null,
            'low_stock_threshold' => $this->manage_stock ? $this->low_stock_threshold : null,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            $productData['image'] = $this->image->store('products', 'public');
        }

        Product::create($productData);

        session()->flash('success', 'Product created successfully.');
        $this->dispatch('item-created');
        $this->dispatch('closeModals');
    }

    public function cancel()
    {
        $this->dispatch('closeModals');
    }

    public function render()
    {
        return view('livewire.admin.products.product-create');
    }
}