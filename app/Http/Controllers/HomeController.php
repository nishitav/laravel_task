<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller {

    /*
     * Default index page 
     */
    public function index(Request $request) {
        // check user logged in
        if (!Auth::check() && $request->path() != 'login' && $request->path() != 'doResetPassword') {
            return redirect('/login');
        }

        // if user not logged in and path not login
        if (!Auth::check() && $request->path() == 'login') {
            return view('welcome');
        }

        // logged in user but try to access login
        if ($request->path() == 'login') {
            return redirect('/');
        }

        return view('welcome');
    }

    /*
     * Login operation  
     */
    public function login(Request $request) {
        // validate request
        $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:6',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return response()->json([
                'msg' => 'You are logged in succeessfully.',
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'msg' => 'Incorrect login details',
            ], 401);
        }
    }

    /*
     * Logout operation 
     */
    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
    
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png',
        ]);
        $picName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }
    public function deleteImage(Request $request)
    {
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName, false);
        return 'done';
    }
}
