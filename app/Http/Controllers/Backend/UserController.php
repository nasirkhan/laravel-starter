<?php

namespace App\Http\Controllers\Backend;

use App\Authorizable;
use App\Events\Backend\User\UserCreated;
use App\Events\Backend\User\UserProfileUpdated;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Listeners\Backend\User\UserUpdatedProfileUpdate;
use App\Mail\EmailVerificationMail;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Userprofile;
use App\Models\UserProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Image;
use Log;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    use Authorizable;

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

        $page_heading = ucfirst($module_title);
        $title = $page_heading.' '.ucfirst($module_action);

        $$module_name = $module_model::paginate();

        Log::info("'$title' viewed by User:".auth()->user()->name.'(ID:'.auth()->user()->id.')');

        return view("backend.$module_path.index_datatable",
        compact('module_title', 'module_name', "$module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'page_heading', 'title'));
    }

    public function index_data()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = str_singular($module_name);

        $module_action = 'List';

        $$module_name = $module_model::select('id', 'name', 'email', 'updated_at', 'status', 'confirmed_at');

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
                            } else {
                                return $data->updated_at->toCookieString();
                            }
                        })
                        ->rawColumns(['name', 'action', 'status', 'user_roles'])
                        ->orderColumns(['id'], '-:column $1')
                        ->make(true);
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
        $module_name_singular = str_singular($module_name);

        $module_action = 'Create';

        $page_heading = ucfirst($module_title);
        $title = $page_heading.' '.ucfirst($module_action);

        $roles = Role::get();
        $permissions = Permission::select('name', 'id')->get();

        return view("backend.$module_name.create",
        compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', 'page_heading', 'title', 'roles', 'permissions'));
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

        $order_data = $request->except('_token', 'roles', 'confirmed', 'password_confirmation');

        if ($request->confirmed == 1) {
            $confirmed_data = [
                'confirmed' => Carbon::now(),
            ];

            array_push($order_data, $confirmed_data);
        } else {
            $confirmed_data = [
                'confirmed' => null,
            ];

            array_push($order_data, $confirmed_data);
        }

        // return $order_data;

        $$module_name_singular = User::create($order_data);

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

        event(new UserCreated($$module_name_singular));

        return redirect("admin/$module_name")->with('flash_success', "$module_name added!");
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

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        $$module_name_singular = $module_model::findOrFail($id);
        $userprofile = Userprofile::where('user_id', $$module_name_singular->id)->first();

        return view("backend.$module_name.show",
        compact('module_title', 'module_name', "$module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular", 'page_heading', 'title', 'userprofile'));
    }

    /**
     * Display Profile Details of Logged in user.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function profile($id)
    {
        $title = $this->module_title;
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_action = 'Show';

        if (!auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = User::findOrFail($id);
        $userprofile = Userprofile::where('user_id', $$module_name_singular->id)->first();

        return view("backend.$module_name.profile", compact('module_name', "$module_name_singular", 'module_icon', 'module_action', 'module_title', 'userprofile'));
    }

    /**
     * Show the form for Profile Paeg Editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function profileEdit($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = str_singular($module_name);

        $module_action = 'Edit Profile';

        $page_heading = ucfirst($module_title);
        $title = $page_heading.' '.ucfirst($module_action);

        if (!auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = $module_model::findOrFail($id);
        $userprofile = Userprofile::where('user_id', $$module_name_singular->id)->first();

        return view("backend.$module_name.profileEdit",
        compact('module_title', 'module_name', "$module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular", 'page_heading', 'title', 'userprofile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        if (!auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = User::findOrFail($id);
        $filename = $$module_name_singular->avatar;

        // Handle Avatar upload
        if ($request->hasFile('avatar')) {
            if ($$module_name_singular->getMedia($module_name)->first()) {
                $$module_name_singular->getMedia($module_name)->first()->delete();
            }

            $media = $$module_name_singular->addMediaFromRequest('avatar')->toMediaCollection($module_name);

            $$module_name_singular->avatar = $media->getUrl();

            $$module_name_singular->save();
        }

        // return $$module_name_singular->avatar;
        // if ($request->hasFile('avatar')) {
        //     $avatar = $request->file('avatar');
        //     $filename = 'avatar-'.$$module_name_singular->id.'.'.$avatar->getClientOriginalExtension();
        //     $img = Image::make($avatar)->resize(null, 400, function ($constraint) {
        //         $constraint->aspectRatio();
        //     })->save(public_path('/photos/avatars/'.$filename));
        //     $$module_name_singular->avatar = $filename;
        //     $$module_name_singular->save();
        //     return $filename;
        // }

        $data_array = $request->except('avatar');
        $data_array['avatar'] = $$module_name_singular->avatar;

        $user_profile = Userprofile::where('user_id', '=', $$module_name_singular->id)->first();
        $user_profile->update($data_array);

        event(new UserProfileUpdated($user_profile));

        return redirect(route('backend.users.profile', $$module_name_singular->id))->with('flash_success', 'Update successful!');
    }

    /**
     * Show the form for Profile Paeg Editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function changeProfilePassword($id)
    {
        if (!auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $title = $this->module_title;
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_icon = $this->module_icon;
        $module_action = 'Edit';

        $$module_name_singular = User::findOrFail($id);

        return view("backend.$module_name.changeProfilePassword", compact('module_name', 'module_title', "$module_name_singular", 'module_icon', 'module_action', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function changeProfilePasswordUpdate(Request $request, $id)
    {
        if (!auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        $$module_name_singular = User::findOrFail($id);

        $$module_name_singular->update($request->only('password'));

        return redirect("admin/$module_name/profile")->with('flash_success', 'Update successful!');
    }

    /**
     * Show the form for Profile Paeg Editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = str_singular($module_name);

        $module_action = 'Change Password';

        $page_heading = label_case($module_title);
        $title = $page_heading.' '.label_case($module_action);

        if (!auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = $module_model::findOrFail($id);

        return view("backend.$module_name.changePassword",
        compact('module_title', 'module_name', "$module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular", 'page_heading', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function changePasswordUpdate(Request $request, $id)
    {
        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);

        if (!auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = User::findOrFail($id);

        $$module_name_singular->update($request->only('password'));

        return redirect("admin/$module_name")->with('flash_success', 'Update successful!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('edit_users')) {
            abort(404);
        }

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = str_singular($module_name);

        $module_action = 'Edit';

        $page_heading = ucfirst($module_title);
        $title = $page_heading.' '.ucfirst($module_action);

        $$module_name_singular = $module_model::findOrFail($id);

        $userRoles = $$module_name_singular->roles->pluck('name')->all();
        $userPermissions = $$module_name_singular->permissions->pluck('name')->all();

        $roles = Role::get();
        $permissions = Permission::select('name', 'id')->get();

        return view("backend.$module_name.edit",
        compact('module_title', 'module_name', "$module_name", 'module_path', 'module_icon', 'module_action', 'module_name_singular', "$module_name_singular", 'page_heading', 'title', 'roles', 'permissions', 'userRoles', 'userPermissions'));
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
        if (auth()->user()->can('edit_users')) {
            abort(404);
        }

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
     * @return Response
     */
    public function destroy($id)
    {
        if (auth()->id() == $id || $id == 1) {
            throw new GeneralException('You can not delete yourself.');
        }

        $module_name = $this->module_name;
        $module_name_singular = str_singular($this->module_name);
        $module_path = $this->module_path;
        $module_model = $this->module_model;

        $module_action = 'destroy';

        $$module_name_singular = $module_model::findOrFail($id);

        $$module_name_singular->delete();

        event(new UserUpdatedProfileUpdate($$module_name_singular));

        flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' User Successfully Deleted!')->success();

        Log::info(label_case($module_action)." '$module_name': '".$$module_name_singular->name.', ID:'.$$module_name_singular->id." ' by User:".auth()->user()->name);

        return redirect("admin/$module_name");
    }

    /**
     * List of trashed ertries
     * works if the softdelete is enabled.
     *
     * @return Response
     */
    public function trashed()
    {
        $module_name = $this->module_name;
        $module_title = $this->module_title;
        $module_name_singular = str_singular($this->module_name);
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        $module_action = 'List';
        $page_heading = $module_title;

        $$module_name = $module_model::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate();

        Log::info(label_case($module_action).' '.label_case($module_name).' by User:'.auth()->user()->name);

        return view("backend.$module_name.trash",
        compact('module_name', 'module_title', "$module_name", 'module_icon', 'page_heading', 'module_action'));
    }

    /**
     * Restore a soft deleted entry.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function restore($id)
    {
        $module_name = $this->module_name;
        $module_title = $this->module_title;
        $module_name_singular = str_singular($this->module_name);
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;

        $module_action = 'Restore';

        $$module_name_singular = $module_model::withTrashed()->find($id);
        $$module_name_singular->restore();

        event(new UserUpdatedProfileUpdate($$module_name_singular));

        flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' Successfully Restoreded!')->success();

        Log::info(label_case($module_action)." '$module_name': '".$$module_name_singular->name.', ID:'.$$module_name_singular->id." ' by User:".auth()->user()->name);

        return redirect("admin/$module_name");
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

            event(new UserUpdatedProfileUpdate($$module_name_singular));

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

            event(new UserUpdatedProfileUpdate($$module_name_singular));

            flash('<i class="fas fa-check"></i> '.$$module_name_singular->name.' User Successfully Unblocked!')->success();

            return redirect()->back();
        } catch (\Exception $e) {
            throw new GeneralException('There was a problem updating this user. Please try again.');
        }
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

    /**
     * Confirm Email Address of a User.
     *
     * @param string $confirmation_code Auto Generated Confirmation Code
     *
     * @return [type] [description]
     */
    public function emailConfirmation($confirmation_code)
    {
        // Find if the confirmation_code belongs to an user.
        $user = User::where('confirmation_code', '=', $confirmation_code)->first();

        // If there is a user continue else redirect back
        if ($user) {
            // Check if email is confirmed by right user
            if ($user->id != auth()->user()->id) {
                if (auth()->user()->hasRole('administrator')) {
                    Log::info(auth()->user()->name.' ('.auth()->user()->id.') - User Requested for Email Verification.');
                } else {
                    Log::warning(auth()->user()->name.' ('.auth()->user()->id.') - User trying to confirm another users email.');

                    abort('404');
                }
            } elseif ($user->confirmed_at != null) {
                Log::info($user->name.' ('.$user->id.') - User Requested but Email already verified at.'.$user->confirmed_at);

                flash($user->name.', You already confirmed your email address at '.$user->confirmed_at->toFormattedDateString())->success()->important();

                return redirect()->back();
            }

            $user->confirmed_at = Carbon::now();
            $user->save();

            flash('You have successfully confirmed your email address!')->success()->important();

            return redirect()->back();
        } else {
            flash('Invalid email confirmation code!')->warning()->important();

            return redirect()->back();
        }
    }

    /**
     * Resend Email Confirmation Code to User.
     *
     * @param [type] $hashid [description]
     *
     * @return [type] [description]
     */
    public function emailConfirmationResend($hashid)
    {
        $id = $hashid;

        if ($id != auth()->user()->id) {
            if (auth()->user()->hasRole('administrator')) {
                Log::info(auth()->user()->name.' ('.auth()->user()->id.') - User Requested for Email Verification.');
            } else {
                Log::warning(auth()->user()->name.' ('.auth()->user()->id.') - User trying to confirm another users email.');

                abort('404');
            }
        }

        $user = User::findOrFail($id);

        if ($user->confirmed_at == null) {
            Log::info($user->name.' ('.$user->id.') - User Requested for Email Verification.');

            // Send Email To Registered User
            Mail::to($user->email)->send(new EmailVerificationMail($user));

            flash('Email Sent! Please Check Your Inbox.')->success()->important();

            return redirect()->back();
        } else {
            Log::info($user->name.' ('.$user->id.') - User Requested but Email already verified at.'.$user->confirmed_at);

            flash($user->name.', You already confirmed your email address at '.$user->confirmed_at->toFormattedDateString())->success()->important();

            return redirect()->back();
        }
    }
}
