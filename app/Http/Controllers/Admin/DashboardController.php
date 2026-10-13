<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\PartnershipLead;
use App\Models\Promotion;
use App\Models\Property;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'brands_count' => Brand::count(),
            'properties_count' => Property::count(),
            'published_properties_count' => Property::published()->count(),
            'active_promotions_count' => Promotion::published()->activeBooking()->count(),
            'published_posts_count' => BlogPost::published()->count(),
            'new_leads_count' => PartnershipLead::where('pipeline_status', 'new')->count(),
            'total_leads_count' => PartnershipLead::count(),
        ];

        $recentLeads = PartnershipLead::latest()->take(5)->get();
        $recentLogs = AuditLog::with('user')->latest('created_at')->take(8)->get();
        $properties = Property::with('brand')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentLeads', 'recentLogs', 'properties'));
    }
}
