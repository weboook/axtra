<?php

namespace App\Livewire\Admin\Achievements;

use App\Models\Achievement;
use App\Models\UserAchievement;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class AchievementsIndex extends Component
{
    use WithPagination;

    // Search and filtering
    public $search = '';
    public $typeFilter = '';
    public $statusFilter = '';
    public $sortBy = 'order';
    public $sortDirection = 'asc';
    public $perPage = 15;
    
    // Bulk actions
    public $selectedAchievements = [];
    public $bulkAction = '';
    
    // Modals
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDetailModal = false;
    
    // Selected achievement for actions
    public $selectedAchievement = null;
    
    // Create/Edit form fields
    public $form = [
        'name' => '',
        'description' => '',
        'type' => 'milestone',
        'requirements' => [],
        'points_reward' => 100,
        'icon' => 'fas fa-trophy',
        'color' => '#ffd700',
        'order' => 1,
        'is_hidden' => false,
        'is_active' => true,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'sortBy' => ['except' => 'order'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
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

    public function showCreateAchievement()
    {
        $this->resetForm();
        $this->form['order'] = Achievement::count() + 1;
        $this->showCreateModal = true;
    }

    public function showEditAchievement($achievementId)
    {
        $this->selectedAchievement = Achievement::findOrFail($achievementId);
        $this->form = [
            'name' => $this->selectedAchievement->name,
            'description' => $this->selectedAchievement->description,
            'type' => $this->selectedAchievement->type,
            'requirements' => $this->selectedAchievement->requirements ?? [],
            'points_reward' => $this->selectedAchievement->points_reward,
            'icon' => $this->selectedAchievement->icon ?? 'fas fa-trophy',
            'color' => $this->selectedAchievement->color ?? '#ffd700',
            'order' => $this->selectedAchievement->order,
            'is_hidden' => $this->selectedAchievement->is_hidden,
            'is_active' => $this->selectedAchievement->is_active,
        ];
        $this->showEditModal = true;
    }

    public function showAchievementDetail($achievementId)
    {
        $this->selectedAchievement = Achievement::with(['userAchievements.user'])
                                                ->withCount('userAchievements')
                                                ->findOrFail($achievementId);
        $this->showDetailModal = true;
    }

    public function createAchievement()
    {
        $this->validate([
            'form.name' => 'required|string|max:255|unique:achievements,name',
            'form.description' => 'required|string|max:1000',
            'form.type' => 'required|string|in:milestone,streak,total,special',
            'form.points_reward' => 'required|integer|min:1|max:10000',
            'form.icon' => 'required|string|max:50',
            'form.color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'form.order' => 'required|integer|min:1',
        ]);

        Achievement::create([
            'name' => $this->form['name'],
            'description' => $this->form['description'],
            'type' => $this->form['type'],
            'requirements' => $this->form['requirements'] ?? [],
            'points_reward' => $this->form['points_reward'],
            'icon' => $this->form['icon'],
            'color' => $this->form['color'],
            'order' => $this->form['order'],
            'is_hidden' => $this->form['is_hidden'],
            'is_active' => $this->form['is_active'],
        ]);

        session()->flash('success', "Achievement '{$this->form['name']}' created successfully.");
        $this->closeModals();
    }

    public function updateAchievement()
    {
        $this->validate([
            'form.name' => 'required|string|max:255|unique:achievements,name,' . $this->selectedAchievement->id,
            'form.description' => 'required|string|max:1000',
            'form.type' => 'required|string|in:milestone,streak,total,special',
            'form.points_reward' => 'required|integer|min:1|max:10000',
            'form.icon' => 'required|string|max:50',
            'form.color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'form.order' => 'required|integer|min:1',
        ]);

        $this->selectedAchievement->update([
            'name' => $this->form['name'],
            'description' => $this->form['description'],
            'type' => $this->form['type'],
            'requirements' => $this->form['requirements'] ?? [],
            'points_reward' => $this->form['points_reward'],
            'icon' => $this->form['icon'],
            'color' => $this->form['color'],
            'order' => $this->form['order'],
            'is_hidden' => $this->form['is_hidden'],
            'is_active' => $this->form['is_active'],
        ]);

        session()->flash('success', "Achievement '{$this->form['name']}' updated successfully.");
        $this->closeModals();
    }

    public function toggleAchievementStatus($achievementId)
    {
        $achievement = Achievement::findOrFail($achievementId);
        $achievement->update(['is_active' => !$achievement->is_active]);
        
        $status = $achievement->is_active ? 'activated' : 'deactivated';
        session()->flash('success', "Achievement '{$achievement->name}' has been {$status} successfully.");
    }

    public function toggleAchievementVisibility($achievementId)
    {
        $achievement = Achievement::findOrFail($achievementId);
        $achievement->update(['is_hidden' => !$achievement->is_hidden]);
        
        $visibility = $achievement->is_hidden ? 'hidden' : 'visible';
        session()->flash('success', "Achievement '{$achievement->name}' is now {$visibility}.");
    }

    public function deleteAchievement($achievementId)
    {
        $achievement = Achievement::findOrFail($achievementId);
        
        // Check if achievement has been earned by users
        if ($achievement->userAchievements()->count() > 0) {
            session()->flash('error', "Cannot delete achievement '{$achievement->name}' as it has been earned by users.");
            return;
        }
        
        $achievementName = $achievement->name;
        $achievement->delete();
        session()->flash('success', "Achievement '{$achievementName}' deleted successfully.");
    }

    public function duplicateAchievement($achievementId)
    {
        $original = Achievement::findOrFail($achievementId);
        $duplicate = $original->replicate();
        $duplicate->name = $original->name . ' (Copy)';
        $duplicate->order = Achievement::count() + 1;
        $duplicate->is_active = false;
        $duplicate->save();
        
        session()->flash('success', "Achievement duplicated successfully as '{$duplicate->name}'.");
    }

    public function reorderAchievements($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Achievement::where('id', $id)->update(['order' => $index + 1]);
        }
        
        session()->flash('success', 'Achievement order updated successfully.');
    }

    public function bulkAction()
    {
        if (empty($this->selectedAchievements) || !$this->bulkAction) return;
        
        $achievements = Achievement::whereIn('id', $this->selectedAchievements)->get();
        $count = 0;
        
        foreach ($achievements as $achievement) {
            switch ($this->bulkAction) {
                case 'activate':
                    if (!$achievement->is_active) {
                        $achievement->update(['is_active' => true]);
                        $count++;
                    }
                    break;
                case 'deactivate':
                    if ($achievement->is_active) {
                        $achievement->update(['is_active' => false]);
                        $count++;
                    }
                    break;
                case 'show':
                    if ($achievement->is_hidden) {
                        $achievement->update(['is_hidden' => false]);
                        $count++;
                    }
                    break;
                case 'hide':
                    if (!$achievement->is_hidden) {
                        $achievement->update(['is_hidden' => true]);
                        $count++;
                    }
                    break;
                case 'delete':
                    if ($achievement->userAchievements()->count() === 0) {
                        $achievement->delete();
                        $count++;
                    }
                    break;
            }
        }
        
        session()->flash('success', "Bulk action applied to {$count} achievements.");
        $this->selectedAchievements = [];
        $this->bulkAction = '';
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDetailModal = false;
        $this->selectedAchievement = null;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->form = [
            'name' => '',
            'description' => '',
            'type' => 'milestone',
            'requirements' => [],
            'points_reward' => 100,
            'icon' => 'fas fa-trophy',
            'color' => '#ffd700',
            'order' => 1,
            'is_hidden' => false,
            'is_active' => true,
        ];
    }

    #[On('achievement-created')]
    #[On('achievement-updated')]
    #[On('closeModals')]
    public function refreshList()
    {
        $this->closeModals();
    }

    public function render()
    {
        $achievements = Achievement::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->when($this->statusFilter, function ($query) {
                switch ($this->statusFilter) {
                    case 'active':
                        $query->where('is_active', true);
                        break;
                    case 'inactive':
                        $query->where('is_active', false);
                        break;
                    case 'hidden':
                        $query->where('is_hidden', true);
                        break;
                    case 'visible':
                        $query->where('is_hidden', false);
                        break;
                }
            })
            ->withCount('userAchievements')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $stats = [
            'total' => Achievement::count(),
            'active' => Achievement::where('is_active', true)->count(),
            'inactive' => Achievement::where('is_active', false)->count(),
            'hidden' => Achievement::where('is_hidden', true)->count(),
            'earned_total' => UserAchievement::count(),
            'unique_earners' => UserAchievement::distinct('user_id')->count(),
        ];

        return view('livewire.admin.achievements.achievements-index', compact('achievements', 'stats'));
    }
}
