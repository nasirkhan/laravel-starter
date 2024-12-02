<?php

namespace App\Http\Controllers\Frontend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        $this->module_icon = 'fas fa-users';

        // module model name, path
        $this->module_model = "App\Models\User";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $username  The username of the resource to be displayed.
     * @return Response
     * @return \Illuminate\Contracts\View\View Returns a view of the specified resource.
     *
     * @throws \Exception If the resource is not found.
     */
    public function show($username)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Show';

        $$module_name_singular = $module_model::where('username', 'LIKE', $username)->first();

        $body_class = 'profile-page';

        $meta_page_type = 'profile';

        return view(
            "frontend.{$module_name}.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}", 'body_class', 'meta_page_type')
        );
    }

    /**
     * Retrieves the profile information for a given user ID.
     *
     * @param  int  $id
     * @param  int  $id  The ID of the user.
     * @return \Illuminate\Http\Response
     * @return Illuminate\View\View The view containing the user profile information.
     *
     * @throws ModelNotFoundException If the user profile is not found.
     */
    public function profile(Request $request, $username = null)
    {
        $username = ($username == null) ? auth()->user()->username : $username;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Profile';

        $$module_name_singular = $module_model::whereUsername($username)->first();

        $body_class = 'profile-page';

        $meta_page_type = 'profile';

        return view("frontend.{$module_name}.profile", compact('module_name', 'module_name_singular', "{$module_name_singular}", 'module_icon', 'module_action', 'module_title', 'body_class', 'meta_page_type'));
    }

    /**
     * Edit a user profile.
     *
     * @param  int  $id
     * @param  int  $id  the ID of the user profile to edit
     * @return \Illuminate\Http\Response
     * @return \Illuminate\View\View the view for editing the user profile
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException if the user profile is not found
     */
    public function profileEdit(Request $request)
    {
        $id = auth()->user()->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'Edit Profile';

        $page_heading = ucfirst($module_title);
        $title = $page_heading.' '.ucfirst($module_action);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        if ($id !== auth()->user()->id) {
            return redirect()->route('frontend.users.profile', encode_id($id));
        }

        $$module_name_singular = $module_model::findOrFail($id);

        $body_class = 'profile-page';

        return view(
            "frontend.{$module_name}.profileEdit",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}", 'body_class')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request)
    {
        $id = auth()->user()->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Profile Update';

        if ($id !== auth()->user()->id) {
            return redirect()->route('frontend.users.profile', encode_id($id));
        }

        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $module_name = $this->module_name;
        $module_name_singular = Str::singular($this->module_name);

        if (! auth()->user()->can('edit_users')) {
            $id = auth()->user()->id;
        }

        $$module_name_singular = $module_model::findOrFail($id);

        // TODO: Use validated data
        $data = $request->all();
        $$module_name_singular->update($data);

        // Handle Avatar upload
        if ($request->hasFile('avatar')) {
            if ($$module_name_singular->getMedia($module_name)->first()) {
                $$module_name_singular->getMedia($module_name)->first()->delete();
            }

            $media = $$module_name_singular->addMedia($request->file('avatar'))->toMediaCollection($module_name);

            $$module_name_singular->avatar = $media->getUrl();

            $$module_name_singular->save();
        }

        return redirect()->route('frontend.users.profile', $$module_name_singular->username)->with('flash_success', 'Update successful!');
    }

    /**
     * Change the password for a user.
     *
     * @param  int  $id
     * @param  int  $id  The ID of the user.
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View The redirect response if the user ID is not the same as the authenticated user's ID, otherwise the view with the change password form.
     *
     * @throws \Exception If the user ID cannot be decoded or if the user is not authenticated.
     */
    public function changePassword()
    {
        $id = auth()->user()->id;

        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'change Password';

        $body_class = 'profile-page';

        if ($id !== auth()->user()->id) {
            return redirect()->route('frontend.users.profile', encode_id($id));
        }

        $$module_name_singular = $module_model::findOrFail($id);

        $body_class = 'profile-page';

        return view("frontend.{$module_name}.changePassword", compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_action', 'module_name_singular', "{$module_name_singular}", 'body_class'));
    }

    /**
     * Updates the password for a user.
     *
     * @param  int  $id
     * @param  Request  $request  The HTTP request object.
     * @param  mixed  $id  The ID of the user.
     * @return \Illuminate\Http\Response
     * @return mixed The updated user object.
     */
    public function changePasswordUpdate(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'change Password Update';

        $validated = $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $$module_name_singular = auth()->user();

        $validated['password'] = Hash::make($validated['password']);

        $$module_name_singular->update($validated);

        return redirect()->route('frontend.users.profile')->with('flash_success', 'Update successful!');
    }

    /**
     * Destroy a user provider.
     *
     * @param  Request  $request  The request object.
     * @return RedirectResponse The redirect response.
     *
     * @throws Exception There was a problem updating this user. Please try again.
     */
    public function userProviderDestroy(Request $request)
    {
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

        throw new Exception('There was a problem updating this user. Please try again.');
    }

    /**
     * Resends the email confirmation for a user.
     *
     * @param [type] $hashid [description]
     * @param  int  $id  The decoded ID of the user.
     * @return [type] [description]
     * @return RedirectResponse The redirect response.
     *
     * @throws Exception If the user is not authorized to resend the email confirmation.
     */
    public function emailConfirmationResend($id)
    {
        $id = decode_id($id);

        if ($id !== auth()->user()->id) {
            if (auth()->user()->hasAnyRole(['administrator', 'super admin'])) {
                Log::info(auth()->user()->name.' ('.auth()->user()->id.') - User Requested for Email Verification.');
            } else {
                Log::warning(auth()->user()->name.' ('.auth()->user()->id.') - User trying to confirm another users email.');

                abort('404');
            }
        }

        $user = User::where('id', 'LIKE', $id)->first();

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

            return redirect()->back();
        }
    }
}
