<?php

namespace Modules\RoleModule\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelHasPermission extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\RoleModule\Database\factories\ModelHasPermissionFactory::new();
    }
}
