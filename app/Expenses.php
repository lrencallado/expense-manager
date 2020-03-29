<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    //
    protected $fillable = [
        'user_id', 'category_id', 'category_name', 'amount', 'entry_date',
    ];

    
}
