<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Section extends Model
{
	protected $connection = 'lib_mysql';
    protected $table = 'lib_section';
	protected $primaryKey = 'section_id';

	public $incrementing = true;
	public $timestamps = false;
}
