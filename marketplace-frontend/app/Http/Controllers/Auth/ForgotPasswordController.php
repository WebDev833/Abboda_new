<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\User;
use Mail;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    

    /**************************** Forgot Password Start ********************/
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        $pageConfigs = [
            'newsletter' => true,
            'breadcrumb' => false,
            'title' => 'Forgot Password',
        ];
        return view('pages.user.auth.passwords.email', ['pageConfigs' => $pageConfigs]);
    }

    /**************************** Forgot Password end ********************/

    public function sendResetLinkEmail(Request $request)
    {
        $user = User::where('email', request()->input('email'))->first();
        $token = Password::getRepository()->create($user);
       
        Mail::send(['text' => 'emails.password'], ['token' => $token], function ($message) use ($user) {
            $message->subject(config('app.name') . ' Password Reset Link');
            $message->from('test@abboda.com');
            $message->to($user->email);
        });
    }

}
