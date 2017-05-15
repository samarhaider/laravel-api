<?php

namespace App\Models;

use App\Models\AppModel;
use Carbon\Carbon;

class Booking extends AppModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bookings';

    /**
     * The attributes for validation rules.
     *
     * @var string
     */
    protected $rules = [
//        'clients' => 'required',
        'session_type_id' => 'required|exists:session_types,id',
        'booking_date' => 'required|date_format:Y-m-d',
        'start_time' => 'required|date_format:H:i',
        'finish_time' => 'required|date_format:H:i',
//        'cancelled' => 'required|boolean',
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'session_type_id', 'booking_date', 'start_time', 'finish_time', 'cancelled', 'deleted_at', 'created_at', 'updated_at'];

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
    protected $casts = ['cancelled' => 'boolean'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

//    public function scopeFindClient($query, $client_id)
//    {
//        return $query->whereHas('booking_client', function ($query) use ($client_id) {
//                $query->where('client_id', '=', $client_id);
//            });
//    }

    public function SessionType()
    {
        return $this->belongsTo('App\Models\SessionType');
    }

    /**
     * The clients that belong to the role.
     */
    public function clients()
    {
        return $this->belongsToMany('App\Models\Client')
//                ->using('App\Models\BookingClient')
                ->withPivot('paid')
                ->withTimestamps();
    }

    public function scopeUpcomming($query)
    {
        return $query->where('booking_date', '>', Carbon::now());
    }
}
