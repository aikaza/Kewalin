<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmitUuid extends Model
{
    protected $fillable = ['uuid'];
    public $table = 'submituuid';
}
