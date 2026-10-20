<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Maintenance extends Model {
 protected $table='maintenance_records';
 protected $fillable=['vehicle_id','task','due_date','estimated_cost','priority','status','completed_at','notes','created_by'];
 protected $casts=['due_date'=>'date','estimated_cost'=>'decimal:2','completed_at'=>'datetime'];
 public function vehicle(){return $this->belongsTo(Vehicle::class);}
}
