<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = ['key','value','description'];
    public $table = 'configurations';
    public $timestamps = false;
}
