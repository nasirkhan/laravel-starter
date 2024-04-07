<?php

namespace Modules\Post\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Support\Str;
use Modules\Category\Models\Category;

class PostsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Posts';

        // module name
        $this->module_name = 'posts';

        // directory path of the module
        $this->module_path = 'post::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-file-lines';

        // module model name, path
        $this->module_model = "Modules\Post\Models\Post";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Create';

        $categories = Category::pluck('name', 'id');

        logUserAccess($module_title.' '.$module_action);

        return view(
            "{$module_path}.{$module_name}.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action', 'categories')
        );
    }
}
