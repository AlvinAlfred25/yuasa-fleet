<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {
 protected $fillable=['payment_reference','booking_id','customer_id','amount','currency','method','status','paid_at','recorded_by','notes'];
 protected $casts=['amount'=>'decimal:2','paid_at'=>'datetime'];
 public function customer(){return $this->belongsTo(Customer::class);}
 public function booking(){return $this->belongsTo(Booking::class);}
}
