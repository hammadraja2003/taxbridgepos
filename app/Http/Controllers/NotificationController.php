<?php

namespace App\Http\Controllers;

use App\Models\Roles as Role;
use App\Models\User;
use App\Notifications\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class NotificationController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('all_notification')) {
            if (Auth::user()->role_type <= 2) {
                $lims_notification_all = DB::table('notifications')->get();
            } else {
                $lims_notification_all = DB::table('notifications')->where('notifiable_id', Auth::user()->id)->get();
            }
            return view('backend.notification.index', compact('lims_notification_all'));
        } else
            return redirect()->back()->with('not_permitted', __('db.Sorry! You are not allowed to access this module'));
    }

    public function store(Request $request)
    {
        $document = $request->document;
        if ($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());

            $documentName = date('Ymdhis') . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('documents/notification'), $documentName);
            $request->document_name = $documentName;
        }
        $user = User::find($request->receiver_id);
        $user->notify(new SendNotification($request));
        return redirect()->back()->with('message', __('db.Notification send successfully'));
    }

    // public function markAsRead()
    // {
    //     Auth::user()->unreadNotifications->where('data.reminder_date', date('Y-m-d'))->markAsRead();
    // }

    public function markAsRead($id)
    {
        $notification = Auth::user()->unreadNotifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        // Optionally return back to previous page or json for AJAX
        return response()->json([
            'success' => true,
            'notification_id' => $id
        ]);
    }
}
