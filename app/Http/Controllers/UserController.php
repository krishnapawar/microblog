<?php

namespace App\Http\Controllers;



use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

use App\Models\User;
use Carbon\Carbon;
use Hash;

use Session;

use App\Models\UserVerify;
use Illuminate\Support\Str;
use Mail;

class UserController extends Controller
{
    public function __construct()
    {

        $this->middleware('guest')->except('logout');
       
    }
    
    public function login()
    {
        return view('admin.auth.login');
    }


    public function loginchack(Request $request)
    {
        try
        {
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);
    
            $credentials = $request->except(['_token']);
    
            //$user = User::where('email',$request->email)->where('status',1)->first();
            $user = User::where('email',$request->email)->first();
            if ($user ==null) {
                # code...
                \Session::flash('error','Credentials does not match!');
                return redirect()->back();
            }
    
            if (auth()->attempt($credentials)) {
                //dd($credentials);
                 return redirect()->route('home');
    
            }else{
                session()->flash('message', 'Invalid credentials');
                return redirect()->back();
            };
        }catch(\Exception $e)
        {
            \Session::flash('error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function signup()
    {
        return view('admin.auth.signup');
    }

    public function signupstore(Request $request)
    {
        
        try
        {
            $request->validate([
                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required|min:6',
                
            ]);
            //dd($request->all());
            // $request['otp'] =  1234;
            // $request['expire_otp'] = Carbon::now()->addMinutes(1);
            $request['password']= Hash::make($request->password);
            $createUser = User::create($request->except(["_token","confirmpassword"]));
            $token = Str::random(64);
            UserVerify::create([
            'user_id' => $createUser->id, 
            'token' => $token
            ]);
            //Mail::to('krishnapawar90906@gmail.com')->send(new \App\Mail\MyTestMail($details));
            Mail::send('emails.emailVerificationEmail', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Email Verification Mail');
            });
            // \Session::put("userId",$userid->id);
            return redirect()->route('otpcheck');
        }catch(\Exception $e)
        {
            \Session::flash('error',$e->getMessage());
            return redirect()->back();
        }
    }
    
    public function otpcheck(Request $request)
    {
        //return $userId = $request->session()->get('userId');
        return view('admin.auth.signup');
    }

    public function otpvarification(Request $request)
    {
        
        try
        {
            $request->validate([
                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required|min:6',
                
            ]);
            //dd($request->all());
            $request['password']= Hash::make($request->password);
            $userid = User::create($request->except(["_token","confirmpassword"]));
            
            return redirect()->route('otpvarification');
        }catch(\Exception $e)
        {
            \Session::flash('error',$e->getMessage());
            return redirect()->back();
        }
    }


    public function logout()
    {
        \Auth::logout();

        return redirect()->route('login');
    }

    public function dasboard()
    {
        return 'hell i am dasboard';
    }

    /**
* Write code on Method
*
* @return response()
*/
    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
        $message = 'Sorry your email cannot be identified.';
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified. You can now login.";
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
        return redirect()->route('login')->with('success', $message);
    }

}
