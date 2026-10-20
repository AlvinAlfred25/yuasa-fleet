<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use Illuminate\Http\Request;
class MaintenanceController extends Controller {
 public function index(){return Maintenance::with('vehicle:id,name,registration_number')->orderBy('due_date')->paginate(20);}
 public function store(Request $r){$d=$r->validate(['vehicle_id'=>'required|exists:vehicles,id','task'=>'required|string|max:180','due_date'=>'required|date','estimated_cost'=>'nullable|numeric|min:0','priority'=>'required|in:low,medium,high','status'=>'required|in:scheduled,in_progress,completed','completed_at'=>'nullable|date','notes'=>'nullable|string|max:2000']);$d['created_by']=$r->user()->id;return response()->json(Maintenance::create($d)->load('vehicle'),201);}
 public function show(Maintenance $maintenance){return $maintenance->load('vehicle');}
 public function update(Request $r,Maintenance $maintenance){$d=$r->validate(['vehicle_id'=>'sometimes|required|exists:vehicles,id','task'=>'sometimes|required|string|max:180','due_date'=>'sometimes|required|date','estimated_cost'=>'nullable|numeric|min:0','priority'=>'sometimes|required|in:low,medium,high','status'=>'sometimes|required|in:scheduled,in_progress,completed','completed_at'=>'nullable|date','notes'=>'nullable|string|max:2000']);if(($d['status']??null)==='completed'&&!isset($d['completed_at']))$d['completed_at']=now();$maintenance->update($d);return $maintenance->fresh()->load('vehicle');}
 public function destroy(Maintenance $maintenance){$maintenance->delete();return response()->json(['message'=>'Deleted']);}
}
