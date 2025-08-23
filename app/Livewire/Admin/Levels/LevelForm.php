<?php

namespace App\Livewire\Admin\Levels;

use App\Models\Level;
use Livewire\Component;
use Illuminate\Support\Str;

class LevelForm extends Component
{
    public $levelId = null;
    public $name = '';
    public $slug = '';
    public $description = '';
    public $points_required = 0;
    public $sort_order = 0;
    public $color = '#6B7280';
    public $icon = '';
    public $benefits = [];
    public $achievements = [];
    public $is_active = true;
    
    // Form helpers
    public $newBenefit = '';
    public $newAchievement = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|alpha_dash',
        'description' => 'nullable|string',
        'points_required' => 'required|integer|min:0',
        'sort_order' => 'required|integer|min:0',
        'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/',
        'icon' => 'nullable|string|max:255',
        'is_active' => 'boolean',
    ];

    protected $listeners = [
        'editLevel' => 'loadLevel',
        'createLevel' => 'resetForm'
    ];

    public function mount($level = null)
    {
        if ($level) {
            $this->loadLevel($level);
        } else {
            $this->resetForm();
        }
    }

    public function loadLevel($level)
    {
        if (is_numeric($level)) {
            $level = Level::findOrFail($level);
        }

        $this->levelId = $level->id;
        $this->name = $level->name;
        $this->slug = $level->slug;
        $this->description = $level->description;
        $this->points_required = $level->points_required;
        $this->sort_order = $level->sort_order;
        $this->color = $level->color;
        $this->icon = $level->icon;
        $this->benefits = $level->benefits ?? [];
        $this->achievements = $level->achievements ?? [];
        $this->is_active = $level->is_active;
    }

    public function resetForm()
    {
        $this->levelId = null;
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->points_required = 0;
        $this->sort_order = Level::max('sort_order') + 1 ?? 0;
        $this->color = '#6B7280';
        $this->icon = '';
        $this->benefits = [];
        $this->achievements = [];
        $this->is_active = true;
        $this->newBenefit = '';
        $this->newAchievement = '';
    }

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function addBenefit()
    {
        if (!empty(trim($this->newBenefit))) {
            $this->benefits[] = trim($this->newBenefit);
            $this->newBenefit = '';
        }
    }

    public function removeBenefit($index)
    {
        unset($this->benefits[$index]);
        $this->benefits = array_values($this->benefits);
    }

    public function addAchievement()
    {
        if (!empty(trim($this->newAchievement))) {
            $this->achievements[] = trim($this->newAchievement);
            $this->newAchievement = '';
        }
    }

    public function removeAchievement($index)
    {
        unset($this->achievements[$index]);
        $this->achievements = array_values($this->achievements);
    }

    public function save()
    {
        $this->validate();

        // Check for unique slug
        $existingLevel = Level::where('slug', $this->slug)
                             ->when($this->levelId, function ($query) {
                                 $query->where('id', '!=', $this->levelId);
                             })
                             ->first();

        if ($existingLevel) {
            $this->addError('slug', 'This slug is already taken.');
            return;
        }

        // Check for unique points_required
        $existingPoints = Level::where('points_required', $this->points_required)
                              ->when($this->levelId, function ($query) {
                                  $query->where('id', '!=', $this->levelId);
                              })
                              ->first();

        if ($existingPoints) {
            $this->addError('points_required', 'Another level already requires this number of points.');
            return;
        }

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'points_required' => $this->points_required,
            'sort_order' => $this->sort_order,
            'color' => $this->color,
            'icon' => $this->icon,
            'benefits' => $this->benefits,
            'achievements' => $this->achievements,
            'is_active' => $this->is_active,
        ];

        if ($this->levelId) {
            Level::findOrFail($this->levelId)->update($data);
            $message = 'Level updated successfully';
        } else {
            Level::create($data);
            $message = 'Level created successfully';
        }

        session()->flash('message', $message);
        $this->dispatch('levelSaved');
        $this->resetForm();
    }

    public function render()
    {
        return view('livewire.admin.levels.level-form');
    }
}
