<?php

namespace App\Models;

use App\Models\AppModel;

class Client extends AppModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';

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
    protected $fillable = ['user_id', 'username', 'email', 'password', 'avatar', 'firstname', 'surname', 'address', 'gender', 'dob', 'mobile', 'landline', 'emergency_contact_name', 'emergency_contact_relationship', 'emergency_contact_number', 'contraindications', 'notes', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['user_id', 'password', 'updated_at', 'deleted_at'];

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

    public function measurements()
    {
        return $this->hasMany('App\Models\Measurement');
    }

    /**
     * The bookings that belong to the user.
     */
    public function bookings()
    {
        return $this->belongsToMany('App\Models\Booking')
//                ->using('App\Models\BookingClient')
                ->withPivot('paid')
                ->withTimestamps();
    }
}
