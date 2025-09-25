<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReviewReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewReportController extends Controller
{
    /**
     * Display a listing of review reports.
     */
    public function index(Request $request)
    {
        $query = ReviewReport::with(['review.book', 'user', 'admin']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by reason
        if ($request->has('reason') && $request->reason) {
            $query->where('reason', $request->reason);
        }

        // Search by review content or user name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('review', function($reviewQuery) use ($search) {
                    $reviewQuery->where('comment', 'like', "%{$search}%")
                               ->orWhereHas('book', function($bookQuery) use ($search) {
                                   $bookQuery->where('title', 'like', "%{$search}%");
                               });
                })
                ->orWhereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }

        // Sort by creation date (newest first by default)
        $sort = $request->sort ?? 'latest';
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'status':
                $query->orderBy('status', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $reports = $query->paginate(15);

        // Get counts for status filter
        $statusCounts = [
            'pending' => ReviewReport::pending()->count(),
            'reviewed' => ReviewReport::reviewed()->count(),
            'resolved' => ReviewReport::resolved()->count(),
            'dismissed' => ReviewReport::dismissed()->count(),
        ];

        $reasons = ['spam', 'inappropriate', 'offensive', 'fake', 'other'];

        return view('admin.reviews.reports.index', compact('reports', 'statusCounts', 'reasons'));
    }

    /**
     * Display the specified review report.
     */
    public function show(ReviewReport $report)
    {
        $report->load(['review.book', 'review.user', 'user', 'admin']);
        
        return view('admin.reviews.reports.show', compact('report'));
    }

    /**
     * Update the status of a review report.
     */
    public function updateStatus(Request $request, ReviewReport $report)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,resolved,dismissed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'status' => $request->status,
            'admin_id' => Auth::id(),
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.reviews.reports.show', $report)
            ->with('success', 'Report status updated successfully!');
    }
}
