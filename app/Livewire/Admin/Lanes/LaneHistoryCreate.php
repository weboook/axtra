<?php

namespace App\Livewire\Admin\Lanes;

use App\Models\Lane;
use App\Models\LaneHistory;
use Livewire\Component;
use Livewire\WithFileUploads;

class LaneHistoryCreate extends Component
{
    use WithFileUploads;

    public $laneId;
    public $lane;
    
    public $event_type = '';
    public $title = '';
    public $description = '';
    public $cost = null;
    public $performed_by = '';
    public $occurred_at = '';
    public $severity = null;
    public $downtime_minutes = 0;
    public $before_photos = [];
    public $after_photos = [];
    public $metadata = [];

    public $eventTypes = [
        'axe_break' => 'Axe Break',
        'block_replacement' => 'Block Replacement', 
        'maintenance' => 'Maintenance',
        'damage_report' => 'Damage Report',
        'repair' => 'Repair',
    ];

    public $severityLevels = [
        'minor' => 'Minor',
        'major' => 'Major', 
        'critical' => 'Critical',
    ];

    protected $rules = [
        'event_type' => 'required|in:axe_break,block_replacement,maintenance,damage_report,repair',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'cost' => 'nullable|numeric|min:0',
        'performed_by' => 'nullable|string|max:255',
        'occurred_at' => 'required|date',
        'severity' => 'nullable|in:minor,major,critical',
        'downtime_minutes' => 'required|integer|min:0',
        'before_photos.*' => 'nullable|image|max:2048',
        'after_photos.*' => 'nullable|image|max:2048',
    ];

    public function mount($laneId)
    {
        $this->laneId = $laneId;
        $this->lane = Lane::findOrFail($laneId);
        $this->occurred_at = now()->format('Y-m-d H:i');
        $this->performed_by = auth()->user()->name ?? '';
    }

    public function updatedEventType()
    {
        // Auto-generate common titles based on event type
        $this->title = match($this->event_type) {
            'axe_break' => 'Throwing axe damaged during session',
            'block_replacement' => 'Wooden target block replaced',
            'maintenance' => 'Routine maintenance performed',
            'damage_report' => 'Damage assessment and report',
            'repair' => 'Equipment repair completed',
            default => ''
        };
    }

    public function save()
    {
        $this->validate();

        $historyData = [
            'lane_id' => $this->laneId,
            'event_type' => $this->event_type,
            'title' => $this->title,
            'description' => $this->description,
            'cost' => $this->cost,
            'performed_by' => $this->performed_by,
            'occurred_at' => $this->occurred_at,
            'severity' => $this->severity,
            'downtime_minutes' => $this->downtime_minutes,
            'metadata' => $this->metadata,
        ];

        // Handle photo uploads
        if ($this->before_photos) {
            $beforePaths = [];
            foreach ($this->before_photos as $photo) {
                $beforePaths[] = $photo->store('lane-history/before', 'public');
            }
            $historyData['before_photos'] = $beforePaths;
        }

        if ($this->after_photos) {
            $afterPaths = [];
            foreach ($this->after_photos as $photo) {
                $afterPaths[] = $photo->store('lane-history/after', 'public');
            }
            $historyData['after_photos'] = $afterPaths;
        }

        LaneHistory::create($historyData);

        // Update lane maintenance status if needed
        if (in_array($this->event_type, ['damage_report']) && $this->severity === 'critical') {
            $this->lane->update(['maintenance_status' => 'damaged']);
        } elseif ($this->event_type === 'repair' && $this->lane->maintenance_status === 'damaged') {
            $this->lane->update(['maintenance_status' => 'operational']);
        }

        session()->flash('success', 'History entry added successfully.');
        $this->dispatch('history-added');
        $this->dispatch('closeModals');
    }

    public function cancel()
    {
        $this->dispatch('closeModals');
    }

    public function render()
    {
        return view('livewire.admin.lanes.lane-history-create');
    }
}
