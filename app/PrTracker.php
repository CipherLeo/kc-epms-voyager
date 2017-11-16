<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ResponsibleUnit;

class PrTracker extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function section(){
        return $this->belongsTo('App\Section');
    }
    public function responsible_unit(){
        return $this->belongsTo('App\ResponsibleUnit');
    }
    public function supplemental_requests(){
        return $this->hasMany('App\SupplementalRequest');
    }

    // CUSTOM
    public static function getLastNo(){
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
        return $latest_pr_tracker_no;
    }
}
