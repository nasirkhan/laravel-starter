<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\Events\Backend\UserCreated;
use App\Events\Backend\UserUpdated;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserProvider;
use App\Notifications\UserAccountCreated;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
        $this->module_path = 'backend';

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

        logUserAccess($module_title.' '.$module_action);

        return view(
            "{$module_path}.{$module_name}.index",
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

        $module_action = 'Index List';

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

        logUserAccess($module_title.' '.$module_action);

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
        $permissions = Permission::select('name', 'id')->orderBy('id')->get();

        logUserAccess($module_title.' '.$module_action);

        return view(
            "{$module_path}.{$module_name}.create",
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

        $validated_data = $request->validate([
            'first_name' => 'required|min:3|max:191',
            'last_name' => 'required|min:3|max:191',
            'email' => 'required|email:rfc,dns|regex:/(.+)@(.+)\.(.+)/i|max:191|unique:users',
            'password' => 'required|confirmed|min:6',
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $data_array = Arr::except($validated_data, ['_token', 'roles', 'permissions', 'password_confirmation']);

        $data_array['name'] = $request->first_name.' '.$request->last_name;
        $data_array['password'] = Hash::make($request->password);

        if ($request->confirmed === 1) {
            $data_array = Arr::add($data_array, 'email_verified_at', Carbon::now());
        } else {
            $data_array = Arr::add($data_array, 'email_verified_at', null);
        }

        // Create a User
        $$module_name_singular = User::create($data_array);

        // Sync Roles
        $$module_name_singular->syncRoles(isset($validated_data['roles']) ? $validated_data['roles'] : []);

        // Sync Permissions
        $$module_name_singular->syncPermissions(isset($validated_data['permissions']) ? $validated_data['permissions'] : []);

        // Set Username
        $id = $$module_name_singular->id;
        $username = config('app.initial_username') + $id;
        $$module_name_singular->username = $username;
        $$module_name_singular->save();

        event(new UserCreated($$module_name_singular));

        flash("New '".Str::singular($module_title)."' Created")->success()->important();

        if ($request->email_credentials === 1) {
            $data = [
                'password' => $request->password,
            ];
            $$module_name_singular->notify(new UserAccountCreated($data));

            flash('Account Credentials Sent to User.')->success()->important();
        }

        Artisan::call('cache:clear');

        logUserAccess($module_title.' '.$module_action);

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

        logUserAccess(__METHOD__." | {$$module_name_singular->name} ($id)");

        return view(
            "{$module_path}.{$module_name}.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}")
        );
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

        logUserAccess("{$module_title} {$module_action} {$$module_name_singular->name} ($id)");

        return view(
            "{$module_path}.{$module_name}.changePassword",
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
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Change Password Update';

        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = User::findOrFail($id);

        $request_data = $request->only('password');
        $request_data['password'] = Hash::make($request_data['password']);

        $$module_name_singular->update($request_data);

        flash(Str::singular($module_title)."' Updated Successfully")->success()->important();

        logUserAccess("{$module_title} {$module_action} {$$module_name_singular->name} ($id)");

        return redirect("admin/{$module_name}/{$id}");
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
            $id = auth()->user()->id;
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
        $permissions = Permission::select('name', 'id')->orderBy('id')->get();

        logUserAccess("{$module_title} {$module_action} {$$module_name_singular->name} ($id)");

        return view(
            "{$module_path}.{$module_name}.edit",
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
            $id = auth()->user()->id;
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Update';

        $validated_data = $request->validate([
            'first_name' => 'required|min:3|max:191',
            'last_name' => 'required|min:3|max:191',
            'email' => 'required|email:rfc,dns|regex:/(.+)@(.+)\.(.+)/i|max:191|unique:users,email,'.$id,
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $validated_data['name'] = $validated_data['first_name'].' '.$validated_data['last_name'];

        $$module_name_singular = User::findOrFail($id);

        $$module_name_singular->update(Arr::except($validated_data, ['roles', 'permissions']));

        if ($id === 1) {
            $user->syncRoles(['super admin']);

            // Clear Cache
            Artisan::call('cache:clear');

            flash(Str::singular($module_title)."' Updated Successfully")->success()->important();

            return redirect("admin/{$module_name}");
        }

        // Clear Cache
        Artisan::call('cache:clear');

        // Sync Roles
        $$module_name_singular->syncRoles((isset($validated_data['roles'])) ? $validated_data['roles'] : []);

        // Sync Permissions
        $$module_name_singular->syncPermissions((isset($validated_data['permissions'])) ? $validated_data['permissions'] : []);

        // Clear Cache
        Artisan::call('cache:clear');

        event(new UserUpdated($$module_name_singular));

        flash(Str::singular($module_title)."' Updated Successfully")->success()->important();

        logUserAccess("{$module_title} {$module_action} {$$module_name_singular->name} ($id)");

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
            flash('You can not delete this user!')->warning()->important();

            logUserAccess("{$module_title} {$module_action} Failed! {$$module_name_singular->name} ($id)");

            return redirect()->back();
        }

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = $module_model::findOrFail($id);

        $$module_name_singular->delete();

        event(new UserUpdated($$module_name_singular));

        flash($$module_name_singular->name.' User Successfully Deleted!')->success()->important();

        logUserAccess("{$module_title} {$module_action} ($id)");

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

        $module_action = 'Trash List';

        $$module_name = $module_model::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate();

        logUserAccess($module_title.' '.$module_action);

        logUserAccess("{$module_title} {$module_action}");

        return view(
            "{$module_path}.{$module_name}.trash",
            compact('module_title', 'module_name', 'module_path', "{$module_name}", 'module_icon', 'module_name_singular', 'module_action')
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
        if (! auth()->user()->can('restore_users')) {
            abort(403);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Restore';

        $$module_name_singular = $module_model::withTrashed()->find($id);

        $$module_name_singular->restore();

        event(new UserUpdated($$module_name_singular));

        flash($$module_name_singular->name.' Successfully Restoreded!')->success()->important();

        logUserAccess("{$module_title} {$module_action} {$$module_name_singular->name} ($id)");

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
        if (! auth()->user()->can('delete_users')) {
            abort(403);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Block';

        if (auth()->user()->id == $id || $id == 1) {
            flash("You can not 'Block' this user!")->success()->important();

            Log::notice(label_case($module_title.' '.$module_action).' Failed | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

            return redirect()->back();
        }

        $$module_name_singular = User::withTrashed()->find($id);

        $$module_name_singular->status = 2;
        $$module_name_singular->save();

        event(new UserUpdated($$module_name_singular));

        flash($$module_name_singular->name.' User Successfully Blocked!')->success()->important();

        logUserAccess("{$module_title} {$module_action} {$$module_name_singular->name} ($id)");

        return redirect()->back();
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
        if (! auth()->user()->can('delete_users')) {
            abort(403);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Unblock';

        if (auth()->user()->id == $id || $id == 1) {
            flash("You can not 'Unblock' this user!")->warning()->important();

            Log::notice(label_case($module_title.' '.$module_action).' Failed | User:'.auth()->user()->name.'(ID:'.auth()->user()->id.')');

            return redirect()->back();
        }

        $$module_name_singular = User::withTrashed()->find($id);

        $$module_name_singular->status = 1;
        $$module_name_singular->save();

        event(new UserUpdated($$module_name_singular));

        flash($$module_name_singular->name.' - User Successfully Unblocked!')->success()->important();

        logUserAccess("{$module_title} {$module_action} {$$module_name_singular->name} ($id)");

        return redirect()->back();
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
            flash('Invalid Request. Please try again.')->error()->important();

            return redirect()->back();
        }
        $user_provider = UserProvider::findOrFail($user_provider_id);

        if ($user_id == $user_provider->user->id) {
            $user_provider->delete();

            flash('Unlinked from User, "'.$user_provider->user->name.'"!')->success()->important();

            return redirect()->back();
        }
        flash('Request rejected. Please contact the Administrator!')->warning()->important();

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
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Email Confirmation Resend';

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        // if ($id !== auth()->user()->id) {
        //     if (auth()->user()->hasAnyRole(['administrator', 'super admin'])) {
        //         Log::info(auth()->user()->name.' ('.auth()->user()->id.') - User Requested for Email Verification.');
        //     } else {
        //         Log::warning(auth()->user()->name.' ('.auth()->user()->id.') - User trying to confirm another users email.');

        //         abort('403');
        //     }
        // }

        $user = User::where('id', '=', $id)->first();

        if ($user) {
            if ($user->email_verified_at === null) {
                Log::info($user->name.' ('.$user->id.') - User Requested for Email Verification.');

                // Send Email To Registered User
                $user->sendEmailVerificationNotification();

                flash('Email Sent! Please Check Your Inbox.')->success()->important();

                return redirect()->back();
            }
            Log::info($user->name.' ('.$user->id.') - User Requested but Email already verified at.'.$user->email_verified_at);

            flash($user->name.', You already confirmed your email address at '.$user->email_verified_at->isoFormat('LL'))->success()->important();

            logUserAccess($module_title.' '.$module_action);

            return redirect()->back();
        }
    }
}
