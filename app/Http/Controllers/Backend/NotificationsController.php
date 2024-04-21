<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NotificationsController extends Controller
{
    public $module_title;

    public $module_name;

    public $module_path;

    public $module_icon;

    public $module_model;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Notifications';

        // module name
        $this->module_name = 'notifications';

        // directory path of the module
        $this->module_path = 'notifications';

        // module icon
        $this->module_icon = 'c-icon fas fa-bell';

        // module model name, path
        $this->module_model = "App\Models\User";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = auth()->user()->notifications()->paginate();
        $unread_notifications_count = auth()->user()->unreadNotifications()->count();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view(
            "backend.{$module_path}.index",
            compact('module_title', 'module_name', "{$module_name}", 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'unread_notifications_count')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $$module_name_singular = Notification::where('id', '=', $id)->where('notifiable_id', '=', auth()->user()->id)->first();

        if ($$module_name_singular) {
            if ($$module_name_singular->read_at === '') {
                $$module_name_singular->read_at = Carbon::now();
                $$module_name_singular->save();
            }
        } else {
            Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');
            abort(404);
        }

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view(
            "backend.{$module_name}.show",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "{$module_name_singular}")
        );
    }

    /**
     * Delete All the Notifications.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function deleteAll()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Delete All';

        $user = auth()->user();

        $user->notifications()->delete();

        flash('All Notifications Deleted')->success()->important();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return back();
    }

    /**
     * Marks all notifications as read for the authenticated user.
     *
     * @return Illuminate\Http\RedirectResponse the response to redirect back
     */
    public function markAllAsRead()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Mark All As Read';

        $user = auth()->user();

        $user->unreadNotifications()->update(['read_at' => now()]);

        flash('All Notifications Marked As Read')->success()->important();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return back();
    }
}
