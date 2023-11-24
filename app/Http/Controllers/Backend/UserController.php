<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\Events\Backend\UserCreated;
use App\Events\Backend\UserProfileUpdated;
use App\Events\Backend\UserUpdated;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Userprofile;
use App\Models\UserProvider;
use App\Notifications\UserAccountCreated;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laracasts\Flash\Flash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
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
        $this->module_title = 'Users';

        // module name
        $this->module_name = 'users';

        // directory path of the module
        $this->module_path = 'users';

        // module icon
        $this->module_icon = 'fa-solid fa-user-group';

        // module model name, path
        $this->module_model = "App\Models\User";
    }

    /**
     * Retrieves the index page for the module.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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

        $page_heading = ucfirst($module_title);
        $title = $page_heading.' '.ucfirst($module_action);

        $$module_name = $module_model::paginate();

        Log::info("'{$title}' viewed by User:".auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view(
            "backend.{$module_path}.index",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'page_heading', 'title')
        );
    }

    public function index_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::select('id', 'name', 'username', 'email', 'email_verified_at', 'updated_at', 'status');

        $data = $$module_name;

        return Datatables::of($$module_name)
            ->addColumn('action', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.user_actions', compact('module_name', 'data'));
            })
            ->addColumn('user_roles', function ($data) {
                $module_name = $this->module_name;

                return view('backend.includes.user_roles', compact('module_name', 'data'));
            })
            ->editColumn('name', '<strong>{{$name}}</strong>')
            ->editColumn('status', function ($data) {
                $return_data = $data->status_label;
                $return_data .= '<br>'.$data->confirmed_label;

                return $return_data;
            })
            ->editColumn('updated_at', function ($data) {
                $module_name = $this->module_name;

                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                }

                return $data->updated_at->isoFormat('LLLL');
            })
            ->rawColumns(['name', 'action', 'status', 'user_roles'])
            ->orderColumns(['id'], '-:column $1')
            ->make(true);
    }

    /**
     * Retrieves a list of items based on the search term.
     *
     * @param  Request  $request  The HTTP request object.
     * @return JsonResponse The JSON response containing the list of items.
     *
     * @throws None
     */
    public function index_list(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $query_data = $module_model::where('name', 'LIKE', "%{$term}%")->orWhere('email', 'LIKE', "%{$term}%")->limit(10)->get();

        $$module_name = [];

        foreach ($query_data as $row) {
            $$module_name[] = [
                'id' => $row->id,
                'text' => $row->name.' (Email: '.$row->email.')',
            ];
        }

        return response()->json($$module_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
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
        $permissions = Permission::select('name', 'id')->get();

        return view(
            "backend.{$module_name}.create",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'roles', 'permissions')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function store(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Details';

        $request->validate([
            'first_name' => 'required|min:3|max:191',
            'last_name' => 'required|min:3|max:191',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:191|unique:users',
            'password' => 'required|confirmed|min:4',
        ]);

        $data_array = $request->except('_token', 'roles', 'permissions', 'password_confirmation');
        $data_array['name'] = $request->first_name.' '.$request->last_name;
        $data_array['password'] = Hash::make($request->password);

        if ($request->confirmed === 1) {
            $data_array = Arr::add($data_array, 'email_verified_at', Carbon::now());
        } else {
            $data_array = Arr::add($data_array, 'email_verified_at', null);
        }

        $$module_name_singular = User::create($data_array);

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

        // Username
        $id = $$module_name_singular->id;
        $username = config('app.initial_username') + $id;
        $$module_name_singular->username = $username;
        $$module_name_singular->save();

        event(new UserCreated($$module_name_singular));

        Flash::success("<i class='fas fa-check'></i> New '".Str::singular($module_title)."' Created")->important();

        if ($request->email_credentials === 1) {
            $data = [
                'password' => $request->password,
            ];
            $$module_name_singular->notify(new UserAccountCreated($data));

            Flash::success(icon('fas fa-envelope').' Account Credentials Sent to User.')->important();
        }

        Log::info(label_case($module_title.' '.$module_action)." | '".$$module_name_singular->name.'(ID:'.$$module_name_singular->id.") ' by User:".auth()->user()->name.'(ID:'.auth()->user()->id.')');

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
        $userprofile = Userprofile::where('user_id', $$module_name_singular->id)->first();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view(
            "backend.{$module_name}.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}", 'userprofile')
        );
    }

    /**
     * Display Profile Details of Logged in user.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function profile(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Profile Show';

        $$module_name_singular = $module_model::with('roles', 'permissions')->findOrFail($id);

        if ($$module_name_singular) {
            $userprofile = Userprofile::where('user_id', $id)->first();
        } else {
            Log::error('UserProfile Exception for Username: '.$username);
            abort(404);
        }

        Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view("backend.{$module_name}.profile", compact('module_name', 'module_name_singular', "{$module_name_singular}", 'module_icon', 'module_action', 'module_title', 'userprofile'));
    }

    /**
     * Edit the profile.
     *
     * @param  int  $id  The ID of the profile to edit.
     * @return Illuminate\View\View The view for editing the profile.
     *
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If the profile is not found.
     */
    public function profileEdit($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit Profile';

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = $module_model::findOrFail($id);
        $userprofile = Userprofile::where('user_id', $$module_name_singular->id)->first();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view(
            "backend.{$module_name}.profileEdit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}", 'userprofile')
        );
    }

    /**
     * Updates the user profile.
     *
     * @param  Request  $request  The request object.
     * @param  int  $id  The ID of the user.
     * @return RedirectResponse The response redirecting to the user's profile page.
     */
    public function profileUpdate(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit Profile';

        $this->validate($request, [
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'first_name' => 'required|min:3|max:191',
            'last_name' => 'required|min:3|max:191',
            'email' => 'required|email|regex:/(.+)@(.+)\.(.+)/i|max:191|unique:'.$module_model.',email,'.$id,
        ]);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = User::findOrFail($id);

        // Handle Avatar upload
        if ($request->hasFile('avatar')) {
            if ($$module_name_singular->getMedia($module_name)->first()) {
                $$module_name_singular->getMedia($module_name)->first()->delete();
            }

            $media = $$module_name_singular->addMedia($request->file('avatar'))->toMediaCollection($module_name);

            $$module_name_singular->avatar = $media->getUrl();

            $$module_name_singular->save();
        }

        $data_array = $request->except('avatar');
        $data_array['avatar'] = $$module_name_singular->avatar;
        $data_array['name'] = $request->first_name.' '.$request->last_name;

        $user_profile = Userprofile::where('user_id', '=', $$module_name_singular->id)->first();
        $user_profile->update($data_array);

        event(new UserProfileUpdated($user_profile));

        Flash::success(icon().' '.label_case($module_name_singular).' Updated Successfully!')->important();

        Log::info(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return redirect(route('backend.users.profile', $$module_name_singular->id));
    }

    /**
     * Change the password of the user's profile.
     *
     * @param  int  $id  The ID of the user whose password will be changed. If the user does not have the "edit_users" permission, the ID will be set to the current authenticated user's ID.
     * @return \Illuminate\View\View The view that displays the form to change the profile password.
     */
    public function changeProfilePassword($id)
    {
        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $title = $this->module_title;
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = Str::singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_action = 'Edit';

        $$module_name_singular = User::findOrFail($id);

        return view("backend.{$module_name}.changeProfilePassword", compact('module_name', 'module_title', "{$module_name_singular}", 'module_icon', 'module_action'));
    }

    /**
     * Change the profile password for a user.
     *
     * @param  Request  $request  The HTTP request object.
     * @param  int  $id  The user ID.
     * @return \Illuminate\Http\RedirectResponse Redirects to the user's profile page.
     *
     * @throws \Illuminate\Validation\ValidationException If the validation fails.
     */
    public function changeProfilePasswordUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = User::findOrFail($id);

        $request_data = $request->only('password');
        $request_data['password'] = Hash::make($request_data['password']);

        $$module_name_singular->update($request_data);

        Flash::success(icon()." '".Str::singular($module_title)."' Updated Successfully")->important();

        return redirect("admin/{$module_name}/profile/{$id}");
    }

    /**
     * Updates the password for a user.
     *
     * @param  int  $id  The ID of the user whose password will be changed.
     * @return \Illuminate\Contracts\View\View The view for the "Change Password" page.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user cannot be found.
     */
    public function changePassword($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Change Password';

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = $module_model::findOrFail($id);

        return view(
            "backend.{$module_name}.changePassword",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}")
        );
    }

    /**
     * Updates the password for a user.
     *
     * @param  Request  $request  The request object containing the new password.
     * @param  int  $id  The ID of the user whose password is being updated.
     * @return \Illuminate\Http\RedirectResponse The response object redirecting to the admin module.
     *
     * @throws \Illuminate\Validation\ValidationException If the validation fails.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the user with the given ID is not found.
     */
    public function changePasswordUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = User::findOrFail($id);

        $request_data = $request->only('password');
        $request_data['password'] = Hash::make($request_data['password']);

        $$module_name_singular->update($request_data);

        Flash::success("<i class='fas fa-check'></i> '".Str::singular($module_title)."' Updated Successfully")->important();

        return redirect("admin/{$module_name}");
    }

    /**
     * Edit a record in the database.
     *
     * @param  int  $id  The ID of the record to be edited.
     * @return \Illuminate\View\View The view for editing the record.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException If the user does not have the permission to edit users.
     */
    public function edit($id)
    {
        if (! auth()->user()->can('edit_users')) {
            abort(404);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit';

        $$module_name_singular = $module_model::findOrFail($id);

        $userRoles = $$module_name_singular->roles->pluck('name')->all();
        $userPermissions = $$module_name_singular->permissions->pluck('name')->all();

        $roles = Role::get();
        $permissions = Permission::select('name', 'id')->get();

        Log::info(label_case($module_title.' '.$module_action)." | '".$$module_name_singular->name.'(ID:'.$$module_name_singular->id.") ' by User:".auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view(
            "backend.{$module_name}.edit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}", 'roles', 'permissions', 'userRoles', 'userPermissions')
        );
    }

    /**
     * Updates a user with the given ID.
     *
     * @param  Request  $request  The HTTP request object.
     * @param  int  $id  The ID of the user to update.
     * @return RedirectResponse The redirect response to the admin module.
     *
     * @throws NotFoundHttpException If the authenticated user does not have the 'edit_users' permission.
     */
    public function update(Request $request, $id)
    {
        if (! auth()->user()->can('edit_users')) {
            abort(404);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        $$module_name_singular = User::findOrFail($id);

        $$module_name_singular->update($request->except(['roles', 'permissions']));

        if ($id === 1) {
            $user->syncRoles(['super admin']);

            return redirect("admin/{$module_name}")->with('flash_success', 'Update successful!');
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

        event(new UserUpdated($$module_name_singular));

        Flash::success("<i class='fas fa-check'></i> '".Str::singular($module_title)."' Updated Successfully")->important();

        Log::info(label_case($module_title.' '.$module_action)." | '".$$module_name_singular->name.'(ID:'.$$module_name_singular->id.") ' by User:".auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return redirect("admin/{$module_name}");
    }

    /**
     * Deletes a user by their ID.
     *
     * @param  int  $id  The ID of the user to be deleted.
     * @return Illuminate\Http\RedirectResponse
     *
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException If the user with the given ID is not found.
     */
    public function destroy($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'destroy';

        if (auth()->user()->id === $id || $id === 1) {
            Flash::warning("<i class='fas fa-exclamation-triangle'></i> You can not delete this user!")->important();

            Log::notice(label_case($module_title.' '.$module_action).' Failed | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

            return redirect()->back();
        }

        $$module_name_singular = $module_model::findOrFail($id);

        $$module_name_singular->delete();

        event(new UserUpdated($$module_name_singular));

        flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' User Successfully Deleted!')->success();

        Log::info(label_case($module_action)." '{$module_name}': '".$$module_name_singular->name.', ID:'.$$module_name_singular->id." ' by User:".auth()->user()->name);

        return redirect("admin/{$module_name}");
    }

    /**
     * Retrieves and displays a list of deleted records for the specified module.
     *
     * @return \Illuminate\View\View the view for the list of deleted records
     */
    public function trashed()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Deleted List';
        $page_heading = $module_title;

        $$module_name = $module_model::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate();

        Log::info(label_case($module_action).' '.label_case($module_name).' by User:'.auth()->user()->name);

        return view(
            "backend.{$module_name}.trash",
            compact('module_name', 'module_title', "{$module_name}", 'module_icon', 'page_heading', 'module_action')
        );
    }

    /**
     * Restores a record in the database.
     *
     * @param  int  $id  The ID of the record to be restored.
     * @return Illuminate\Http\RedirectResponse The redirect response to the admin module page.
     */
    public function restore($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Restore';

        $$module_name_singular = $module_model::withTrashed()->find($id);

        $$module_name_singular->restore();

        $$module_name_singular->userprofile()->withTrashed()->restore();

        event(new UserUpdated($$module_name_singular));

        flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' Successfully Restoreded!')->success();

        Log::info(label_case($module_action)." '{$module_name}': '".$$module_name_singular->name.', ID:'.$$module_name_singular->id." ' by User:".auth()->user()->name);

        return redirect("admin/{$module_name}");
    }

    /**
     * Block a user.
     *
     * @param  int  $id  The ID of the user to block.
     * @return Illuminate\Http\RedirectResponse
     *
     * @throws Exception There was a problem updating this user. Please try again.
     */
    public function block($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Block';

        if (auth()->user()->id === $id || $id === 1) {
            Flash::warning("<i class='fas fa-exclamation-triangle'></i> You can not 'Block' this user!")->important();

            Log::notice(label_case($module_title.' '.$module_action).' Failed | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

            return redirect()->back();
        }

        $$module_name_singular = User::withTrashed()->find($id);

        try {
            $$module_name_singular->status = 2;
            $$module_name_singular->save();

            event(new UserUpdated($$module_name_singular));

            flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' User Successfully Blocked!')->success();

            return redirect()->back();
        } catch (Exception $e) {
            throw new Exception('There was a problem updating this user. Please try again.');
        }
    }

    /**
     * Unblock a user.
     *
     * @param  int  $id  The ID of the user to unblock.
     * @return RedirectResponse The redirect back to the previous page.
     *
     * @throws Exception If there is a problem updating the user.
     */
    public function unblock($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Unblock';

        if (auth()->user()->id === $id || $id === 1) {
            Flash::warning("<i class='fas fa-exclamation-triangle'></i> You can not 'Unblock' this user!")->important();

            Log::notice(label_case($module_title.' '.$module_action).' Failed | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

            return redirect()->back();
        }

        $$module_name_singular = User::withTrashed()->find($id);

        try {
            $$module_name_singular->status = 1;
            $$module_name_singular->save();

            event(new UserUpdated($$module_name_singular));

            flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' User Successfully Unblocked!')->success();

            Log::notice(label_case($module_title.' '.$module_action).' Success | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

            return redirect()->back();
        } catch (Exception $e) {
            flash('<i class="fas fa-check"></i> There was a problem updating this user. Please try again.!')->error();

            Log::error(label_case($module_title.' '.$module_action).' | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');
            Log::error($e);
        }
    }

    /**
     * Destroy a user provider.
     *
     * @param  Request  $request  The request object.
     * @return void
     *
     * @throws Exception There was a problem updating this user. Please try again.
     */
    public function userProviderDestroy(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $user_provider_id = $request->user_provider_id;
        $user_id = $request->user_id;

        if (! $user_provider_id > 0 || ! $user_id > 0) {
            flash('Invalid Request. Please try again.')->error();

            return redirect()->back();
        }
        $user_provider = UserProvider::findOrFail($user_provider_id);

        if ($user_id === $user_provider->user->id) {
            $user_provider->delete();

            flash('<i class="fas fa-exclamation-triangle"></i> Unlinked from User, "'.$user_provider->user->name.'"!')->success();

            return redirect()->back();
        }
        flash('<i class="fas fa-exclamation-triangle"></i> Request rejected. Please contact the Administrator!')->warning();

        event(new UserUpdated($$module_name_singular));

        throw new Exception('There was a problem updating this user. Please try again.');
    }

    /**
     * Resends the email confirmation for a user.
     *
     * @param  int  $id  The ID of the user.
     * @return \Illuminate\Http\RedirectResponse Returns a redirect response.
     *
     * @throws \Illuminate\Http\Client\RequestException If the user is not authorized to resend the email confirmation.
     */
    public function emailConfirmationResend($id)
    {
        if ($id !== auth()->user()->id) {
            if (auth()->user()->hasAnyRole(['administrator', 'super admin'])) {
                Log::info(auth()->user()->name.' ('.auth()->user()->id.') - User Requested for Email Verification.');
            } else {
                Log::warning(auth()->user()->name.' ('.auth()->user()->id.') - User trying to confirm another users email.');

                abort('404');
            }
        }

        $user = User::where('id', '=', $id)->first();

        if ($user) {
            if ($user->email_verified_at === null) {
                Log::info($user->name.' ('.$user->id.') - User Requested for Email Verification.');

                // Send Email To Registered User
                $user->sendEmailVerificationNotification();

                flash('<i class="fas fa-check"></i> Email Sent! Please Check Your Inbox.')->success()->important();

                return redirect()->back();
            }
            Log::info($user->name.' ('.$user->id.') - User Requested but Email already verified at.'.$user->email_verified_at);

            flash($user->name.', You already confirmed your email address at '.$user->email_verified_at->isoFormat('LL'))->success()->important();

            return redirect()->back();
        }
    }
}
