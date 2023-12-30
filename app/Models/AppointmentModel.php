<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentModel extends Model
{
    use HasFactory;
    protected $table = "appointment";
    protected $primaryKey = "appointment_id";
    protected $keyType = 'string';
    public $timestamps = false;

    public function appoint_art_cus() {
        return $this->belongsTo(AppointArtCusModel::class, 'appointment_id', 'appointment_id');
    }
}
