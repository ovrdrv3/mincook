<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/recipe/{$this->id}";
    }
}
