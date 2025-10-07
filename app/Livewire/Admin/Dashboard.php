<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Family;
use App\Models\Charge;
use App\Models\Department;
use App\Models\FamilyMember;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $monthlyCharges;
    public $recentChargedFamily;
    public $todayTransactions;
    public $recentCharges;
    public $inactiveFamilies;
    public $upcomingProjections;

    // Charts
    public $chartMonthlyTrend;
    public $chartDepartmentDistribution;
    public $chartDailyTransactions;
    public $chartRoleDistribution;
    public $chartAveragePerDepartment;
    // public $newDepartmentName = '';
    // public $showAddDepartmentModal = false;

    public function mount()
    {
        $this->loadDashboardData();
    }

    // public function openAddDepartmentModal()
    // {
    //     $this->reset('newDepartmentName');
    //     $this->showAddDepartmentModal = true;
    // }

    // public function saveDepartment()
    // {
    //     $this->validate([
    //         'newDepartmentName' => 'required|string|unique:departments,name|max:255',
    //     ]);

    //     Department::create([
    //         'name' => $this->newDepartmentName,
    //     ]);

    //     $this->showAddDepartmentModal = false;

    //     session()->flash('success', 'Department added successfully!');
    // }

    public function loadDashboardData()
    {
        $now = Carbon::now();
        $today = $now->toDateString();

        // 1. Monthly Charges Summary
        $this->monthlyCharges = Charge::whereMonth('created_at', $now->month)->sum('price');

        // 2. Most Recent Charged Family
        $recentCharge = Charge::latest()->with('family')->first();
        $this->recentChargedFamily = $recentCharge
            ? [
                'family_name' => $recentCharge->family->family_name ?? 'Unknown',
                'amount' => $recentCharge->price
            ]
            : null;

        // 3. Total Transactions Today
        $this->todayTransactions = Charge::whereDate('created_at', $today)->count();

        // 4. Recent Charges (10 only)
        $this->recentCharges = Charge::with('family')->latest()->take(8)->get();

        // 5. Inactive Families (No charges this month)
        $this->inactiveFamilies = Family::whereDoesntHave('charges', function ($query) use ($now) {
            $query->whereMonth('created_at', $now->month);
        })->get();

        // 6. Upcoming Charges Projection
        $avgPerDay = Charge::whereMonth('created_at', $now->month)->avg('price');
        $daysLeft = $now->copy()->endOfMonth()->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, $now);
        $this->upcomingProjections = round($avgPerDay * $daysLeft, 2);

        // 📊 Chart 1: Monthly Trend (per day)
        $this->chartMonthlyTrend = Charge::selectRaw('DATE(created_at) as date, SUM(price) as total')
            ->whereMonth('created_at', $now->month)
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get();

        // 📊 Chart 2: Department Distribution
        $this->chartDepartmentDistribution = Charge::join('departments', 'charges.department_id', '=', 'departments.id')
            ->select('departments.name as department_name', DB::raw('SUM(charges.price) as total'))
            ->whereMonth('charges.created_at', $now->month)
            ->groupBy('departments.name')
            ->orderByDesc('total')
            ->get();

        // 📊 Chart 3: Daily Transaction Count
        $this->chartDailyTransactions = Charge::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereMonth('created_at', $now->month)
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get();

        // 📊 Chart 5: Average Charge Per Department
        $this->chartAveragePerDepartment = Charge::join('departments', 'charges.department_id', '=', 'departments.id')
            ->select('departments.name as department_name', DB::raw('AVG(charges.price) as average'))
            ->whereMonth('charges.created_at', $now->month)
            ->groupBy('departments.name')
            ->orderByDesc('average')
            ->get();
    }

    public function render()
    {
        $now = Carbon::now();

        $familyChargesPaginated = Family::with(['charges' => function ($query) use ($now) {
            $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year);
        }])
        ->withCount(['charges as total_charges' => function ($query) use ($now) {
            $query->whereMonth('created_at', $now->month)->whereYear('created_at', $now->year);
        }])
        ->paginate(10);

        return view('livewire.admin.dashboard', [
            'familyChargesPaginated' => $familyChargesPaginated
        ])->layout('layouts.app');
    }
}
