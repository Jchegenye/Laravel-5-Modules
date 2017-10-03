<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{   

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'machine_name', 'pid',
    ];

}