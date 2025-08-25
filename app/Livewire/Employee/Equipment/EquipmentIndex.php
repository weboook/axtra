<?php

namespace App\Livewire\Employee\Equipment;

use App\Models\Lane;
use App\Models\LaneHistory;
use Livewire\Component;
use Carbon\Carbon;

class EquipmentIndex extends Component
{
    public $searchTerm = '';
    public $statusFilter = 'all';
    public $selectedLane = null;
    
    public function viewLaneDetails($laneId)
    {
        $this->selectedLane = Lane::with(['history' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }])->find($laneId);
    }
    
    public function closeLaneDetails()
    {
        $this->selectedLane = null;
    }
    
    public function updateLaneStatus($laneId, $status)
    {
        $lane = Lane::find($laneId);
        if ($lane) {
            $lane->update(['maintenance_status' => $status]);
            
            // Log the status change
            LaneHistory::create([
                'lane_id' => $laneId,
                'event_type' => 'status_change',
                'description' => "Status changed to: " . str_replace('_', ' ', $status),
                'severity' => $status === 'out_of_order' ? 'critical' : 'minor',
                'performed_by' => auth()->id(),
                'occurred_at' => now(),
                'metadata' => [
                    'old_status' => $lane->getOriginal('maintenance_status'),
                    'new_status' => $status,
                    'changed_at' => now()->toISOString(),
                ]
            ]);
            
            session()->flash('success', 'Lane status updated successfully');
        }
    }
    
    private function getFilteredLanes()
    {
        $query = Lane::with(['history' => function($q) {
            $q->orderBy('created_at', 'desc')->limit(3);
        }]);
        
        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        }
        
        if ($this->statusFilter !== 'all') {
            $query->where('maintenance_status', $this->statusFilter);
        }
        
        return $query->orderBy('name')->get();
    }
    
    private function getMaintenanceStats()
    {
        return [
            'total_lanes' => Lane::count(),
            'operational' => Lane::where('maintenance_status', 'operational')->count(),
            'maintenance' => Lane::where('maintenance_status', 'maintenance')->count(),
            'out_of_order' => Lane::where('maintenance_status', 'out_of_order')->count(),
            'recent_issues' => LaneHistory::where('created_at', '>=', Carbon::today())->count(),
        ];
    }

    public function render()
    {
        $lanes = $this->getFilteredLanes();
        $stats = $this->getMaintenanceStats();
        
        $recentMaintenanceHistory = LaneHistory::with(['lane', 'performer'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('livewire.employee.equipment.equipment-index', compact('lanes', 'stats', 'recentMaintenanceHistory'));
    }
}