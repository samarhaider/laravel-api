<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use Alsofronie\Uuid\UuidModelTrait;

class AppModel extends Model
{

    use ValidatingTrait,
        UuidModelTrait,
        SoftDeletes;
//    protected $dateFormat = 'U';

    /**
     * The attributes for validation rules.
     *
     * @var array
     */
    protected $rules = [
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function customEagerLoads(array $eagers)
    {
        $this->with = $eagers;
        return $this;
    }
}
