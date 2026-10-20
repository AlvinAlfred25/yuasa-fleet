<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Booking extends Model {
 protected $fillable=['booking_number','customer_id','vehicle_id','start_date','end_date','pickup_location','return_location','daily_rate','days','total_amount','status','notes','created_by'];
 protected $casts=['start_date'=>'date:Y-m-d','end_date'=>'date:Y-m-d','daily_rate'=>'decimal:2','total_amount'=>'decimal:2','days'=>'integer'];
 public function customer(){return $this->belongsTo(Customer::class);}
 public function vehicle(){return $this->belongsTo(Vehicle::class);}
}
