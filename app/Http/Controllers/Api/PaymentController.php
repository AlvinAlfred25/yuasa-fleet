<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PaymentController extends Controller {
 public function index(){return Payment::with(['customer:id,name','booking:id,booking_number'])->latest()->paginate(20);}
 public function store(Request $r){$d=$r->validate(['booking_id'=>'nullable|exists:bookings,id','customer_id'=>'required|exists:customers,id','amount'=>'required|numeric|gt:0','method'=>'required|in:cash,mobile_money,bank_transfer,card,other','status'=>'required|in:pending,paid,failed,refunded','paid_at'=>'nullable|date','notes'=>'nullable|string|max:2000']);$d['currency']='UGX';$d['payment_reference']='PAY-'.strtoupper(Str::random(10));$d['recorded_by']=$r->user()->id;return response()->json(Payment::create($d)->load(['customer','booking']),201);}
 public function show(Payment $payment){return $payment->load(['customer','booking']);}
 public function update(Request $r,Payment $payment){$d=$r->validate(['amount'=>'sometimes|required|numeric|gt:0','method'=>'sometimes|required|in:cash,mobile_money,bank_transfer,card,other','status'=>'sometimes|required|in:pending,paid,failed,refunded','paid_at'=>'nullable|date','notes'=>'nullable|string|max:2000']);$payment->update($d);return $payment->fresh();}
 public function destroy(Payment $payment){$payment->delete();return response()->json(['message'=>'Deleted']);}
}
