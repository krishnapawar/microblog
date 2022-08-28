<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class DashboardController extends Controller
{
    //
    public function dashboard()
    {
        $user = Admin::where('id',1)->first();
       return $c = $this->calculate_profile($user);
        return view('admin.home',compact('c'));
    }

    function calculate_profile($profiles)
{
	if ( ! $profiles) {
		return 0;
	}
    //$columns    = preg_grep('/(.+ed_at)|(.*id)/', array_keys($profiles->toArray()), PREG_GREP_INVERT);
    // dd($columns);
    //$profile = $profiles->toArray();
    $profile = array_slice($profiles->toArray(),0,-2);
	$columns   = array_keys($profile);
    //dd($columns);
    //dd(count($columns));
	$per_column = 100 / count($columns);
    //dd($per_column );
	$total      = 0;

	foreach ($profile as $key => $value) {
		if ($value !== NULL && $value !== [] && $value !=="" && in_array($key, $columns)) {
			$total += $per_column;
		}
	}

	return $total;
}
}
