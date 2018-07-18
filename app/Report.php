<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [ 'date_start', 'date_end', 'path', 'note' ];
}
