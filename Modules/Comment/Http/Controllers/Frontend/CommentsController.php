<?php

namespace Modules\Comment\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Modules\Comment\Notifications\NewCommentAdded;

class CommentsController extends Controller
{
    public $module_title;

    public $module_name;

    public $module_path;

    public $module_icon;

    public $module_model;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Comments';

        // module name
        $this->module_name = 'comments';

        // module icon
        $this->module_icon = 'fas fa-comments';

        // module model name, path
        $this->module_model = "Modules\Comment\Models\Comment";
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
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::latest()->published()->with('commentable')->paginate();

        return view(
            "comment::frontend.{$module_name}.index",
            compact('module_title', 'module_name', "{$module_name}", 'module_icon', 'module_action', 'module_name_singular')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $id = decode_id($id);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $$module_name_singular = $module_model::whereId($id)->published()->first();

        if (! $$module_name_singular) {
            abort(404);
        }

        return view(
            "comment::frontend.{$module_name}.show",
            compact('module_title', 'module_name', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}")
        );
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
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Store';

        $validated = $request->validate([
            'name' => 'required|max:191',
            'comment' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'comment' => $request->comment,
            'user_id' => isset($request->user_id) ? decode_id($request->user_id) : null,
            'parent_id' => isset($request->parent_id) ? decode_id($request->parent_id) : null,
        ];

        if (isset($request->post_id)) {
            $commentable_id = decode_id($request->post_id);

            $commentable_type = "Modules\Article\Models\Post";

            $row = $commentable_type::findOrFail($commentable_id);

            $$module_name_singular = $row->comments()->create($data);
        }

        if (isset($$module_name_singular)) {
            auth()->user()->notify(new NewCommentAdded($$module_name_singular));
        }

        flash()->success(__("New '".Str::singular($module_title)."' Added"))->important();

        Log::info(label_case($module_title.' '.$module_action)." | '".$$module_name_singular->name.'(ID:'.$$module_name_singular->id.") ' by User:".Auth::user()->name.'(ID:'.Auth::user()->id.')');

        return redirect()->back();
    }
}
