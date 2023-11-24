<?php

namespace Modules\Comment\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Comment\Notifications\NewCommentAdded;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class CommentsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Comments';

        // module name
        $this->module_name = 'comments';

        // directory path of the module
        $this->module_path = 'comment::backend';

        // module icon
        $this->module_icon = 'fas fa-comments';

        // module model name, path
        $this->module_model = "Modules\Comment\Models\Comment";
    }

    public function index_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::select('id', 'name', 'status', 'updated_at');

        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.action_column', compact('module_name', 'data'));
            })
            ->editColumn('name', function ($data) {
                return '<strong>'.$data->name.'</strong> | '.$data->status_formatted;
            })
            ->editColumn('updated_at', function ($data) {
                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                }

                return $data->updated_at->isoFormat('LLLL');
            })
            ->rawColumns(['name', 'action'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $$module_name_singular = $module_model::create($request->all());

        auth()->user()->notify(new NewCommentAdded($$module_name_singular));

        flash("<i class='fas fa-check'></i> New '".Str::singular($module_title)."' Added")->success()->important();

        Log::info(label_case($module_title.' '.$module_action)." | '".$$module_name_singular->name.'(ID:'.$$module_name_singular->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return redirect("admin/{$module_name}");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
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

        $$module_name_singular = $module_model::findOrFail($id);

        $activities = Activity::where('subject_type', '=', $module_model)
            ->where('log_name', '=', $module_name)
            ->where('subject_id', '=', $id)
            ->latest()
            ->paginate();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return view(
            "{$module_path}.{$module_name}.show",
            compact('module_title', 'module_name', 'module_icon', 'module_name_singular', 'module_action', "{$module_name_singular}", 'activities')
        );
    }
}
