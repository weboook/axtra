<?php

namespace App\Livewire\Admin\Lanes;

use App\Models\Lane;
use Livewire\Component;

class LaneCreate extends Component
{
    public $name = '';
    public $description = '';
    public $is_active = true;
    public $maintenance_status = 'operational';
    public $capacity = 2;
    public $hourly_rate = 0;
    public $equipment_included = [];
    
    public $availableEquipment = [
        'axes' => 'Throwing Axes',
        'safety_gear' => 'Safety Gear',
        'targets' => 'Wooden Targets',
        'coaching' => 'Professional Coaching',
        'scorecards' => 'Score Cards',
        'first_aid' => 'First Aid Kit',
    ];

    protected $rules = [
        'name' => 'required|string|max:255|unique:lanes,name',
        'description' => 'nullable|string',
        'is_active' => 'boolean',
        'maintenance_status' => 'required|in:operational,maintenance,damaged',
        'capacity' => 'required|integer|min:1|max:10',
        'hourly_rate' => 'required|numeric|min:0',
        'equipment_included' => 'array',
    ];

    public function save()
    {
        $this->validate();

        Lane::create([
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'maintenance_status' => $this->maintenance_status,
            'capacity' => $this->capacity,
            'hourly_rate' => $this->hourly_rate,
            'equipment_included' => $this->equipment_included,
        ]);

        session()->flash('success', 'Lane created successfully.');
        $this->dispatch('lane-created');
        $this->dispatch('closeModals');
    }

    public function cancel()
    {
        $this->dispatch('closeModals');
    }

    public function render()
    {
        return view('livewire.admin.lanes.lane-create');
    }
}
