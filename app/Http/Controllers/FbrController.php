<?php

namespace App\Http\Controllers;

use App\Models\FbrPostError;
use Illuminate\Http\Request;
use Auth;

class FbrController extends Controller
{
    /**
     * Display the FBR posting errors log.
     */
    public function postErrors(Request $request)
    {
        $role = \App\Models\Roles::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('fbr-errors')) {
            return redirect()->back()->with('not_permitted', __('db.Sorry! You are not allowed to access this module'));
        }

        $query = FbrPostError::orderBy('error_time', 'desc');

        // Optional filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('error_time', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('error_time', '<=', $request->date_to);
        }

        $errors = $query->paginate(50);
        $total = FbrPostError::count();
        $pending = FbrPostError::where('status', 'failed')->count();

        return view('backend.fbr.post_errors', compact('errors', 'total', 'pending'));
    }

    /**
     * Mark an error record as resolved.
     */
    public function markResolved($id)
    {
        $role = \App\Models\Roles::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('fbr-errors')) {
            return redirect()->back()->with('not_permitted', __('db.Sorry! You are not allowed to access this module'));
        }

        $record = FbrPostError::findOrFail($id);
        $record->status = 'resolved';
        $record->save();

        return redirect()->back()->with('success', 'FBR error marked as resolved.');
    }

    /**
     * Delete an error record.
     */
    public function deleteError($id)
    {
        $role = \App\Models\Roles::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('fbr-errors')) {
            return redirect()->back()->with('not_permitted', __('db.Sorry! You are not allowed to access this module'));
        }

        FbrPostError::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'FBR error record deleted.');
    }

    /**
     * Clear all resolved errors.
     */
    public function clearResolved()
    {
        $role = \App\Models\Roles::find(Auth::user()->role_id);
        if (!$role->hasPermissionTo('fbr-errors')) {
            return redirect()->back()->with('not_permitted', __('db.Sorry! You are not allowed to access this module'));
        }

        FbrPostError::where('status', 'resolved')->delete();

        return redirect()->back()->with('success', 'All resolved FBR errors cleared.');
    }
}
