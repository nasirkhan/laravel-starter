<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProvider;
use Illuminate\Http\Request;
use Image;

class UserController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = 'Users';

        // module name
        $this->module_name = 'users';

        // directory path of the module
        $this->module_path = 'users';

        // module icon
        $this->module_icon = 'fas fa-users';

        // module model name, path
        $this->module_model = "App\Models\User";
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
        $module_icon = $this->module_icon;
        $module_action = 'Index';

        $page_heading = 'All Users';

        $$module_name = User::paginate();

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
        $request->validate([
            'name'     => 'required|min:3|max:50',
            'email'    => 'email',
            'password' => 'required|confirmed|min:4',
        ]);

        $title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_action = 'Details';

        $$module_name_singular = User::create($request->except('roles'));

        $roles = $request['roles'];
        $permissions = $request['permissions'];

        // Sync Roles
        if (isset($roles)) {
            $$module_name_singular->syncRoles($roles);
        } else {
            $roles = [];
            $$module_name_singular->syncRoles($roles);
        }

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
        $title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_action = 'Show';

        $$module_name_singular = User::findOrFail($id);

        return view("backend.$module_name.show", compact('module_name', "$module_name_singular", 'module_icon', 'module_action', 'title'));
    }

    /**
     * Display Profile Details of Logged in user.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $title = $this->module_title;
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_action = 'Show';

        $id = auth()->user()->id;

        $$module_name_singular = User::findOrFail($id);

        return view("backend.$module_name.profile", compact('module_name', "$module_name_singular", 'module_icon', 'module_action', 'module_title'));
    }

    /**
     * Show the form for Profile Paeg Editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function profileEdit()
    {
        $title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_action = 'Edit';

        $id = auth()->user()->id;

        $$module_name_singular = User::findOrFail($id);

        return view("backend.$module_name.profileEdit", compact('module_name', "$module_name_singular", 'module_icon', 'module_action', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request)
    {
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        $id = auth()->user()->id;

        $$module_name_singular = User::findOrFail($id);

        $$module_name_singular->update($request->only('name', 'email'));

        // Handle Avatar upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = 'avatar-'.$$module_name_singular->id.'.'.$avatar->getClientOriginalExtension();
            $img = Image::make($avatar)->resize(null, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/photos/avatars/'.$filename));
            $$module_name_singular->avatar = $filename;
            $$module_name_singular->save();
        }

        return redirect("admin/$module_name/profile")->with('flash_success', 'Update successful!');
    }

    /**
     * Show the form for Profile Paeg Editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword()
    {
        $title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_action = 'Edit';

        $id = auth()->user()->id;

        $$module_name_singular = User::findOrFail($id);

        return view("backend.$module_name.changePassword", compact('module_name', "$module_name_singular", 'module_icon', 'module_action', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function changePasswordUpdate(Request $request)
    {
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        $id = auth()->user()->id;

        $$module_name_singular = User::findOrFail($id);

        $$module_name_singular->update($request->only('password'));

        return redirect("admin/$module_name/profile")->with('flash_success', 'Update successful!');
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
        $module_action = 'Edit';

        $roles = Role::get();
        $permissions = Permission::select('name', 'id')->get();

        $$module_name_singular = User::findOrFail($id);

        $userRoles = $$module_name_singular->roles->pluck('name')->all();
        $userPermissions = $$module_name_singular->permissions->pluck('name')->all();

        return view("backend.$module_name.edit", compact('userRoles', 'userPermissions', 'module_name', "$module_name_singular", 'module_icon', 'module_action', 'title', 'roles', 'permissions'));
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

        $$module_name_singular = User::findOrFail($id);

        $$module_name_singular->update($request->except(['roles', 'permissions']));

        if ($id == 1) {
            $user->syncRoles(['administrator']);

            return redirect("admin/$module_name")->with('flash_success', 'Update successful!');
        }

        $roles = $request['roles'];
        $permissions = $request['permissions'];

        // Sync Roles
        if (isset($roles)) {
            $$module_name_singular->syncRoles($roles);
        } else {
            $roles = [];
            $$module_name_singular->syncRoles($roles);
        }

        // Sync Permissions
        if (isset($permissions)) {
            $$module_name_singular->syncPermissions($permissions);
        } else {
            $permissions = [];
            $$module_name_singular->syncPermissions($permissions);
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

        $$module_name_singular = User::withTrashed()->find($id);
        // $$module_name_singular = $this->findOrThrowException($id);

        if ($$module_name_singular->delete()) {
            Flash::success('User successfully deleted!');

            return redirect()->back();
        }

        throw new GeneralException('There was a problem updating this user. Please try again.');
    }

    /**
     * Block Any Specific User.
     *
     * @param int $id User Id
     *
     * @return Back To Previous Page
     */
    public function block($id)
    {
        if (auth()->id() == $id) {
            throw new GeneralException('You can not `Block` yourself.');
        }

        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        $$module_name_singular = User::withTrashed()->find($id);
        // $$module_name_singular = $this->findOrThrowException($id);

        try {
            $$module_name_singular->status = 2;
            $$module_name_singular->save();

            flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' User Successfully Blocked!')->success();

            return redirect()->back();
        } catch (\Exception $e) {
            throw new GeneralException('There was a problem updating this user. Please try again.');
        }
    }

    /**
     * Unblock Any Specific User.
     *
     * @param int $id User Id
     *
     * @return Back To Previous Page
     */
    public function unblock($id)
    {
        if (auth()->id() == $id) {
            throw new GeneralException('You can not `Unblocked` yourself.');
        }

        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        $$module_name_singular = User::withTrashed()->find($id);
        // $$module_name_singular = $this->findOrThrowException($id);

        try {
            $$module_name_singular->status = 1;
            $$module_name_singular->save();

            flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' User Successfully Unblocked!')->success();

            return redirect()->back();
        } catch (\Exception $e) {
            throw new GeneralException('There was a problem updating this user. Please try again.');
        }
    }

    public function restore($id)
    {
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        $module_action = 'Restore';

        $$module_name_singular = User::withTrashed()->find($id);
        $$module_name_singular->restore();

        return redirect("admin/$module_name")->with('flash_success', '<i class="fa fa-check"></i> '.ucfirst($module_name_singular).' Restored Successfully!');
    }

    /**
     * Remove the Social Account attached with a User.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function userProviderDestroy(Request $request)
    {
        $user_provider_id = $request->user_provider_id;
        $user_id = $request->user_id;

        if (!$user_provider_id > 0 || !$user_id > 0) {
            flash('Invalid Request. Please try again.')->error();

            return redirect()->back();
        } else {
            $user_provider = UserProvider::findOrFail($user_provider_id);

            if ($user_id == $user_provider->user->id) {
                $user_provider->delete();

                flash('<i class="fas fa-exclamation-triangle"></i> Unlinked from User, "'.$user_provider->user->name.'"!')->success();

                return redirect()->back();
            } else {
                flash('<i class="fas fa-exclamation-triangle"></i> Request rejected. Please contact the Administrator!')->warning();
            }
        }

        throw new GeneralException('There was a problem updating this user. Please try again.');
    }
}
