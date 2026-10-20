<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CustomerPortalController extends Controller
{
    // ── Registration ─────────────────────────────────────────
    public function register(Request $r)
    {
        $d = $r->validate([
            'name'     => 'required|string|max:120',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|string|max:30|unique:customers,phone',
            'password' => 'required|string|min:8|confirmed',
            'address'  => 'nullable|string|max:250',
        ]);

        return DB::transaction(function () use ($d) {
            $user = User::create([
                'name'     => $d['name'],
                'email'    => $d['email'],
                'password' => Hash::make($d['password']),
                'role'     => 'customer',
                'active'   => true,
            ]);

            $customer = Customer::create([
                'user_id'       => $user->id,
                'name'          => $d['name'],
                'email'         => $d['email'],
                'phone'         => $d['phone'],
                'address'       => $d['address'] ?? null,
                'customer_type' => 'individual',
            ]);

            $token = $user->createToken('yuasa-portal')->plainTextToken;

            return response()->json([
                'token'    => $token,
                'user'     => $user,
                'customer' => $customer,
            ], 201);
        });
    }

    // ── Browse available vehicles ─────────────────────────────
    public function vehicles(Request $r)
    {
        $vehicles = Vehicle::where('status', 'available')
            ->select('id','name','make','model','year','type','seats','daily_rate','color','status','image_url')
            ->get();

        return response()->json($vehicles);
    }

    // ── Submit a booking request ──────────────────────────────
    public function book(Request $r)
    {
        $user     = $r->user();
        $customer = $user->customer;

        if (!$customer) {
            return response()->json(['message' => 'No customer profile linked to this account.'], 422);
        }

        $d = $r->validate([
            'vehicle_id'      => 'required|exists:vehicles,id',
            'start_date'      => 'required|date|after_or_equal:today',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'pickup_location' => 'nullable|string|max:250',
            'return_location' => 'nullable|string|max:250',
            'notes'           => 'nullable|string|max:1000',
        ]);

        return DB::transaction(function () use ($d, $customer) {
            $vehicle = Vehicle::whereKey($d['vehicle_id'])->lockForUpdate()->firstOrFail();

            if ($vehicle->status === 'maintenance') {
                return response()->json(['message' => 'Vehicle is currently under maintenance.'], 422);
            }

            $conflict = Booking::where('vehicle_id', $vehicle->id)
                ->whereNotIn('status', ['cancelled', 'completed'])
                ->whereDate('start_date', '<=', $d['end_date'])
                ->whereDate('end_date',   '>=', $d['start_date'])
                ->exists();

            if ($conflict) {
                return response()->json(['message' => 'Vehicle is not available for the selected dates.'], 422);
            }

            $days  = max(1, Carbon::parse($d['start_date'])->diffInDays(Carbon::parse($d['end_date'])));
            $total = $days * (float) $vehicle->daily_rate;

            $booking = Booking::create([
                'booking_number'  => 'YCP-' . strtoupper(Str::random(8)),
                'customer_id'     => $customer->id,
                'vehicle_id'      => $vehicle->id,
                'start_date'      => $d['start_date'],
                'end_date'        => $d['end_date'],
                'pickup_location' => $d['pickup_location'] ?? null,
                'return_location' => $d['return_location'] ?? null,
                'daily_rate'      => $vehicle->daily_rate,
                'days'            => $days,
                'total_amount'    => $total,
                'status'          => 'pending',
                'notes'           => $d['notes'] ?? null,
                'created_by'      => null,
            ]);

            return response()->json($booking->load('vehicle'), 201);
        });
    }

    // ── Customer's own bookings ───────────────────────────────
    public function myBookings(Request $r)
    {
        $customer = $r->user()->customer;

        if (!$customer) {
            return response()->json([]);
        }

        $bookings = Booking::where('customer_id', $customer->id)
            ->with('vehicle:id,name,make,model,registration_number,daily_rate')
            ->latest()
            ->get()
            ->map(function ($booking) {
                // Attach payment status to each booking
                $payment = \App\Models\Payment::where('booking_id', $booking->id)
                    ->orderByDesc('created_at')
                    ->first();
                $booking->payment_status    = $payment?->status ?? null;
                $booking->payment_reference = $payment?->payment_reference ?? null;
                return $booking;
            });

        return response()->json($bookings);
    }

    // ── Customer profile ─────────────────────────────────────
    public function profile(Request $r)
    {
        $user     = $r->user();
        $customer = $user->customer;

        return response()->json([
            'user'     => $user,
            'customer' => $customer,
        ]);
    }

    // ── Make a payment ───────────────────────────────────────
    public function pay(Request $r)
    {
        $user     = $r->user();
        $customer = $user->customer;

        if (!$customer) {
            return response()->json(['message' => 'No customer profile linked to this account.'], 422);
        }

        $d = $r->validate([
            'booking_id' => 'required|exists:bookings,id',
            'method'     => 'required|in:mobile_money,bank_transfer,card,cash',
            'notes'      => 'nullable|string|max:500',
        ]);

        // Confirm the booking belongs to this customer
        $booking = \App\Models\Booking::findOrFail($d['booking_id']);
        if ($booking->customer_id !== $customer->id) {
            return response()->json(['message' => 'Not authorised.'], 403);
        }

        // Block double payments
        $exists = \App\Models\Payment::where('booking_id', $booking->id)
            ->whereIn('status', ['pending', 'paid'])
            ->exists();
        if ($exists) {
            return response()->json(['message' => 'A payment record already exists for this booking.'], 422);
        }

        $payment = \App\Models\Payment::create([
            'payment_reference' => 'CPY-' . strtoupper(\Illuminate\Support\Str::random(8)),
            'booking_id'        => $booking->id,
            'customer_id'       => $customer->id,
            'amount'            => $booking->total_amount,
            'currency'          => 'UGX',
            'method'            => $d['method'],
            'status'            => 'pending',
            'notes'             => $d['notes'] ?? null,
        ]);

        return response()->json([
            'message'   => 'Payment request submitted. Staff will confirm receipt.',
            'payment'   => $payment,
            'reference' => $payment->payment_reference,
        ], 201);
    }
    public function cancelBooking(Request $r, Booking $booking)
    {
        $customer = $r->user()->customer;

        if (!$customer || $booking->customer_id !== $customer->id) {
            return response()->json(['message' => 'Not authorised.'], 403);
        }

        if (in_array($booking->status, ['active', 'completed'])) {
            return response()->json(['message' => 'Cannot cancel an active or completed booking.'], 422);
        }

        $booking->update(['status' => 'cancelled']);

        return response()->json(['message' => 'Booking cancelled.', 'booking' => $booking->fresh()]);
    }
}
