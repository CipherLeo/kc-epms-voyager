<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Voyager\VoyagerBreadController as BaseVoyagerBreadController;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Facades\Voyager;

use Illuminate\Http\Request;
use App\PrTracker;

class PrTrackerController extends BaseVoyagerBreadController
{
    public function show(Request $request, $id){
        $pr_tracker = PrTracker::with(['responsible_unit', 'supplemental_requests'])->find($id);
        return view('vendor.voyager.PrTracker.read', [
            'pr_tracker' => $pr_tracker,
        ]);
    }


    public function create(Request $request){
        $latest_pr_tracker_no = PrTracker::getNewCode();

        $slug = $this->getSlug($request);
        
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
                            ? new $dataType->model_name()
                            : false;

        foreach ($dataType->addRows as $key => $row) {
            $details = json_decode($row->details);
            $dataType->addRows[$key]['col_width'] = isset($details->width) ? $details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        return Voyager::view('vendor.voyager.PrTracker.add', compact(
            'dataType', 
            'dataTypeContent', 
            'isModelTranslatable',
            'latest_pr_tracker_no'
        ));
    }


    public function edit(Request $request, $id){
        $pr_tracker = PrTracker::with(['responsible_unit', 'supplemental_requests'])->find($id);

        return view('vendor.voyager.PrTracker.edit', [
            'pr_tracker' => $pr_tracker,
        ]);
    }


    public function store(Request $request){
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->ajax()) {
            $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

            event(new BreadDataAdded($dataType, $data));

            return redirect()
                ->route("voyager.pr-trackers.edit", ['id' => $data['id']])
                ->with([
                        'message'    => __('voyager.generic.successfully_added_new')." {$dataType->display_name_singular} " . $data['no'],
                        'alert-type' => 'success',
                    ]);
        }
    }
}
