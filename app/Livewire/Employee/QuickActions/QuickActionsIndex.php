<?php

namespace App\Livewire\Employee\QuickActions;

use App\Models\Lane;
use App\Models\LaneHistory;
use Livewire\Component;
use Livewire\WithFileUploads;

class QuickActionsIndex extends Component
{
    use WithFileUploads;

    public $selectedLanes = [];
    public $maintenanceType = '';
    public $description = '';
    public $severity = 'medium';
    public $estimatedDowntime = '';
    public $cost = '';
    public $beforePhoto;
    public $afterPhoto;
    
    // Quick action modals
    public $showMaintenanceModal = false;
    public $showBlockBreakModal = false;
    public $showAxeBreakModal = false;

    protected $rules = [
        'selectedLanes' => 'required|array|min:1',
        'selectedLanes.*' => 'exists:lanes,id',
        'maintenanceType' => 'required|string',
        'description' => 'required|string|max:1000',
        'severity' => 'required|in:low,medium,high,critical',
        'estimatedDowntime' => 'nullable|integer|min:0',
        'cost' => 'nullable|numeric|min:0',
        'beforePhoto' => 'nullable|image|max:2048',
        'afterPhoto' => 'nullable|image|max:2048',
    ];

    public function showMaintenanceDialog($type)
    {
        $this->resetForm();
        $this->maintenanceType = $type;
        
        if ($type === 'block_break') {
            $this->showBlockBreakModal = true;
        } elseif ($type === 'axe_break') {
            $this->showAxeBreakModal = true;
        } else {
            $this->showMaintenanceModal = true;
        }
    }

    public function submitMaintenance()
    {
        $this->validate();

        $beforePhotoPath = null;
        $afterPhotoPath = null;

        if ($this->beforePhoto) {
            $beforePhotoPath = $this->beforePhoto->store('lane-maintenance', 'public');
        }

        if ($this->afterPhoto) {
            $afterPhotoPath = $this->afterPhoto->store('lane-maintenance', 'public');
        }

        foreach ($this->selectedLanes as $laneId) {
            $lane = Lane::find($laneId);
            
            // Create lane history entry
            LaneHistory::create([
                'lane_id' => $laneId,
                'event_type' => $this->maintenanceType,
                'description' => $this->description,
                'severity' => $this->severity,
                'cost' => $this->cost,
                'downtime_minutes' => $this->estimatedDowntime,
                'before_photos' => $beforePhotoPath ? [$beforePhotoPath] : null,
                'after_photos' => $afterPhotoPath ? [$afterPhotoPath] : null,
                'performed_by' => auth()->id(),
                'occurred_at' => now(),
                'metadata' => [
                    'reported_at' => now()->toISOString(),
                    'reporter_role' => 'employee'
                ]
            ]);

            // Update lane status if critical
            if ($this->severity === 'critical' && $this->maintenanceType !== 'routine_maintenance') {
                $lane->update(['maintenance_status' => 'out_of_order']);
            } elseif ($this->severity === 'high') {
                $lane->update(['maintenance_status' => 'maintenance']);
            }
        }

        session()->flash('success', count($this->selectedLanes) . ' lane(s) reported for ' . str_replace('_', ' ', $this->maintenanceType) . ' maintenance.');
        $this->closeModals();
    }

    public function closeModals()
    {
        $this->showMaintenanceModal = false;
        $this->showBlockBreakModal = false;
        $this->showAxeBreakModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->selectedLanes = [];
        $this->maintenanceType = '';
        $this->description = '';
        $this->severity = 'medium';
        $this->estimatedDowntime = '';
        $this->cost = '';
        $this->beforePhoto = null;
        $this->afterPhoto = null;
    }

    public function render()
    {
        $lanes = Lane::orderBy('name')->get();
        
        $recentReports = LaneHistory::with(['lane'])
            ->where('performed_by', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('livewire.employee.quick-actions.quick-actions-index', compact('lanes', 'recentReports'));
    }
}