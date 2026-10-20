<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Maintenance;
use App\Models\Payment;
use App\Models\Vehicle;
class ReportController extends Controller {
 public function summary(){$n=Vehicle::count();$r=Vehicle::where('status','rented')->count();return response()->json(['fleet'=>['total'=>$n,'available'=>Vehicle::where('status','available')->count(),'rented'=>$r,'maintenance'=>Vehicle::where('status','maintenance')->count(),'utilisation_percent'=>$n?round($r/$n*100,1):0],'bookings'=>['total'=>Booking::count(),'active'=>Booking::where('status','active')->count(),'upcoming'=>Booking::whereIn('status',['pending','confirmed'])->whereDate('start_date','>=',today())->count()],'customers'=>['total'=>Customer::count()],'payments'=>['paid_total_ugx'=>(float)Payment::where('status','paid')->sum('amount'),'pending_total_ugx'=>(float)Payment::where('status','pending')->sum('amount'),'records'=>Payment::count()],'maintenance'=>['total'=>Maintenance::count(),'open'=>Maintenance::whereIn('status',['scheduled','in_progress'])->count(),'overdue'=>Maintenance::whereIn('status',['scheduled','in_progress'])->whereDate('due_date','<',today())->count()]]);}
}
