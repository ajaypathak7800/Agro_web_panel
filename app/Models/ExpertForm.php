<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class expertform extends Model
{
    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'expert_forms';
    
    // If the primary key is not `id`, specify it here
    protected $primaryKey = 'id';

    // Specify any fillable fields if you plan to use mass assignment
    protected $fillable = [
        // List of fillable fields
    ];
}
