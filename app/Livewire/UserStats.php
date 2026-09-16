<?php

namespace App\Livewire;

use Livewire\Component;
use \Carbon\Carbon;
use \Carbon\CarbonInterval;
use \App\Models\User;
use \App\Models\FamousPoint;
use App\Enums\FamousPointTypes;

class UserStats extends Component
{
    public $readyToLoad = false;

    public $availableTimePeriods = [
        "Last 7 days",
        "Last 30 days",
        "This year",
        "Last year",
        "Custom dates"
    ];

    public $timePeriod = "Last 7 days";

    public $startDate;

    public $endDate;

    public $scope = "user";

    public function loadStats()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        $data = [];
        $currentStartDate = null;
        $currentEndDate = null;
        $prevStartDate = null;
        $prevEndDate = null;
        if ($this->readyToLoad) {
            $this->updateDatesFilter($currentStartDate, $currentEndDate, $prevStartDate, $prevEndDate);
            $stats = [];
            if ($this->scope === 'user') {
                $user = auth()->user();
                if (!is_null($currentStartDate) && !is_null($currentEndDate) && !is_null($prevStartDate) && !is_null($prevEndDate)) {
                    $stats[] = [
                        "label" => "famous points received",
                        "value" => FamousPoint::where('user_id', $user->id)
                            ->whereBetween('created_at', [$currentStartDate, $currentEndDate])
                            ->sum('ajeje'),
                        "prev_value" => FamousPoint::where('user_id', $user->id)
                            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
                            ->sum('ajeje')
                    ];
                    $stats[] = [
                        "label" => "fans",
                        "value" => FamousPoint::selectRaw('COUNT(DISTINCT(sender_id)) as counter')
                            ->where('user_id', $user->id)
                            ->whereBetween('created_at', [$currentStartDate, $currentEndDate])
                            ->first()->counter,
                        "prev_value" => FamousPoint::selectRaw('COUNT(DISTINCT(sender_id)) as counter')
                            ->where('user_id', $user->id)
                            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
                            ->first()->counter,
                    ];
                    $stats[] = [
                        "label" => "famous points given",
                        "value" => FamousPoint::where('sender_id', $user->id)
                            ->whereBetween('created_at', [$currentStartDate, $currentEndDate])
                            ->sum('ajeje'),
                        "prev_value" => FamousPoint::where('sender_id', $user->id)
                            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
                            ->sum('ajeje'),
                    ];
                    $stats[] = [
                        "label" => "people endorsed",
                        "value" => FamousPoint::selectRaw('COUNT(DISTINCT(user_id)) as counter')
                            ->where('sender_id', $user->id)
                            ->whereBetween('created_at', [$currentStartDate, $currentEndDate])
                            ->first()->counter,
                        "prev_value" => FamousPoint::selectRaw('COUNT(DISTINCT(user_id)) as counter')
                            ->where('sender_id', $user->id)
                            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
                            ->first()->counter,
                    ];
                }
            } else {
                if (auth()->user()->can('supadupaadminshit')) {
                    $stats[] = [
                        "label" => "famous points",
                        "value" => FamousPoint::whereBetween('created_at', [$currentStartDate, $currentEndDate])
                            ->where('type', FamousPointTypes::WORSHIP)
                            ->sum('ajeje'),
                        "prev_value" => FamousPoint::whereBetween('created_at', [$prevStartDate, $prevEndDate])
                            ->where('type', FamousPointTypes::WORSHIP)
                            ->sum('ajeje'),
                    ];
                    $stats[] = [
                        "label" => "active users",
                        "value" => FamousPoint::selectRaw('COUNT(DISTINCT(sender_id)) as counter')
                            ->where('type', FamousPointTypes::WORSHIP)
                            ->whereBetween('created_at', [$currentStartDate, $currentEndDate])
                            ->first()->counter,
                        "prev_value" => FamousPoint::selectRaw('COUNT(DISTINCT(sender_id)) as counter')
                            ->where('type', FamousPointTypes::WORSHIP)
                            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
                            ->first()->counter,
                    ];
                    $stats[] = [
                        "label" => "new users",
                        "value" => User::selectRaw('COUNT(DISTINCT(id)) as counter')
                            ->members()
                            ->whereBetween('created_at', [$currentStartDate, $currentEndDate])
                            ->first()->counter,
                        "prev_value" => User::selectRaw('COUNT(DISTINCT(id)) as counter')
                            ->members()
                            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
                            ->first()->counter,
                    ];
                    $stats[] = [
                        "label" => "tagged users",
                        "value" => User::selectRaw('COUNT(DISTINCT(id)) as counter')
                            ->members()
                            ->whereHas('tags')
                            ->whereBetween('created_at', [$currentStartDate, $currentEndDate])
                            ->first()->counter,
                        "prev_value" => User::selectRaw('COUNT(DISTINCT(id)) as counter')
                            ->members()
                            ->whereHas('tags')
                            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
                            ->first()->counter,
                    ];
                    $stats[] = [
                        "label" => "fake famous points",
                        "value" => FamousPoint::whereBetween('created_at', [$currentStartDate, $currentEndDate])
                            ->where('type', FamousPointTypes::FAKE)
                            ->sum('ajeje'),
                        "prev_value" => FamousPoint::whereBetween('created_at', [$prevStartDate, $prevEndDate])
                            ->where('type', FamousPointTypes::FAKE)
                            ->sum('ajeje'),
                    ];
                }
            }
            $data["stats"] = $stats;
        }
        return view('livewire.user-stats', $data);
    }

    private function updateDatesFilter(&$currentStartDate, &$currentEndDate, &$prevStartDate, &$prevEndDate)
    {
        switch ($this->timePeriod) {
            case 'Last 7 days':
                $currentEndDate = now();
                $currentStartDate = $currentEndDate->copy()->subDays(7);
                break;
            case 'Last 30 days':
                $currentEndDate = now();
                $currentStartDate = now()->subDays(30);
                break;
            case 'This year':
                $currentEndDate = now();
                $currentStartDate = Carbon::create('First day of this year');
                break;
            case 'Last year':
                $currentEndDate = Carbon::create('Last day of December ' . now()->subYears(1)->format('Y'));
                $currentStartDate = Carbon::create('First day of last year');
                break;

            default:
                if (!is_null($this->startDate)) {
                    $currentStartDate = Carbon::parse($this->startDate);
                }
                if (!is_null($this->endDate)) {
                    $currentEndDate = Carbon::parse($this->endDate);
                }
                break;
        }
        if (!is_null($currentStartDate)) {
            $currentStartDate->startOfDay();
            $this->startDate = $currentStartDate->format('Y-m-d');
        }
        if (!is_null($currentEndDate)) {
            $currentEndDate->endOfDay();
            $this->endDate = $currentEndDate->format('Y-m-d');
        }
        if (!is_null($this->startDate) && !is_null($this->endDate)) {
            $interval = new CarbonInterval($currentStartDate->copy()->diff($currentEndDate));
            $prevStartDate = $currentStartDate->copy()->sub($interval);
            $prevEndDate = $currentEndDate->copy()->sub($interval)->subSeconds(1);
        }
    }
}
