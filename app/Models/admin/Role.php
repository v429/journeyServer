<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends BaseModel
{
    protected $table = 'role';
    protected $primaryKey = 'id';
    use SoftDeletes;

}