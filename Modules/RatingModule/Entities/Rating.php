<?php

namespace Modules\RatingModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\UserModule\Entities\User;
class Rating extends Model
{
    use HasFactory;

    protected $guarded = [];
    

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    
}
