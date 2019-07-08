<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Log;

class NotificationsController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'Notifications';

        // module name
        $this->module_name = 'notifications';

        // directory path of the module
        $this->module_path = 'notifications';

        // module icon
        $this->module_icon = 'fas fa-bell';

        // module model name, path
        $this->module_model = "App\Models\User";
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = str_singular($module_name);

        $module_action = 'List';

        $$module_name = auth()->user()->notifications()->paginate();
        $unread_notifications_count = auth()->user()->unreadNotifications()->count();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view("backend.$module_path.index",
        compact('module_title', 'module_name', "$module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'unread_notifications_count'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = str_singular($module_name);

        $module_action = 'Show';

        $$module_name_singular = Notification::where('id', '=', $id)->first();

        if ($$module_name_singular->read_at == '') {
            $$module_name_singular->read_at = Carbon::now();
            $$module_name_singular->save();
        }

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view("backend.$module_name.show",
        compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "$module_name_singular"));
    }
}
