<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointArtCusModel extends Model
{
    use HasFactory;
    protected $table = "appoint_art_cus";
    protected $primaryKey = "appointment_id";
    protected $keyType = 'string';
    public $timestamps = false;


    public function artist() {
        return $this->hasOne(ArtistModel::class, 'phone', 'artist_phone');
    }

    public function customer() {
        return $this->hasOne(CustomerModel::class, 'phone', 'customer_phone');
    }

    public function appointment() {
        return $this->hasOne(AppointmentModel::class, 'appointment_id', 'appointment_id');
    }

    public function payment() {
        return $this->hasOne(PaymentModel::class, 'appointment_id', 'appointment_id');
    }

    public function feedback() {
        return $this->hasOne(FeedbackModel::class, 'appointment_id', 'appointment_id');
    }



    public function artists_for_feedback() {
        return $this->belongsTo(ArtistModel::class, 'phone', 'artist_phone');
    }
}
