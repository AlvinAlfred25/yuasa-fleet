<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class CustomerController extends Controller {
 public function index(Request $r){$q=Customer::query();if($r->filled('search'))$q->where(fn($x)=>$x->where('name','like','%'.$r->search.'%')->orWhere('phone','like','%'.$r->search.'%')->orWhere('email','like','%'.$r->search.'%'));return $q->latest()->paginate(20);}
 public function store(Request $r){$d=$r->validate(['name'=>'required|string|max:150','phone'=>'required|string|max:30|unique:customers','email'=>'nullable|email|max:190','customer_type'=>'required|in:individual,corporate','address'=>'nullable|string|max:500','national_id_reference'=>'nullable|string|max:80','notes'=>'nullable|string|max:2000']);return response()->json(Customer::create($d),201);}
 public function show(Customer $customer){return $customer->load('bookings');}
 public function update(Request $r,Customer $customer){$d=$r->validate(['name'=>'sometimes|required|string|max:150','phone'=>['sometimes','required','string','max:30',Rule::unique('customers')->ignore($customer->id)],'email'=>'nullable|email|max:190','customer_type'=>'sometimes|required|in:individual,corporate','address'=>'nullable|string|max:500','national_id_reference'=>'nullable|string|max:80','notes'=>'nullable|string|max:2000']);$customer->update($d);return $customer->fresh();}
 public function destroy(Customer $customer){if($customer->bookings()->exists())return response()->json(['message'=>'Customer has booking history and cannot be deleted.'],422);$customer->delete();return response()->json(['message'=>'Deleted']);}
}
