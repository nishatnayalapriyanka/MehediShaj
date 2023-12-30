<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    use HasFactory;
    protected $table = "customer";
    protected $primaryKey = "phone";
    protected $keyType = 'string';
    public $timestamps = false;


    public function appoint_art_cus() {
        return $this->belongsTo(AppointArtCusModel::class, 'customer_phone', 'phone');
    }

}
