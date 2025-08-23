<?php

namespace App\Livewire\Admin\Levels;

use App\Models\Level;
use Livewire\Component;
use Livewire\WithPagination;

class LevelsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'sort_order';
    public $sortDirection = 'asc';
    public $showInactive = false;
    public $selectedLevel = null;
    public $showModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'sort_order'],
        'sortDirection' => ['except' => 'asc'],
        'showInactive' => ['except' => false],
    ];

    public function mount()
    {
        // Initialize component
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function createLevel()
    {
        $this->selectedLevel = null;
        $this->showModal = true;
    }

    public function editLevel($levelId)
    {
        $this->selectedLevel = Level::findOrFail($levelId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedLevel = null;
    }

    public function toggleStatus($levelId)
    {
        $level = Level::findOrFail($levelId);
        $level->update(['is_active' => !$level->is_active]);
        
        session()->flash('message', $level->is_active ? 'Level activated' : 'Level deactivated');
    }

    public function deleteLevel($levelId)
    {
        $level = Level::findOrFail($levelId);
        
        // Check if level has users
        if ($level->users()->count() > 0) {
            session()->flash('error', 'Cannot delete level with associated users');
            return;
        }
        
        $level->delete();
        session()->flash('message', 'Level deleted successfully');
    }

    public function reorderLevels($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Level::where('id', $id)->update(['sort_order' => $index]);
        }
        
        session()->flash('message', 'Level order updated');
    }

    public function render()
    {
        $levels = Level::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when(!$this->showInactive, function ($query) {
                $query->where('is_active', true);
            })
            ->withCount('users')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        return view('livewire.admin.levels.levels-index', [
            'levels' => $levels
        ]);
    }
}
