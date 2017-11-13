<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pr_t;

class CustomPrtController extends Controller
{
    public function getPrData(Request $request){
		$prs = Pr_t::where()->get();
		return 
	}
}
