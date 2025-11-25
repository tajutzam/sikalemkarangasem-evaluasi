<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Instansi;
use App\Models\Variabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentYear = date('Y');

        if ($user->is_admin) {
            return $this->adminDashboard($currentYear);
        } else {
            return $this->userDashboard($user, $currentYear);
        }
    }

    private function adminDashboard($currentYear)
    {
        // Statistics
        $totalInstansi = Instansi::count();
        $totalVariabel = Variabel::count();
        $totalEvaluations = Evaluation::count();
        $evaluationsThisYear = Evaluation::byYear($currentYear)->count();

        // Status statistics
        $statusStats = Evaluation::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $draftCount = $statusStats['draft'] ?? 0;
        $submittedCount = $statusStats['submitted'] ?? 0;
        $approvedCount = $statusStats['approved'] ?? 0;
        $rejectedCount = $statusStats['rejected'] ?? 0;

        // Recent evaluations
        $recentEvaluations = Evaluation::with(['instansi', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pending approvals
        $pendingApprovals = Evaluation::byStatus('submitted')
            ->with(['instansi', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Evaluation by year chart data
        $evaluationsByYear = Evaluation::select('tahun', DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalInstansi',
            'totalVariabel',
            'totalEvaluations',
            'evaluationsThisYear',
            'draftCount',
            'submittedCount',
            'approvedCount',
            'rejectedCount',
            'recentEvaluations',
            'pendingApprovals',
            'evaluationsByYear'
        ));
    }

    private function userDashboard($user, $currentYear)
    {
        // Status statistics for user
        $statusStats = Evaluation::where('user_id', $user->id)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $myDraft = $statusStats['draft'] ?? 0;
        $mySubmitted = $statusStats['submitted'] ?? 0;
        $myApproved = $statusStats['approved'] ?? 0;
        $myRejected = $statusStats['rejected'] ?? 0;

        // Recent evaluations by user
        $recentEvaluations = Evaluation::where('user_id', $user->id)
            ->with(['instansi'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Draft evaluations (in progress)
        $draftEvaluations = Evaluation::where('user_id', $user->id)
            ->byStatus('draft')
            ->with(['instansi'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'myDraft',
            'mySubmitted',
            'myApproved',
            'myRejected',
            'recentEvaluations',
            'draftEvaluations',
        ));
    }
}