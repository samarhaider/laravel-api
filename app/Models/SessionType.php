<?php

namespace App\Models;

use App\Models\AppModel;

class SessionType extends AppModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'session_types';

    /**
     * The attributes for validation rules.
     *
     * @var string
     */
    protected $rules = [
        'name' => 'required',
        'duration' => 'required',
        'duration_unit' => 'required',
        'price' => 'required',
        'payable_per_duration' => 'required',
        'payable_per_person' => 'required|boolean',
        'deactivated' => 'required|boolean',
        'limited_to' => 'required|integer',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'duration', 'duration_unit', 'price', 'payable_per_duration', 'payable_per_person', 'deactivated', 'limited_to', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['user_id'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = ['payable_per_duration' => 'boolean', 'payable_per_person' => 'boolean', 'deactivated' => 'boolean'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

}
