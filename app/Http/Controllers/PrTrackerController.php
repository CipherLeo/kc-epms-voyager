<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PrTracker;

class PrTrackerController extends Controller
{
    public function index(){
        
    }


    public function show(Request $request, $id){
        $pr_tracker = PrTracker::with(['responsible_unit'])->find($id);
        return view('vendor.voyager.PrTracker.read', [
            'pr_tracker' => $pr_tracker,
        ]);
    }


    public function create(Request $request){
        $latest_pr_tracker_no = PrTracker::max('no');
        if($latest_pr_tracker_no){
            $latest_pr_tracker_no = 'has the latest tracker number';
        } else{
            $latest_pr_tracker_no = 'KC-' . date('Y') . '-' . date('m') . '-' . '0001';
        }

        return view('vendor.voyager.PrTracker.edit-add', [
            'latest_pr_tracker_no' => $latest_pr_tracker_no,
        ]);
    }


    public function store(Request $request){

    }
}
