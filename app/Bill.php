<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['ordercode', 'filepath', 'filename', 'type'];

    public function test()
    {

    }

}
