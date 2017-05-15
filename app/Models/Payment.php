<?php

namespace App\Models;

use App\Models\AppModel;

class Payment extends AppModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payments';

    /**
     * The attributes for validation rules.
     *
     * @var string
     */
    
    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'client_data' => 'required',
        'description' => 'nullable',
        'amount' => 'required',
        'payment_date' => 'required|date',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'client_id', 'client_data', 'description', 'amount', 'payment_date', 'deleted_at', 'created_at', 'updated_at'];

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
    protected $dates = ['payment_date', 'deleted_at', 'created_at', 'updated_at'];

    public function Client()
    {
        return $this->belongsTo('App\Models\Client');
    }
    
    public function scopeFindClient($query, $client_id)
    {
        return $query->where('client_id', '=', $client_id);
    }
}
