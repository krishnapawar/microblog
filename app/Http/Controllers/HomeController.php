<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Like;
use Carbon\Carbon;
use Auth;

class HomeController extends Controller
{
    //
   
    public function index()
    {
        return view('dasboard');
    }
    public function home()
    {
      $imgs=File::with('likes')->withCount(['likes'=>function($query) {
        $query->where('status',1);
       }])->get()
        ->sortByDesc(function($likecount)
        {
            return $likecount->likes->where('status',1)->count();
        });
        return view('home',compact('imgs'));
        
    }

    // public function homee()
    // {
    //     $imgs=File::with('likes')->withCount('likes')->get()
    //     ->sortByDesc(function($likecount)
    //     {
    //         return $likecount->likes->count();
    //     });
    //     //return view('home',compact('imgs'));
    //     return response()->json(['data'=>$imgs,'status'=>200]);
    // }

    public function imgstore(Request $request)
    {
// return Auth::user()->id;
        
        $filename = $request->image->getClientOriginalName();
        $request['name'] = $filename;
        $request['type'] = $request->image->getClientOriginalExtension();
        // $request['filepath'] = $request->image->storeAs(Carbon::now()->year.'/'.Carbon::now()->month,$filename,'public');
        $request['filepath'] = $request->image->storeAs(Carbon::now()->year.'/'.Carbon::now()->month,$filename,'public');
        $request['user_id'] = Auth::user()->id;
        $file = file::create($request->except('_token','image'));

        return redirect()->back(); 
    }

    public function likesore(Request $request)
    {
        try
        {
            //dd($request->all());
            $likes = Like::where('user_id',$request->user_id)
            ->where('file_id',$request->file_id)
            ->first();
            if (isset($likes) && $likes!='') {
                # code...
                if (isset($likes->status) && $likes->status==0) {
                    # code...
                   // dd($likes->status);
                    $request['status'] = 1;
                    Like::where('user_id',$request->user_id)->where('file_id',$request->file_id)
                    ->update($request->except('_token','user_id','file_id')) ;
                } else {
                    # code...
                    $request['status'] = 0;
                    Like::where('user_id',$request->user_id)->where('file_id',$request->file_id)
                    ->update($request->except('_token','user_id','file_id')) ;
                }
                
                
            } else {
                # code...
                $request['status'] = 1;
                //return $request->all();
                Like::create($request->except('_token'));
            }
            
           
            return redirect()->back();
        }
        catch(\Exception $e)
        {
            \Session::flash('error',$e->getMessage());
            return redirect()->back();
        }
    }
}
