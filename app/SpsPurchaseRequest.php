<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class SpsPurchaseRequest extends Model
{
    protected $connection = 'sps_mysql';
    protected $table = 'tbl_purchase_request';
    protected $primaryKey = 'pr_no';

    public $incrementing = false;
    public $timestamps = false;
}
