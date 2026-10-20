<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class VehicleController extends Controller {
 public function index(Request $r){$q=Vehicle::query();if($r->filled('status'))$q->where('status',$r->status);if($r->filled('search'))$q->where(fn($x)=>$x->where('name','like','%'.$r->search.'%')->orWhere('registration_number','like','%'.$r->search.'%'));return $q->latest()->paginate(20);}
 public function store(Request $r){$d=$r->validate(['name'=>'required|string|max:150','registration_number'=>'required|string|max:30|unique:vehicles','type'=>'required|in:SUV,Sedan,Van,Crossover,Pickup,Other','seats'=>'required|integer|min:1|max:60','daily_rate'=>'required|numeric|min:0','status'=>'required|in:available,rented,maintenance','make'=>'nullable|string|max:80','model'=>'nullable|string|max:80','year'=>'nullable|integer|min:1950|max:2100','color'=>'nullable|string|max:40','notes'=>'nullable|string|max:2000']);return response()->json(Vehicle::create($d),201);}
 public function show(Vehicle $vehicle){return $vehicle->load('bookings');}
 public function update(Request $r,Vehicle $vehicle){$d=$r->validate(['name'=>'sometimes|required|string|max:150','registration_number'=>['sometimes','required','string','max:30',Rule::unique('vehicles')->ignore($vehicle->id)],'type'=>'sometimes|required|in:SUV,Sedan,Van,Crossover,Pickup,Other','seats'=>'sometimes|required|integer|min:1|max:60','daily_rate'=>'sometimes|required|numeric|min:0','status'=>'sometimes|required|in:available,rented,maintenance','make'=>'nullable|string|max:80','model'=>'nullable|string|max:80','year'=>'nullable|integer|min:1950|max:2100','color'=>'nullable|string|max:40','notes'=>'nullable|string|max:2000']);$vehicle->update($d);return $vehicle->fresh();}
 public function destroy(Vehicle $vehicle){if($vehicle->bookings()->whereNotIn('status',['cancelled','completed'])->exists())return response()->json(['message'=>'Vehicle has active/future bookings.'],422);$vehicle->delete();return response()->json(['message'=>'Deleted']);}
}
