<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Log;

class SettingController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'Settings';

        // module name
        $this->module_name = 'settings';

        // directory path of the module
        $this->module_path = 'settings';

        // module icon
        $this->module_icon = 'fas fa-cogs';

        // module model name, path
        $this->module_model = "App\Models\Setting";
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
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::paginate();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view(
            "backend.$module_path.index",
            compact('module_title', 'module_name', "$module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular')
        );
    }

    public function store(Request $request)
    {
        $rules = Setting::getValidationRules();
        $data = $this->validate($request, $rules);

        $validSettings = array_keys($rules);

        foreach ($data as $key => $val) {
            if (in_array($key, $validSettings)) {
                Setting::add($key, $val, Setting::getDataType($key));
            }
        }

        return redirect()->back()->with('status', 'Settings has been saved.');
    }
}
