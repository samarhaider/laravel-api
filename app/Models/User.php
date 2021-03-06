<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use App\Models\AppModel;

class User extends AppModel implements AuthenticatableContract
{

    use Notifiable,
        Authenticatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes for validation rules.
     *
     * @var string
     */
    protected $rules = [
        'email' => 'required|email|unique:users',
        'password' => 'required',
        'username' => 'required|unique:users',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password', 'avatar', 'firstname', 'surname', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'deleted_at', 'updated_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

//    public function isBlocked()
//    {
//        return ($this->status == self::STATUS_BLOCK) ? true : false;
//    }

    public function changePasswordValidation($add = true)
    {
        if ($add) {
            $this->rules = ['password' => 'required'];
        } else {
            unset($this->rules['password']);
        }
    }
}
