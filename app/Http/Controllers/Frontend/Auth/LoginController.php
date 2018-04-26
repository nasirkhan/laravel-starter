<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Image;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            flash('<i class="fas fa-check"></i> Login Successful')->success();

            return redirect()->intended('frontend.home');
        } else {
            flash('<i class="fas fa-exclamation-triangle"></i> Login Failed. Please Contact Administrator.')->error();

            return redirect()->back();
        }
    }

    /**
     * Social login Handler.
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Social login redirect.
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();

            $authUser = $this->findOrCreateUser($user, $provider);

            Auth::login($authUser, true);
        } catch (Exception $e) {
            return redirect('/');
        }

        return redirect('/');
    }

    /**
     * Return user if exists; create and return if doesn't.
     *
     * @param $githubUser
     *
     * @return User
     */
    private function findOrCreateUser($socialUser, $provider)
    {
        if ($authUser = UserProvider::where('provider_id', $socialUser->getId())->first()) {
            $authUser = User::findOrFail($authUser->user->id);

            return $authUser;
        } elseif ($authUser = User::where('email', $socialUser->getEmail())->first()) {
            UserProvider::create([
                'user_id'     => $authUser->id,
                'provider_id' => $socialUser->getId(),
                'avatar'      => $socialUser->getAvatar(),
                'provider'    => $provider,
            ]);

            // update User Avatar from Social Profile
            if ($authUser->avatar == 'default-avatar.jpg') {
                $avatar = $socialUser->getAvatar();

                $filename = 'avatar-'.$authUser->id.'.jpg';

                $img = Image::make($avatar)->resize(null, 400, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('jpg', 75)->save(public_path('/photos/avatars/'.$filename));
                $authUser->avatar = $filename;
                $authUser->save();
            }

            return $authUser;
        } else {
            $user = User::create([
                'name'      => $socialUser->getName(),
                'email'     => $socialUser->getEmail(),
            ]);

            // update User Avatar from Social Profile
            $avatar = $socialUser->getAvatar();
            $filename = 'avatar-'.$user->id.'.jpg';
            $img = Image::make($avatar)->resize(null, 400, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg', 75)->save(public_path('/photos/avatars/'.$filename));
            $user->avatar = $filename;
            $user->save();

            UserProvider::create([
                'user_id'     => $user->id,
                'provider_id' => $socialUser->getId(),
                'avatar'      => $socialUser->getAvatar(),
                'provider'    => $provider,
            ]);

            return $user;
        }
    }
}
