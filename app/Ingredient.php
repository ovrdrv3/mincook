<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    public function recipes()
    {
    	// return $this->hasManyThrough('App\Recipe', 'App\Instruction');
    }
}
