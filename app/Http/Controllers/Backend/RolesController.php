<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    use Authorizable;

    public function __construct()
    {
        $this->module_name = 'roles';
        $this->module_path = 'roles';
        $this->module_icon = 'icon-user-following';
        $this->module_title = 'Roles';
        $this->module_model = 'App\Models\Role';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->module_title;

        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_title = $this->module_title;
        $module_model = $this->module_model;
        $module_action = 'Index';

        $page_heading = 'All Roles';

        $$module_name = $module_model::paginate();

        // Log::info($module_name . ' Index View');

        return view("backend.$module_name.index", compact('title', 'page_heading', 'module_icon', 'module_action', 'module_name', "$module_name"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->module_title;
        $module_name = $this->module_name;
        $module_icon = $this->module_icon;
        $module_action = 'Create';

        $roles = Role::get();
        $permissions = Permission::select('name', 'id')->get();

        return view("backend.$module_name.create", compact('title', 'module_name', 'module_icon', 'module_action', 'roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_action = 'Details';

        $$module_name_singular = Role::create($request->except('permissions'));

        $permissions = $request['permissions'];

        // Sync Permissions
        if (isset($permissions)) {
            $$module_name_singular->syncPermissions($permissions);
        } else {
            $permissions = [];
            $$module_name_singular->syncPermissions($permissions);
        }

        return redirect("admin/$module_name")->with('flash_success', "$module_name added!");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
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

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        $$module_name_singular = $module_model::findOrFail($id);

        return view("backend.$module_name.show",
        compact('module_title', 'module_name', "$module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular", 'page_heading', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_title = $this->module_title;
        $module_model = $this->module_model;
        $module_action = 'Edit';

        $permissions = Permission::select('name', 'id')->get();

        $$module_name_singular = $module_model::findOrFail($id);

        return view("backend.$module_name.edit", compact('module_name', "$module_name_singular", 'module_icon', 'module_action', 'title', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_title = $this->module_title;
        $module_model = $this->module_model;

        $$module_name_singular = $module_model::findOrFail($id);

        $this->validate($request, [
            'name'        => 'required|max:20|unique:roles,name,'.$id,
            'permissions' => 'required',
        ]);

        $input = $request->except(['permissions']);
        $permissions = $request['permissions'];
        $$module_name_singular->fill($input)->save();

        $p_all = Permission::all(); //Get all permissions

        foreach ($p_all as $p) {
            $$module_name_singular->revokePermissionTo($p); //Remove all permissions associated with role
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('name', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
            $$module_name_singular->givePermissionTo($p);  //Assign permission to role
        }

        return redirect("admin/$module_name")->with('flash_success', 'Update successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (auth()->id() == $id) {
            throw new GeneralException('You can not delete yourself.');
        }

        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        $$module_name_singular = Role::withTrashed()->find($id);
        //        $$module_name_singular = $this->findOrThrowException($id);

        if ($$module_name_singular->delete()) {
            Flash::success('User successfully deleted!');

            return redirect()->back();
        }

        throw new GeneralException('There was a problem updating this user. Please try again.');
    }

    public function restore($id)
    {
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        $module_action = 'Restore';

        $$module_name_singular = Role::withTrashed()->find($id);
        $$module_name_singular->restore();

        return redirect("admin/$module_name")->with('flash_success', '<i class="fa fa-check"></i> '.label_case($module_name_singular).' Restored Successfully!');
    }
}
