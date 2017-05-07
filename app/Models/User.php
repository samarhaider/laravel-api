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
     * The attributes for validation rules.
     *
     * @var array
     */
    protected $rules = [
        'email' => 'required|email|unique:users',
        'password' => 'required',
//        'username' => 'required|unique:users',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'status', 'password', 'remember_token', 'deleted_at', 'updated_at',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['password', 'facebook', 'twitter', 'google', 'user_type'];

    public function isDeactived()
    {
        return ($this->status == self::STATUS_DE_ACTIVE) ? true : false;
    }

    public function isBlocked()
    {
        return ($this->status == self::STATUS_BLOCK) ? true : false;
    }

    public function changePasswordValidation($add = true)
    {
        if ($add) {
            $this->rules = ['password' => 'required'];
        } else {
            unset($this->rules['password']);
        }
    }
}
