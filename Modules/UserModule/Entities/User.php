<?php

namespace Modules\UserModule\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Token;
use Modules\OrderModule\Entities\Order;
use Modules\RoleModule\Entities\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    // Specify fillable fields for security
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function token()
    {
        return $this->hasOne(Token::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class, 'user_id');
    }
    /**
     * Assign a role to the user.
     *
     * @param string|\Modules\RoleModule\Entities\Role $role
     * @return void
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }

        DB::table('model_has_roles')->updateOrInsert(
            [
                'model_id' => $this->id,
                'model_type' => self::class,
            ],
            [
                'role_id' => $role->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Remove a role from the user.
     *
     * @param string|\Modules\RoleModule\Entities\Role $role
     * @return void
     */
    public function removeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
            if (!$role) {
                return; // لا يوجد دور بهذا الاسم
            }
        }

        DB::table('model_has_roles')->where([
            'model_id'   => $this->id,
            'model_type' => self::class,
            'role_id'    => $role->id,
        ])->delete();
    }


    /**
     * Check if the user has a specific role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Check if the user has a specific permission.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    /**
     * Get roles associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            'Modules\RoleModule\Entities\Role',
            'model_has_roles',
            'model_id',
            'role_id'
        )->wherePivot('model_type', self::class);
    }

    /**
     * Get permissions associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(
            'Modules\RoleModule\Entities\Permission',
            'model_has_permissions',
            'model_id',
            'permission_id'
        )->wherePivot('model_type', self::class);
    }

    /**

     * Get all permissions for the user, including those from roles.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllPermissions()
    {
        // Direct permissions assigned to the user
        $directPermissions = $this->permissions;

        // Permissions inherited from roles
        $rolePermissions = $this->roles->flatMap(function ($role) {
            return $role->permissions;
        });

        // Merge and return unique permissions
        return $directPermissions->merge($rolePermissions)->unique('id');
    }
}
