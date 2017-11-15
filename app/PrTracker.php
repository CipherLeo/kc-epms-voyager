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
}
