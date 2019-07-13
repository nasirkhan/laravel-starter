<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Auth\UserLoginSuccess;
use App\Events\Frontend\User\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProvider;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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

        $this->redirectTo = app('request')->input('redirectTo') ?: $this->redirectTo;
    }

    /**
     * Show the Login form.
     *
     * this method overrides the default method.
     */
    public function showLoginForm()
    {
        if (!session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }

        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email',
            'password'  => 'required',

        ]);

        $remember = ($request->get('remember') == 'on') ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1], $remember)) {
            flash('<i class="fas fa-check"></i> Welcome '.auth()->user()->name.', <br>You successfully logged in!')->success()->important();

            $user = Auth::user();

            event(new UserLoginSuccess($request, $user));

            return redirect()->intended($this->redirectTo);
        } else {
            flash('<i class="fas fa-exclamation-triangle"></i> Login Failed. Email or password incorrect. Please try again!')->error()->important();

            return redirect()->back();
        }
    }

    protected function credentials(Request $request)
    {
        $data = $request->only($this->username(), 'password');
        $data['active'] = true;
        $data['confirmed'] = true;

        return $data;
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => __('auth.failed')];

        // Load user from database
        $user = User::where($this->username(), $request->{$this->username()})->first();

        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user && \Hash::check($request->password, $user->password) && $user->status != 1) {
            $errors = [$this->username() => 'Your account is not active.'];
        }

        if ($user && \Hash::check($request->password, $user->password) && $user->confirmed != 1) {
            $errors = [$this->username() => __('exceptions.frontend.auth.confirmation.resend', ['user_id' => $user->id])];
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
        ->withInput($request->only($this->username(), 'remember'))
        ->withErrors($errors);
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();

            $authUser = $this->findOrCreateUser($user, $provider);

            Auth::login($authUser, true);
        } catch (Exception $e) {
            return redirect($this->redirectTo);
        }

        return redirect($this->redirectTo);
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
        // Check Provider User Id
        if ($authUser = UserProvider::where('provider_id', $socialUser->getId())->first()) {
            $authUser = User::findOrFail($authUser->user->id);

            return $authUser;
        } elseif ($authUser = User::where('email', $socialUser->getEmail())->first()) {
            $media = $authUser->addMediaFromUrl($socialUser->getAvatar())->toMediaCollection('users');
            $avatar_url = $media->getUrl();

            UserProvider::create([
                'user_id'     => $authUser->id,
                'provider_id' => $socialUser->getId(),
                'avatar'      => $avatar_url,
                'provider'    => $provider,
            ]);

            return $authUser;
        } else {
            $socialUserName = $socialUser->getName();
            $nameParts = explode(' ', $socialUserName);
            $socialUserLastName = array_pop($nameParts);
            $socialUserFirstName = implode(' ', $nameParts);

            $user = User::create([
                'name'          => $socialUserName,
                'first_name'    => $socialUserFirstName,
                'last_name'     => $socialUserLastName,
                'email'         => $socialUser->getEmail(),
            ]);

            $media = $user->addMediaFromUrl($socialUser->getAvatar())->toMediaCollection('users');
            $avatar_url = $media->getUrl();

            UserProvider::create([
                'user_id'     => $user->id,
                'provider_id' => $socialUser->getId(),
                'avatar'      => $avatar_url,
                'provider'    => $provider,
            ]);

            $user->avatar = $avatar_url;
            $user->save();

            event(new UserRegistered($user));

            return $user;
        }
    }
}
