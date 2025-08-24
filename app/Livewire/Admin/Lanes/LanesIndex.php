<?php

namespace App\Livewire\Admin\Lanes;

use App\Models\Lane;
use App\Models\LaneHistory;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class LanesIndex extends Component
{
    use WithPagination;

    // Search and filtering
    public $search = '';
    public $statusFilter = '';
    public $maintenanceFilter = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';
    public $perPage = 12;
    
    // Bulk actions
    public $selectedLanes = [];
    public $bulkAction = '';
    
    // Modals
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showHistoryModal = false;
    public $showAddHistoryModal = false;
    
    // Selected lane for actions
    public $selectedLane = null;

    // History filters
    public $historyEventFilter = '';
    public $historySeverityFilter = '';
    public $historyDateRange = '30';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingMaintenanceFilter()
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

    public function showCreateLane()
    {
        $this->showCreateModal = true;
    }

    public function showEditLane($laneId)
    {
        $this->selectedLane = Lane::findOrFail($laneId);
        $this->showEditModal = true;
    }

    public function showLaneHistory($laneId)
    {
        $this->selectedLane = Lane::with(['history' => function($query) {
            $query->orderBy('occurred_at', 'desc');
        }])->findOrFail($laneId);
        $this->showHistoryModal = true;
    }

    public function showAddHistory($laneId)
    {
        $this->selectedLane = Lane::findOrFail($laneId);
        $this->showAddHistoryModal = true;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showHistoryModal = false;
        $this->showAddHistoryModal = false;
        $this->selectedLane = null;
        $this->historyEventFilter = '';
        $this->historySeverityFilter = '';
        $this->historyDateRange = '30';
    }

    public function toggleLaneStatus($laneId)
    {
        $lane = Lane::findOrFail($laneId);
        $lane->update(['is_active' => !$lane->is_active]);
        
        $status = $lane->is_active ? 'activated' : 'deactivated';
        session()->flash('success', "Lane {$lane->name} has been {$status} successfully.");
    }

    public function updateMaintenanceStatus($laneId, $status)
    {
        $lane = Lane::findOrFail($laneId);
        $lane->update(['maintenance_status' => $status]);
        
        session()->flash('success', "Lane {$lane->name} maintenance status updated to {$status}.");
    }

    public function deleteLane($laneId)
    {
        $lane = Lane::findOrFail($laneId);
        $lane->delete();
        
        session()->flash('success', "Lane {$lane->name} deleted successfully.");
    }

    public function bulkAction()
    {
        if (empty($this->selectedLanes) || !$this->bulkAction) return;
        
        $lanes = Lane::whereIn('id', $this->selectedLanes)->get();
        $count = 0;
        
        foreach ($lanes as $lane) {
            switch ($this->bulkAction) {
                case 'activate':
                    if (!$lane->is_active) {
                        $lane->update(['is_active' => true]);
                        $count++;
                    }
                    break;
                case 'deactivate':
                    if ($lane->is_active) {
                        $lane->update(['is_active' => false]);
                        $count++;
                    }
                    break;
                case 'maintenance':
                    if ($lane->maintenance_status !== 'maintenance') {
                        $lane->update(['maintenance_status' => 'maintenance']);
                        $count++;
                    }
                    break;
                case 'operational':
                    if ($lane->maintenance_status !== 'operational') {
                        $lane->update(['maintenance_status' => 'operational']);
                        $count++;
                    }
                    break;
            }
        }
        
        session()->flash('success', "Bulk action applied to {$count} lanes.");
        $this->selectedLanes = [];
        $this->bulkAction = '';
    }

    #[On('lane-created')]
    #[On('lane-updated')]
    #[On('history-added')]
    #[On('closeModals')]
    public function refreshList()
    {
        $this->closeModals();
    }

    public function getFilteredHistory()
    {
        if (!$this->selectedLane) return collect();

        $query = $this->selectedLane->history();

        if ($this->historyEventFilter) {
            $query->where('event_type', $this->historyEventFilter);
        }

        if ($this->historySeverityFilter) {
            $query->where('severity', $this->historySeverityFilter);
        }

        if ($this->historyDateRange !== 'all') {
            $days = (int) $this->historyDateRange;
            $query->where('occurred_at', '>=', now()->subDays($days));
        }

        return $query->orderBy('occurred_at', 'desc')->get();
    }

    public function render()
    {
        $lanes = Lane::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                switch ($this->statusFilter) {
                    case 'active':
                        $query->where('is_active', true);
                        break;
                    case 'inactive':
                        $query->where('is_active', false);
                        break;
                }
            })
            ->when($this->maintenanceFilter, function ($query) {
                $query->where('maintenance_status', $this->maintenanceFilter);
            })
            ->withCount(['axeBreaks', 'blockReplacements', 'history'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        $stats = [
            'total' => Lane::count(),
            'active' => Lane::where('is_active', true)->count(),
            'inactive' => Lane::where('is_active', false)->count(),
            'operational' => Lane::where('maintenance_status', 'operational')->count(),
            'maintenance' => Lane::where('maintenance_status', 'maintenance')->count(),
            'damaged' => Lane::where('maintenance_status', 'damaged')->count(),
        ];

        return view('livewire.admin.lanes.lanes-index', compact('lanes', 'stats'));
    }
}
