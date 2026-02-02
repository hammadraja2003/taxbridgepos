<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BusinessConfiguration;
use App\Models\BusinessPackage;
use App\Models\GeneralSetting;
use App\Models\SupportTicket;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBusinesses = BusinessConfiguration::count();
        $totalUsers = User::count();
        
        // Count unique businesses that have at least one trial package
        $totalTrialBusinesses = BusinessPackage::where('is_trial', 1)
            ->distinct('business_id')
            ->count('business_id');
            
        // Count unique businesses that have at least one active package
        $totalActiveBusinesses = BusinessPackage::where('is_active', 1)
            ->where('end_date', '>=', now())
            ->distinct('business_id')
            ->count('business_id');

        // Graph 1: Subscriptions Expiring in the Next Two Weeks (14 days)
        $twoWeeksRange = now()->addDays(15);
        $expiringTwoWeeks = BusinessPackage::where('is_active', 1)
            ->where('end_date', '>=', now())
            ->where('end_date', '<=', $twoWeeksRange)
            ->with('business')
            ->get()
            ->map(function ($pkg) {
                $daysLeft = $pkg->end_date ? now()->diffInDays($pkg->end_date, false) : null;
                $daysLeft = is_null($daysLeft) ? null : (int) $daysLeft;
                return [
                    'business' => $pkg->business ? $pkg->business->bus_name : 'Unknown',
                    'days_left' => $daysLeft
                ];
            });

        // Graph 2: Subscriptions Expiring in the Next One Month (30 days)
        $oneMonthRange = now()->addDays(31);
        $expiringOneMonth = BusinessPackage::where('is_active', 1)
            ->where('end_date', '>=', now())
            ->where('end_date', '<=', $oneMonthRange)
            ->with('business')
            ->get()
            ->map(function ($pkg) {
                $daysLeft = $pkg->end_date ? now()->diffInDays($pkg->end_date, false) : null;
                $daysLeft = is_null($daysLeft) ? null : (int) $daysLeft;
                return [
                    'business' => $pkg->business ? $pkg->business->bus_name : 'Unknown',
                    'days_left' => $daysLeft
                ];
            });

        $dashboardData = [
            'totalBusinesses' => $totalBusinesses,
            'totalUsers' => $totalUsers,
            'totalTrialBusinesses' => $totalTrialBusinesses,
            'totalActiveBusinesses' => $totalActiveBusinesses,
            'revenue' => 0.00,
            'saleReturn' => 0.00,
            'purchaseReturn' => 0.00,
            'profit' => 0.00,
            'expiringTwoWeeks' => [
                'labels' => $expiringTwoWeeks->pluck('business')->toArray(),
                'data' => $expiringTwoWeeks->pluck('days_left')->toArray(),
                'raw' => $expiringTwoWeeks->toArray(),
            ],
            'expiringOneMonth' => [
                'labels' => $expiringOneMonth->pluck('business')->toArray(),
                'data' => $expiringOneMonth->pluck('days_left')->toArray(),
                'raw' => $expiringOneMonth->toArray(),
            ],
            // Support ticket data
            'topTicketClients' => $this->getTopTicketClients(),
            'ticketsByPriority' => $this->getTicketsByPriority(),
            'ticketsByStatus'   => $this->getTicketsByStatus(),
        ];

        $general_setting = GeneralSetting::first();

        return view('admin.admin_dashboard', compact('dashboardData', 'general_setting'));
    }

    private function getTopTicketClients()
    {
        $data = SupportTicket::select('bus_config_id', \DB::raw('count(*) as total'))
            ->with('businessConfiguration:bus_config_id,bus_name')
            ->groupBy('bus_config_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return [
            'labels' => $data->map(function($item) {
                return $item->businessConfiguration->bus_name ?? 'Unknown';
            })->toArray(),
            'data' => $data->pluck('total')->toArray(),
        ];
    }

    private function getTicketsByPriority()
    {
        $priorities = ['critical', 'high', 'medium', 'low', 'new_feature', 'informational'];
        $counts = SupportTicket::select('priority', \DB::raw('count(*) as total'))
            ->groupBy('priority')
            ->pluck('total', 'priority')
            ->toArray();
        
        // Ensure all keys exist
        $result = [];
        foreach ($priorities as $p) {
            $result[$p] = $counts[$p] ?? 0;
        }
        return $result;
    }

    private function getTicketsByStatus()
    {
        $statuses = ['open', 'pending', 'resolved', 'closed'];
        $counts = SupportTicket::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        
        $result = [];
        foreach ($statuses as $s) {
            $result[$s] = $counts[$s] ?? 0;
        }
        return $result;
    }
}
