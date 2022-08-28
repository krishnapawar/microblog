<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
class AdminController extends Controller
{
    //
    public function authenticate(Request $request)
    {
        try
        {
            $request->validate([
                'email' => 'required',
                'password' => 'required'
            ]);
    
            $credentials = $request->except(['_token']);
    
            //$user = User::where('email',$request->email)->where('status',1)->first();
            $user = Admin::where('email',$request->email)->first();
            
            if ($user ==null) {
                # code...
                
                \Session::flash('message','Credentials does not match!');
                return redirect()->back();
            }
           
    
            if (auth()->guard('admin')->attempt($credentials,$request->get('remember'))) {
                //dd($credentials);
                
                 return redirect()->route('admin.dashboard');
    
            }else{
                session()->flash('message', 'Invalid credentials');
                return redirect()->back();
            };
        }catch(\Exception $e)
        {
            \Session::flash('message',$e->getMessage());
            return redirect()->back();
        }
    }

    public function sendotp(Request $request)
    {
        try
        {
            $request->validate([
                'email' => 'required',
               
            ]);
    
            $credentials = $request->except(['_token']);
    
            //$user = User::where('email',$request->email)->where('status',1)->first();
            $user = Admin::where('email',$request->email)->first();
            
            if ($user ==null) {
                # code...
                
                \Session::flash('message','Credentials does not match!');
                return redirect()->back();
            }

            $user = Admin::where('email',$request->email)->update([
                'otp'=>1234,
                'status'=>$request->_token
            ]);
            return "ok";
            return redirect()->route('admin.dashboard');

        }catch(\Exception $e)
        {
            \Session::flash('message',$e->getMessage());
            return redirect()->back();
        }
    }

    public function sendotpcheck(Request $request,$id)
    {
        try
        {
            $request->validate([
                'email' => 'required',
               
            ]);
    
            $credentials = $request->except(['_token']);
    
            //$user = User::where('email',$request->email)->where('status',1)->first();
            $user = Admin::where('email',$request->email)->first();
            
            if ($user ==null) {
                # code...
                
                \Session::flash('message','Credentials does not match!');
                return redirect()->back();
            }

            $user = Admin::where('email',$request->email)->update([
                'otp'=>1234,
                'status'=>$request->_token
            ]);
            return "ok";
            return redirect()->route('admin.dashboard');

        }catch(\Exception $e)
        {
            \Session::flash('message',$e->getMessage());
            return redirect()->back();
        }
    }
    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    
}
