<?php

namespace App\Livewire\Employee\Reports;

use App\Models\Booking;
use App\Models\LaneHistory;
use App\Models\Lane;
use Livewire\Component;
use Carbon\Carbon;

class ReportsIndex extends Component
{
    public $selectedDate;
    public $reportType = 'daily';
    
    public function mount()
    {
        $this->selectedDate = Carbon::today()->format('Y-m-d');
    }
    
    public function setReportType($type)
    {
        $this->reportType = $type;
    }
    
    private function getDailyBookingStats()
    {
        $date = Carbon::parse($this->selectedDate);
        
        $bookings = Booking::whereDate('booking_date', $date)->get();
        
        return [
            'total_bookings' => $bookings->count(),
            'completed_bookings' => $bookings->where('status', 'completed')->count(),
            'cancelled_bookings' => $bookings->where('status', 'cancelled')->count(),
            'no_shows' => $bookings->where('status', 'cancelled')->count(),
            'revenue' => $bookings->where('status', 'completed')->sum('total_price'),
            'avg_duration' => 60, // Default 60 minutes as duration isn't stored
        ];
    }
    
    private function getDailyLaneUsage()
    {
        $date = Carbon::parse($this->selectedDate);
        
        $laneUsage = [];
        $lanes = Lane::all();
        
        foreach ($lanes as $lane) {
            $bookings = Booking::where('lane_id', $lane->id)
                ->whereDate('booking_date', $date)
                ->where('status', 'completed')
                ->get();
                
            $totalMinutes = $bookings->count() * 60; // Assuming 60 minutes per booking
                
            $laneUsage[] = [
                'lane' => $lane,
                'bookings_count' => $bookings->count(),
                'total_minutes' => $totalMinutes,
                'utilization_rate' => round(($totalMinutes / (12 * 60)) * 100, 1), // Assuming 12 hours operation
            ];
        }
        
        return collect($laneUsage)->sortByDesc('bookings_count')->values();
    }
    
    private function getDailyMaintenanceIssues()
    {
        $date = Carbon::parse($this->selectedDate);
        
        return LaneHistory::whereDate('created_at', $date)
            ->with(['lane', 'performer'])
            ->orderBy('created_at', 'desc')
            ->get();
    }
    
    private function getWeeklyStats()
    {
        $startOfWeek = Carbon::parse($this->selectedDate)->startOfWeek();
        $endOfWeek = Carbon::parse($this->selectedDate)->endOfWeek();
        
        $bookings = Booking::whereBetween('booking_date', [$startOfWeek, $endOfWeek])->get();
        
        return [
            'total_bookings' => $bookings->count(),
            'completed_bookings' => $bookings->where('status', 'completed')->count(),
            'total_revenue' => $bookings->where('status', 'completed')->sum('total_price'),
            'maintenance_issues' => LaneHistory::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count(),
            'peak_day' => $bookings->groupBy(function($booking) {
                return Carbon::parse($booking->booking_date)->format('l');
            })->map->count()->sortDesc()->keys()->first(),
        ];
    }
    
    private function getMonthlyStats()
    {
        $startOfMonth = Carbon::parse($this->selectedDate)->startOfMonth();
        $endOfMonth = Carbon::parse($this->selectedDate)->endOfMonth();
        
        $bookings = Booking::whereBetween('booking_date', [$startOfMonth, $endOfMonth])->get();
        
        return [
            'total_bookings' => $bookings->count(),
            'completed_bookings' => $bookings->where('status', 'completed')->count(),
            'total_revenue' => $bookings->where('status', 'completed')->sum('total_price'),
            'maintenance_costs' => LaneHistory::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->whereNotNull('cost')->sum('cost'),
            'busiest_week' => $bookings->groupBy(function($booking) {
                return Carbon::parse($booking->booking_date)->weekOfMonth;
            })->map->count()->sortDesc()->keys()->first(),
        ];
    }

    public function render()
    {
        $data = [
            'selectedDateFormatted' => Carbon::parse($this->selectedDate)->format('l, F j, Y'),
        ];
        
        if ($this->reportType === 'daily') {
            $data['bookingStats'] = $this->getDailyBookingStats();
            $data['laneUsage'] = $this->getDailyLaneUsage();
            $data['maintenanceIssues'] = $this->getDailyMaintenanceIssues();
        } elseif ($this->reportType === 'weekly') {
            $data['weeklyStats'] = $this->getWeeklyStats();
        } else {
            $data['monthlyStats'] = $this->getMonthlyStats();
        }
        
        return view('livewire.employee.reports.reports-index', $data);
    }
}