<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    //SOBRE ESCRIBIR LA FUNCION LOGIN
    // public function()
    public function login(Request $request){
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required'
        ]);
        if(\Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('/home');
        } elseif(\Auth::attempt(['telefono' => $request->email, 'password' => $request->password])){
            return redirect('/home');
        }
        $validator=\Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required',
        ]);
        $validator->errors()->add('email', trans('auth.failed'));

        return back()->withErrors($validator->errors())
                        ->withInput();
        }

}

