<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Provider extends Model
{
    
    protected $fillable = [
        'name', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
