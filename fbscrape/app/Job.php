<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_job_hirring';
    protected $fillable = ['company_name', 'company_mail', 'programing_language', 'job_position', 'link_post', 'post_desc', 'status'];
}
