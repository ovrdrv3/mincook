<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $guarded = [];

    // not going this route because it makes the app unnecessarily complex.
    // just going to add id to url and then slug
    // public function getRouteKeyName()
    // {
    //     return 'name';
    // }

    public function path()
    {
        return "/recipe/{$this->id}" . "-" . Str::slug($this->name);
    }

    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient');
    }
}
