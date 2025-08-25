<?php

namespace App\Livewire\Employee\Schedule;

use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;

class ScheduleIndex extends Component
{
    public $currentDate;
    public $viewMode = 'weekly'; // weekly, monthly, daily
    public $selectedDate;
    
    public function mount()
    {
        $this->currentDate = Carbon::now();
        $this->selectedDate = $this->currentDate->format('Y-m-d');
    }
    
    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }
    
    public function previousPeriod()
    {
        switch ($this->viewMode) {
            case 'daily':
                $this->currentDate = $this->currentDate->subDay();
                break;
            case 'weekly':
                $this->currentDate = $this->currentDate->subWeek();
                break;
            case 'monthly':
                $this->currentDate = $this->currentDate->subMonth();
                break;
        }
        $this->selectedDate = $this->currentDate->format('Y-m-d');
    }
    
    public function nextPeriod()
    {
        switch ($this->viewMode) {
            case 'daily':
                $this->currentDate = $this->currentDate->addDay();
                break;
            case 'weekly':
                $this->currentDate = $this->currentDate->addWeek();
                break;
            case 'monthly':
                $this->currentDate = $this->currentDate->addMonth();
                break;
        }
        $this->selectedDate = $this->currentDate->format('Y-m-d');
    }
    
    public function goToToday()
    {
        $this->currentDate = Carbon::now();
        $this->selectedDate = $this->currentDate->format('Y-m-d');
    }
    
    private function getBookingsForDate($date)
    {
        return Booking::whereDate('booking_date', $date)
            ->with(['user', 'product', 'service', 'lane'])
            ->orderBy('start_time')
            ->get();
    }
    
    private function getWeekDays()
    {
        $startOfWeek = $this->currentDate->copy()->startOfWeek();
        $days = [];
        
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $days[] = [
                'date' => $date,
                'bookings' => $this->getBookingsForDate($date->format('Y-m-d'))
            ];
        }
        
        return $days;
    }
    
    private function getMonthCalendar()
    {
        $startOfMonth = $this->currentDate->copy()->startOfMonth();
        $endOfMonth = $this->currentDate->copy()->endOfMonth();
        
        // Start from the beginning of the week that contains the first day of the month
        $startDate = $startOfMonth->copy()->startOfWeek();
        $endDate = $endOfMonth->copy()->endOfWeek();
        
        $calendar = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $date = $currentDate->copy();
                $week[] = [
                    'date' => $date,
                    'bookings' => $this->getBookingsForDate($date->format('Y-m-d')),
                    'isCurrentMonth' => $date->month === $this->currentDate->month,
                    'isToday' => $date->isToday()
                ];
                $currentDate->addDay();
            }
            $calendar[] = $week;
        }
        
        return $calendar;
    }

    public function render()
    {
        $data = [
            'currentDateFormatted' => $this->currentDate->format('F Y'),
            'todayBookings' => $this->getBookingsForDate(Carbon::today()->format('Y-m-d')),
        ];
        
        switch ($this->viewMode) {
            case 'daily':
                $data['dayBookings'] = $this->getBookingsForDate($this->currentDate->format('Y-m-d'));
                $data['currentDay'] = $this->currentDate;
                break;
                
            case 'weekly':
                $data['weekDays'] = $this->getWeekDays();
                $data['weekStart'] = $this->currentDate->copy()->startOfWeek();
                $data['weekEnd'] = $this->currentDate->copy()->endOfWeek();
                break;
                
            case 'monthly':
                $data['monthCalendar'] = $this->getMonthCalendar();
                break;
        }
        
        return view('livewire.employee.schedule.schedule-index', $data);
    }
}