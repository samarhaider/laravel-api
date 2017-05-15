<?php

namespace App\Models;

use App\Models\AppModel;

class Measurement extends AppModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'measurements';

    /**
     * The attributes for validation rules.
     *
     * @var string
     */
    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'bmi' => 'required',
        'bmr' => 'required',
        'body_fat' => 'required',
        'calf' => 'required',
        'chest' => 'required',
        'height' => 'required',
        'shoulders' => 'required',
        'thigh' => 'required',
        'upper_arm' => 'required',
        'waist' => 'required',
        'weight' => 'required',
        'notes' => 'nullable',
        'goals' => 'nullable',
        'measurement_date' => 'required|date',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'client_id', 'bmi', 'bmr', 'body_fat', 'calf', 'chest', 'height', 'shoulders', 'thigh', 'upper_arm', 'waist', 'weight', 'goals', 'notes', 'measurement_date', 'deleted_at', 'created_at', 'updated_at'];

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
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['measurement_date', 'deleted_at', 'created_at', 'updated_at'];

    public function Client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function scopeFindClient($query, $client_id)
    {
        return $query->where('client_id', '=', $client_id);
    }
}
