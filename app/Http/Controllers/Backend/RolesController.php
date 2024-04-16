<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laracasts\Flash\Flash;

class RolesController extends Controller
{
    use Authorizable;

    public $module_title;

    public $module_name;

    public $module_path;

    public $module_icon;

    public $module_model;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Roles';

        // module name
        $this->module_name = 'roles';

        // directory path of the module
        $this->module_path = 'roles';

        // module icon
        $this->module_icon = 'fa-solid fa-user-shield';

        // module model name, path
        $this->module_model = "App\Models\Role";
    }

    /**
     * Retrieves all the records from the database and displays them in a paginated list.
     *
     * @return \Illuminate\View\View
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

        $$module_name = $module_model::with('permissions')->paginate();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view(
            "backend.{$module_path}.index",
            compact('module_title', 'module_name', "{$module_name}", 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
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

        $roles = Role::get();
        $permissions = Permission::select('name', 'id')->orderBy('id')->get();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view("backend.{$module_name}.create", compact('module_title', 'module_name', 'module_icon', 'module_action', 'roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\View\View
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

        $validated_data = $request->validate([
            'name' => 'required|max:100|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        // Update Name
        $data = Arr::except($validated_data, ['permissions']);
        $$module_name_singular = Role::create($data);

        // Sync Permissions
        $permissions = isset($validated_data['permissions']) ? $validated_data['permissions'] : [];
        $$module_name_singular->syncPermissions($permissions);

        flash("{$$module_name_singular->name} {$module_name_singular} created successfully!")->success()->important();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return redirect("admin/{$module_name}")->with('flash_success', "{$module_name} added!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @return \Illuminate\View\View
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

        $users = User::role($$module_name_singular->name)->get();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view(
            "backend.{$module_name}.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}", 'users')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit';

        $permissions = Permission::select('name', 'id')->orderBy('id')->get();

        $$module_name_singular = $module_model::findOrFail($id);

        Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view("backend.{$module_name}.edit", compact('module_title', 'module_name', "{$module_name_singular}", 'module_name_singular', 'module_icon', 'module_action', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @return \Illuminate\View\View
     */
    public function update(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        $$module_name_singular = $module_model::findOrFail($id);

        $validated_data = $request->validate([
            'name' => 'required|max:100|unique:roles,name,'.$id,
            'permissions' => 'nullable|array',
        ]);

        // Update Name
        $data = Arr::except($validated_data, ['permissions']);
        $$module_name_singular->update($data);

        // Update Permissions
        $permissions = isset($validated_data['permissions']) ? $validated_data['permissions'] : [];
        $$module_name_singular->syncPermissions($permissions);

        flash(label_case($$module_name_singular->name.' '.$module_name_singular).' updated successfully!')->success()->important();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return redirect("admin/{$module_name}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @return \Illuminate\View\View
     */
    public function destroy($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Destroy';

        $$module_name_singular = Role::findOrFail($id);
        $role_name = $$module_name_singular->name;

        $user_roles = auth()->user()->getRoleNames();

        $role_users = User::with('roles')->get()->filter(
            fn ($user) => $user->roles->where('name', $role_name)->toArray()
        )->count();

        if ($id == 1) {
            Flash::warning("You can not delete {$$module_name_singular->name} role!")->important();

            Log::notice(label_case($module_title.' '.$module_action).' Failed | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

            return redirect()->route("backend.{$module_name}.index");
        } elseif (in_array($role_name, $user_roles->toArray())) {
            Flash::warning('You can not delete your Role!')->important();

            Log::notice(label_case($module_title.' '.$module_action).' Failed | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

            return redirect()->route("backend.{$module_name}.index");
        } elseif ($role_users) {
            Flash::warning('Can not be deleted! '.$role_users.' user(s) found!')->important();

            Log::notice(label_case($module_title.' '.$module_action).' Failed | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

            return redirect()->route("backend.{$module_name}.index");
        }

        try {
            if ($$module_name_singular->delete()) {
                Flash::success('Role successfully deleted!')->important();

                Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

                return redirect()->route("backend.{$module_name}.index");
            }
        } catch (\Exception $e) {
            Log::error($e);

            Log::error('Can not delete role with id '.$id);
        }
    }
}
