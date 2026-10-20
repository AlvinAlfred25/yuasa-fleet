<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
 protected $fillable=['user_id','name','phone','email','customer_type','address','national_id_reference','notes'];
 public function user(){return $this->belongsTo(User::class);}
 public function bookings(){return $this->hasMany(Booking::class);}
 public function payments(){return $this->hasMany(Payment::class);}
}
