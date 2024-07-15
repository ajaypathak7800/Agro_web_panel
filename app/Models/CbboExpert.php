<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CbboExpert extends Model
{
    use HasFactory;
    protected $table = 'cbbo_experts';
    protected $fillable = [
        'ia_name',
        'cbbo_name',

        'cbbo_expert_name',
        'cbbo_type',
        'designation',
        'ed_qualification',
        'experience',
        'state',
        'block',
        'district',
        'contact_no',
        'email_id',
    ];
    public $timestamps = false; // Disable automatic timestamps
}

