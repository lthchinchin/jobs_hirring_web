<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand_ajax extends Model {
    protected $primaryKey = 'brand_id';
    public $timestamps = false;
    protected $table = 'tbl_brand_product';
    protected $fillable = ['brand_name', 'brand_status'];

}
