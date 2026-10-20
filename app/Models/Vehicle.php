<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Vehicle extends Model {
 protected $fillable=['name','registration_number','type','seats','daily_rate','status','make','model','year','color','notes','image_url'];
 protected $casts=['daily_rate'=>'decimal:2','seats'=>'integer','year'=>'integer'];
 public function bookings(){return $this->hasMany(Booking::class);}
}
