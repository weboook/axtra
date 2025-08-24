<?php

namespace App\Livewire\Admin\Products;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class ServiceCreate extends Component
{
    use WithFileUploads;

    public $name = '';
    public $description = '';
    public $category = '';
    public $duration_hours = 2;
    public $min_players = 1;
    public $max_players = 2;
    public $price = 0;
    public $capacity_per_slot = 55;
    public $image;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|in:axe_throwing,axe_throwing_making,axe_making,private_events',
        'duration_hours' => 'required|numeric|min:0.5|max:24',
        'min_players' => 'required|integer|min:1|max:100',
        'max_players' => 'required|integer|min:1|max:100',
        'price' => 'required|numeric|min:0',
        'capacity_per_slot' => 'required|integer|min:1|max:200',
        'image' => 'nullable|image|max:2048',
        'is_active' => 'boolean',
    ];

    public function mount()
    {
        $this->category = 'axe_throwing';
    }

    public function updatedMinPlayers()
    {
        if ($this->max_players < $this->min_players) {
            $this->max_players = $this->min_players;
        }
    }

    public function updatedMaxPlayers()
    {
        if ($this->min_players > $this->max_players) {
            $this->min_players = $this->max_players;
        }
    }

    public function save()
    {
        $this->validate();

        $serviceData = [
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'duration_hours' => $this->duration_hours,
            'min_players' => $this->min_players,
            'max_players' => $this->max_players,
            'price' => $this->price,
            'capacity_per_slot' => $this->capacity_per_slot,
            'is_active' => $this->is_active,
        ];

        if ($this->image) {
            $serviceData['image'] = $this->image->store('services', 'public');
        }

        Service::create($serviceData);

        session()->flash('success', 'Service created successfully.');
        $this->dispatch('item-created');
        $this->dispatch('closeModals');
    }

    public function cancel()
    {
        $this->dispatch('closeModals');
    }

    public function render()
    {
        return view('livewire.admin.products.service-create');
    }
}