<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\PasswordRecoverNotification;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Log;
use Modules\Bdmo\Entities\Festival;
use Modules\Bdmo\Entities\Questionset;

class FrontendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $body_class = '';

        $questionset_status = true;

        // flash("Registration will start from January 10, 2020. Thank You - BdMO")->success();

        // if (Auth::check()) {
        //     $questionset_id = auth()->user()->questionset_id;
        //
        //
        //     if ($questionset_id) {
        //
        //         $questionset = Questionset::findOrFail($questionset_id);
        //
        //         $questionset_data = $questionset;
        //
        //         $festival = Cache::remember('festival_details', 3600, function () use ($questionset_data) {
        //             return Festival::findOrFail($questionset_data->festival_id);
        //         });
        //
        //         $festival = Festival::findOrFail($questionset->festival_id);
        //         if (Carbon::now() < Carbon::parse($festival->start_date_time)) {
        //             flash("The contest will start from: ". Carbon::parse($festival->start_date_time)->toDayDateTimeString())->success();
        //
        //             $questionset_status = false;
        //         } else {
        //             if (Carbon::now() > Carbon::parse($festival->end_date_time)) {
        //                 flash("The contest time is over now. Please wait for the next contest!")->success();
        //
        //                 // return redirect()->route('frontend.index');
        //             } else {
        //                 $questionset_status = true;
        //                 $questionset_status = false;
        //             }
        //         }
        //         //
        //         // if ($festival->end_date_time >= Carbon::now()) {
        //         //     $questionset_status = true;
        //         // } else {
        //         //     flash("The contest time is over now. Please wait for the next contest!")->success();
        //         //
        //         //     $questionset_status = false;
        //         // }
        //     }
        // }

        return view('frontend.index', compact('body_class', 'questionset_status'));
    }

    public function faq()
    {
        $body_class = '';

        return view('frontend.faq', compact('body_class'));
    }

    public function profile()
    {
        $body_class = 'profile-page';

        return view('frontend.profile', compact('body_class'));
    }

    public function passwordRecover()
    {
        return view('auth.passwordRecover');
    }

    public function passwordRecoverPost(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|max:191',
        ]);

        $username = $request->username;

        $user = User::where('username', 'LIKE', $username)->first();

        if ($user) {
            $email = $user->email;
            $token = str_random(64);
            $created_at = Carbon::now()->toDateTimeString();

            $results = DB::select('select * from password_resets where username = :username LIMIT 1', ['username' => $username]);

            if ($results) {
                $affected = DB::update('update password_resets set token = :token where username = :username', ['token'=>$token, 'username' => $username]);
            } else {
                DB::insert('insert into password_resets (email, username, token, created_at) values (?, ?, ?, ?)', [$email, $username, $token, $created_at]);
            }

            flash('Reset link sent yo your email. Please check your inbox.')->success()->important();

            $user->notify(new PasswordRecoverNotification($token));
        } else {
            flash('No User found. Please use a valid username.')->warning()->important();
        }

        return redirect()->back();
    }

    public function setPassword($token)
    {
        $result = DB::select('select * from password_resets where token = :token LIMIT 1', ['token' => $token]);

        if ($result) {
            return view('auth.setPassword', compact('token'));
        } else {
            flash('Token Invalid!')->warning()->important();

            return redirect()->back();
        }
    }

    public function setPasswordPost(Request $request, $token)
    {
        $username = $request->username;

        $validatedData = $request->validate([
            'username' => 'required|max:191',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $result = DB::select('select * from password_resets where token = :token AND username = :username LIMIT 1', ['token' => $token, 'username'=> $username]);

        if ($result) {
            $hashedPassword = Hash::make($request->password);

            $user = User::where('status', 1)->where('username', 'LIKE', $username)->first();

            $user->password = $hashedPassword;
            $user->save();

            Auth::loginUsingId($user->id);

            DB::table('password_resets')->where('username', 'LIKE', $username)->delete();

            flash('Successfully updated the password.')->success()->important();

            return redirect()->route('frontend.index');
        } else {
            flash('Token or Username Invalid!')->warning()->important();

            return redirect()->back();
        }
    }

    public function emailDelivered(Request $request)
    {
        Log::info($request);

        // $message = Message::fromRawPostData();
        // $validator = new MessageValidator();
        // // Validate the message and log errors if invalid.
        // try {
        //     $validator->validate($message);
        // } catch (InvalidSnsMessageException $e) {
        //     // Pretend we're not here if the message is invalid.
        //     http_response_code(404);
        //     // error_log('SNS Message Validation Error: ' . $e->getMessage());
        //     Log::info('SNS Message Validation Error: ' . $e->getMessage());
        //     die();
        // }
        //
        // // Check the type of the message and handle the subscription.
        // if ($message['Type'] === 'SubscriptionConfirmation') {
        //     // Confirm the subscription by sending a GET request to the SubscribeURL
        //     file_get_contents(public_path() . '/awssns.txt','SUB URL MESSAGE = '.$message['SubscribeURL'].PHP_EOL, FILE_APPEND );
        // }
        //
        // Log::info($message['SubscribeURL']);
    }

    public function emailBounced(Request $request)
    {
        Log::info($request);
    }

    public function emailComplaint(Request $request)
    {
        Log::info($request);
    }
}
