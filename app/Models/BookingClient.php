<?php

namespace App\Models;

use App\Models\AppModel;

class BookingClient extends AppModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'booking_client';

    /**
     * The attributes for validation rules.
     *
     * @var string
     */
    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'booking_id' => 'required|exists:bookings,id',
        'paid' => 'required|boolean',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['booking_id', 'client_id', 'paid', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = ['paid' => 'boolean'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function Client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function Booking()
    {
        return $this->belongsTo('App\Models\Booking');
    }
}
