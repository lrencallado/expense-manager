<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExpenseCat extends Model
{
    //
    protected $fillable = [
        'name', 'description', 'color',
    ];

    public function expenses() 
    {
        return $this->hasMany('App\Expenses', 'category_id');
    }
}
