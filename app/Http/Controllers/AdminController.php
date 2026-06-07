<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\User;
use App\Models\ApiLibur;
use App\Models\InventoryChecking;
use App\Models\Supplier;
use App\Models\JenisBarang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $expiredSoon = InventoryChecking::whereDate('expired_date', '<=', now()->addDays(7))->get();
        $ScheduleinWeek = Schedule::whereDate('date', '<=', now()->addDays(7))->get();
        $dataSchedule = Schedule::all();
        $totalSchedule = Schedule::count(); 
        $users = User::all();
        $jenisBarangs = JenisBarang::count();
        
        // FIX BUG: status is a boolean in database (1 or 0), not a string 'completed'
        $completedSchedule = Schedule::where('status', true)->count(); 
        
        $userCount = User::count(); 
        $dataApi = ApiLibur::pluck('name', 'date');
        $Inventory = InventoryChecking::count();
        $supplier = Supplier::count(); 

        // --- FINANCIAL ANALYTICS CALCULATIONS ---
        // 1. Calculate Gross Profits from Inventory
        $inventoryCheckings = InventoryChecking::whereNotNull('tanggal')->get();
        $monthlyProfits = [];
        $totalGrossProfit = 0;
        
        foreach ($inventoryCheckings as $item) {
            $profit = (floatval($item->harga_jual) - floatval($item->harga_pokok)) * intval($item->jumlah);
            $totalGrossProfit += $profit;
            
            $carbonDate = Carbon::parse($item->tanggal);
            $monthKey = $carbonDate->format('Y-m'); // e.g. "2026-06"
            $monthName = $carbonDate->translatedFormat('F Y'); // e.g. "Juni 2026"
            
            if (!isset($monthlyProfits[$monthKey])) {
                $monthlyProfits[$monthKey] = [
                    'label' => $monthName,
                    'total' => 0
                ];
            }
            $monthlyProfits[$monthKey]['total'] += $profit;
        }

        // 2. Calculate Expenses from Schedule budgets
        $schedulesWithBudget = Schedule::whereNotNull('budget')->whereNotNull('date')->get();
        $monthlyBudgets = [];
        $categoryBudgets = [];
        $totalExpenses = 0;
        
        foreach ($schedulesWithBudget as $s) {
            $totalExpenses += floatval($s->budget);
            
            $carbonDate = Carbon::parse($s->date);
            $monthKey = $carbonDate->format('Y-m');
            $monthName = $carbonDate->translatedFormat('F Y');
            
            if (!isset($monthlyBudgets[$monthKey])) {
                $monthlyBudgets[$monthKey] = [
                    'label' => $monthName,
                    'total' => 0
                ];
            }
            $monthlyBudgets[$monthKey]['total'] += floatval($s->budget);
            
            $categoryName = $s->jenisSchedule->nama ?? 'Umum';
            if (!isset($categoryBudgets[$categoryName])) {
                $categoryBudgets[$categoryName] = 0;
            }
            $categoryBudgets[$categoryName] += floatval($s->budget);
        }

        // 3. Merge and Sort chronologically (last 6 months or all months active)
        $months = array_unique(array_merge(array_keys($monthlyProfits), array_keys($monthlyBudgets)));
        sort($months);
        
        // Limit to last 6 months for chart readability if there are too many months
        if (count($months) > 6) {
            $months = array_slice($months, -6);
        }
        
        $chartLabels = [];
        $chartProfits = [];
        $chartExpenses = [];
        
        foreach ($months as $m) {
            $carbonDate = Carbon::parse($m . '-01');
            $chartLabels[] = $carbonDate->translatedFormat('F Y');
            $chartProfits[] = $monthlyProfits[$m]['total'] ?? 0;
            $chartExpenses[] = $monthlyBudgets[$m]['total'] ?? 0;
        }
        
        $catLabels = array_keys($categoryBudgets);
        $catValues = array_values($categoryBudgets);

        return view('admin.dashboard', compact(
            'totalSchedule', 
            'completedSchedule', 
            'userCount', 
            'dataApi', 
            'users', 
            'Inventory', 
            'supplier', 
            'expiredSoon', 
            'jenisBarangs', 
            'ScheduleinWeek',
            'totalGrossProfit',
            'totalExpenses',
            'chartLabels',
            'chartProfits',
            'chartExpenses',
            'catLabels',
            'catValues'
        ));
    }

    public function createSupplier()
    {
        return view('admin.createSupplier');
    }


    public function addGmail()
    {
        return view('admin.addGmail');
    }


}
