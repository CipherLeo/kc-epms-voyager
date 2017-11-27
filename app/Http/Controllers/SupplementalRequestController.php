<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Voyager\VoyagerBreadController as BaseVoyagerBreadController;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Facades\Voyager;

use Illuminate\Http\Request;
use App\SupplementalRequest;

class SupplementalRequestController extends BaseVoyagerBreadController
{
    public function store(Request $request){
        $supplemental_request = new SupplementalRequest;

        $supplemental_request->pr_tracker_id = $request->pr_tracker_id;
        $supplemental_request->pr_no = SupplementalRequest::getNewCode();
        $supplemental_request->purpose = $request->purpose;
        $supplemental_request->proposed_date = $request->proposed_date;
        $supplemental_request->proposed_venue = $request->proposed_venue;
        $supplemental_request->proposed_amount = $request->proposed_amount;

        $supplemental_request->save();

        return json_encode($supplemental_request);
    }

    
    public function destroy(Request $request, $id){
        $supplemental_request = SupplementalRequest::find($id);
        $supplemental_request->delete();
        return 'Deleted successfully';
    }
}
