<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplementalRequest extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public static function getNewCode(){
        $latest_pr_no = '';
        $latest_pr = SupplementalRequest::orderBy('id', 'desc')->first();

        if($latest_pr != null){
            $latest_pr_no_fragments = explode('-', $latest_pr->pr_no);
            
            $month_now = date('m');
            $year_now = date('Y');
    
            if(intval($latest_pr_no_fragments[1]) == $month_now && intval($latest_pr_no_fragments[2]) == $year_now){
                $latest_pr_no_fragments[0] = intval($latest_pr_no_fragments[0]) + 1;
                $latest_pr_no = $latest_pr_no_fragments[0] . '-' . $latest_pr_no_fragments[1] . '-' . $latest_pr_no_fragments[2];
            } else{
                $latest_pr_no = '0000' . $month_now . $year_now;
            }
        }

        return $latest_pr_no;
    }
}
