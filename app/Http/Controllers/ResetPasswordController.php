<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\User;
use Mail;
use View;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller {

    /*
     * Default index page 
     */
    public function resetForm(Request $request) {

        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        // generate token
        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // send emails
        Mail::send('forgetPassword', ['token' => $token], function($message) use($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        // return success response
        return response()->json([
            'msg' => 'We have e-mailed your password reset link!',
        ]);
    }

    /**
     * Perform form submit to reset password
     * @return response()
     */
    public function submitResetPasswordForm(Request $request) {
        // validate request
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        // get token
        $updatePassword = DB::table('password_resets')
        ->where([
            'email' => $request->email,
            'token' => $request->token
        ])
        ->first();

        // in case invalid token
        if (!$updatePassword) {
            return response()->json([
                'msg' => 'Invalid token!',
            ], 422);
        }

        // update user password
        $user = User::where('email', $request->email)
                ->update(['password' => bcrypt($request->password)]);
        
        // remove all tokens for this user
        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return response()->json([
            'msg' => 'Password changed!',
        ]);
    }
}
