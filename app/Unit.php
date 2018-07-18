<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name','name_eng','prefix'];
    public $timestamps = false;
}
