<?php

namespace App\Livewire\Admin\Levels;

use App\Models\Level;
use App\Models\Achievement;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class LevelsIndex extends Component
{
    use WithPagination;

    // Search and filtering
    public $search = '';
    public $sortBy = 'sort_order';
    public $sortDirection = 'asc';
    public $showInactive = false;
    public $perPage = 15;
    
    // Bulk actions
    public $selectedLevels = [];
    public $bulkAction = '';
    
    // Modals
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDetailModal = false;
    
    // Selected level for actions
    public $selectedLevel = null;
    
    // Create/Edit form fields
    public $form = [
        'name' => '',
        'description' => '',
        'points_required' => '',
        'sort_order' => '',
        'color' => '#3b82f6',
        'icon' => 'fas fa-star',
        'benefits' => [],
        'achievements' => [],
        'is_active' => true,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'sort_order'],
        'sortDirection' => ['except' => 'asc'],
        'showInactive' => ['except' => false],
    ];

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
        $this->resetPage();
    }

    public function showCreateLevel()
    {
        $this->resetForm();
        $this->form['sort_order'] = Level::count() + 1;
        $this->showCreateModal = true;
    }

    public function showEditLevel($levelId)
    {
        $this->selectedLevel = Level::findOrFail($levelId);
        $this->form = [
            'name' => $this->selectedLevel->name,
            'description' => $this->selectedLevel->description,
            'points_required' => $this->selectedLevel->points_required,
            'sort_order' => $this->selectedLevel->sort_order,
            'color' => $this->selectedLevel->color ?? '#3b82f6',
            'icon' => $this->selectedLevel->icon ?? 'fas fa-star',
            'benefits' => $this->selectedLevel->benefits ?? [],
            'achievements' => $this->selectedLevel->achievements ?? [],
            'is_active' => $this->selectedLevel->is_active,
        ];
        $this->showEditModal = true;
    }

    public function showLevelDetail($levelId)
    {
        $this->selectedLevel = Level::with(['users', 'userLevelProgress'])
                                   ->withCount('users')
                                   ->findOrFail($levelId);
        $this->showDetailModal = true;
    }

    public function createLevel()
    {
        $this->validate([
            'form.name' => 'required|string|max:255|unique:levels,name',
            'form.description' => 'nullable|string|max:1000',
            'form.points_required' => 'required|integer|min:0|unique:levels,points_required',
            'form.sort_order' => 'required|integer|min:1',
            'form.color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'form.icon' => 'required|string|max:50',
        ]);

        Level::create([
            'name' => $this->form['name'],
            'slug' => str($this->form['name'])->slug(),
            'description' => $this->form['description'],
            'points_required' => $this->form['points_required'],
            'sort_order' => $this->form['sort_order'],
            'color' => $this->form['color'],
            'icon' => $this->form['icon'],
            'benefits' => $this->form['benefits'] ?? [],
            'achievements' => $this->form['achievements'] ?? [],
            'is_active' => $this->form['is_active'],
        ]);

        session()->flash('success', "Level '{$this->form['name']}' created successfully.");
        $this->closeModals();
    }

    public function updateLevel()
    {
        $this->validate([
            'form.name' => 'required|string|max:255|unique:levels,name,' . $this->selectedLevel->id,
            'form.description' => 'nullable|string|max:1000',
            'form.points_required' => 'required|integer|min:0|unique:levels,points_required,' . $this->selectedLevel->id,
            'form.sort_order' => 'required|integer|min:1',
            'form.color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'form.icon' => 'required|string|max:50',
        ]);

        $this->selectedLevel->update([
            'name' => $this->form['name'],
            'slug' => str($this->form['name'])->slug(),
            'description' => $this->form['description'],
            'points_required' => $this->form['points_required'],
            'sort_order' => $this->form['sort_order'],
            'color' => $this->form['color'],
            'icon' => $this->form['icon'],
            'benefits' => $this->form['benefits'] ?? [],
            'achievements' => $this->form['achievements'] ?? [],
            'is_active' => $this->form['is_active'],
        ]);

        session()->flash('success', "Level '{$this->form['name']}' updated successfully.");
        $this->closeModals();
    }

    public function toggleLevelStatus($levelId)
    {
        $level = Level::findOrFail($levelId);
        $level->update(['is_active' => !$level->is_active]);
        
        $status = $level->is_active ? 'activated' : 'deactivated';
        session()->flash('success', "Level '{$level->name}' has been {$status} successfully.");
    }

    public function deleteLevel($levelId)
    {
        $level = Level::findOrFail($levelId);
        
        // Check if level has users
        if ($level->users()->count() > 0) {
            session()->flash('error', "Cannot delete level '{$level->name}' as it has users assigned to it.");
            return;
        }
        
        $levelName = $level->name;
        $level->delete();
        session()->flash('success', "Level '{$levelName}' deleted successfully.");
    }

    public function duplicateLevel($levelId)
    {
        $original = Level::findOrFail($levelId);
        $duplicate = $original->replicate();
        $duplicate->name = $original->name . ' (Copy)';
        $duplicate->points_required = $original->points_required + 100; // Adjust points
        $duplicate->sort_order = Level::count() + 1;
        $duplicate->is_active = false;
        $duplicate->save();
        
        session()->flash('success', "Level duplicated successfully as '{$duplicate->name}'.");
    }

    public function reorderLevels($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Level::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        
        session()->flash('success', 'Level order updated successfully.');
    }

    public function bulkAction()
    {
        if (empty($this->selectedLevels) || !$this->bulkAction) return;
        
        $levels = Level::whereIn('id', $this->selectedLevels)->get();
        $count = 0;
        
        foreach ($levels as $level) {
            switch ($this->bulkAction) {
                case 'activate':
                    if (!$level->is_active) {
                        $level->update(['is_active' => true]);
                        $count++;
                    }
                    break;
                case 'deactivate':
                    if ($level->is_active) {
                        $level->update(['is_active' => false]);
                        $count++;
                    }
                    break;
                case 'delete':
                    if ($level->users()->count() === 0) {
                        $level->delete();
                        $count++;
                    }
                    break;
            }
        }
        
        session()->flash('success', "Bulk action applied to {$count} levels.");
        $this->selectedLevels = [];
        $this->bulkAction = '';
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDetailModal = false;
        $this->selectedLevel = null;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->form = [
            'name' => '',
            'description' => '',
            'points_required' => '',
            'sort_order' => '',
            'color' => '#3b82f6',
            'icon' => 'fas fa-star',
            'benefits' => [],
            'achievements' => [],
            'is_active' => true,
        ];
    }

    #[On('level-created')]
    #[On('level-updated')]
    #[On('closeModals')]
    public function refreshList()
    {
        $this->closeModals();
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
            ->paginate($this->perPage);

        $stats = [
            'total' => Level::count(),
            'active' => Level::where('is_active', true)->count(),
            'inactive' => Level::where('is_active', false)->count(),
            'users_with_levels' => \App\Models\UserLevelProgress::distinct('user_id')->count(),
        ];

        $achievements = Achievement::active()->orderBy('order')->get();

        return view('livewire.admin.levels.levels-index', compact('levels', 'stats', 'achievements'));
    }
}
