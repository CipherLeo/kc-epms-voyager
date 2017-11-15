<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Voyager\VoyagerBreadController as BaseVoyagerBreadController;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Events\BreadDataAdded;

use Illuminate\Http\Request;
use App\PrTracker;

class PrTrackerController extends BaseVoyagerBreadController
{
    public function show(Request $request, $id){
        $pr_tracker = PrTracker::with(['responsible_unit'])->find($id);
        return view('vendor.voyager.PrTracker.read', [
            'pr_tracker' => $pr_tracker,
        ]);
    }


    public function create(Request $request){
        $latest_pr_tracker_no = PrTracker::withTrashed()->max('no');
        if(!$latest_pr_tracker_no){
            $latest_pr_tracker_no = 'KC-' . date('Y') . '-' . date('m') . '-' . '0001';
        } else{
            $tracker_codes = explode('-', $latest_pr_tracker_no);
            $tracker_codes[3] = intval($tracker_codes[3]) + 1;
            if($tracker_codes[3] < 10){
                $tracker_codes[3] = '000' . $tracker_codes[3];
            } 
            elseif($tracker_codes[3] < 100){
                $tracker_codes[3] = '00' . $tracker_codes[3];
            } else{
                $tracker_codes[3] = '0' . $tracker_codes[3];
            }
            $latest_pr_tracker_no = $tracker_codes[0] . '-' . $tracker_codes[1] . '-' . $tracker_codes[2] . '-' . $tracker_codes[3];
        }

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

        return Voyager::view('vendor.voyager.PrTracker.edit-add', compact(
            'dataType', 
            'dataTypeContent', 
            'isModelTranslatable',
            'latest_pr_tracker_no'
        ));
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
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                        'message'    => __('voyager.generic.successfully_added_new')." {$dataType->display_name_singular}",
                        'alert-type' => 'success',
                    ]);
        }
    }
}
