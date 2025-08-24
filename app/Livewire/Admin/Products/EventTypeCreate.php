<?php

namespace App\Livewire\Admin\Products;

use App\Models\EventType;
use Livewire\Component;

class EventTypeCreate extends Component
{
    public $name = '';
    public $slug = '';
    public $description = '';
    public $icon = 'fas fa-star';
    public $color = '#6c757d';
    public $allows_custom_input = false;
    public $is_active = true;
    public $sort_order = 0;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:event_types,slug',
        'description' => 'nullable|string',
        'icon' => 'required|string|max:255',
        'color' => 'required|string|max:7',
        'allows_custom_input' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'required|integer|min:0',
    ];

    public function mount()
    {
        $this->sort_order = EventType::max('sort_order') + 1;
    }

    public function updatedName()
    {
        $this->slug = \Illuminate\Support\Str::slug($this->name);
    }

    public function save()
    {
        $this->validate();

        EventType::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon' => $this->icon,
            'color' => $this->color,
            'allows_custom_input' => $this->allows_custom_input,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ]);

        session()->flash('success', 'Event type created successfully.');
        $this->dispatch('item-created');
        $this->dispatch('closeModals');
    }

    public function cancel()
    {
        $this->dispatch('closeModals');
    }

    public function render()
    {
        $commonIcons = [
            'fas fa-birthday-cake' => 'Birthday',
            'fas fa-heart' => 'Anniversary',
            'fas fa-briefcase' => 'Corporate',
            'fas fa-users' => 'Team Building',
            'fas fa-graduation-cap' => 'Graduation',
            'fas fa-gift' => 'Special Event',
            'fas fa-star' => 'General',
            'fas fa-calendar-alt' => 'Scheduled',
            'fas fa-champagne-glasses' => 'Celebration',
            'fas fa-handshake' => 'Business Meeting',
        ];

        $commonColors = [
            '#c02425' => 'Red',
            '#28a745' => 'Green',
            '#007bff' => 'Blue',
            '#ffc107' => 'Yellow',
            '#17a2b8' => 'Cyan',
            '#6f42c1' => 'Purple',
            '#e83e8c' => 'Pink',
            '#fd7e14' => 'Orange',
            '#6c757d' => 'Gray',
            '#343a40' => 'Dark',
        ];

        return view('livewire.admin.products.event-type-create', compact('commonIcons', 'commonColors'));
    }
}