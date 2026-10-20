<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    VehicleController,
    CustomerController,
    BookingController,
    PaymentController,
    MaintenanceController,
    ReportController,
    CustomerPortalController,
};

// ── Public ──────────────────────────────────────────────────
Route::get('/health', fn() => response()->json(['status' => 'ok', 'app' => 'Yuasa Fleet']));

// Staff login
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

// Customer self-registration & login (same login endpoint, different role returned)
Route::post('/customer/register', [CustomerPortalController::class, 'register'])->middleware('throttle:10,1');

// Public vehicle browsing (no auth needed for the portal landing page)
Route::get('/portal/vehicles', [CustomerPortalController::class, 'vehicles']);

// ── Authenticated: shared ────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout',       [AuthController::class, 'logout']);
    Route::get('/me',            [AuthController::class, 'me']);
    Route::put('/me/password',   [AuthController::class, 'changePassword']);

    // ── Customer portal routes (role: customer) ──────────────
    Route::middleware('role:customer')->prefix('portal')->group(function () {
        Route::get('/vehicles',             [CustomerPortalController::class, 'vehicles']);
        Route::post('/book',                [CustomerPortalController::class, 'book']);
        Route::get('/my-bookings',          [CustomerPortalController::class, 'myBookings']);
        Route::get('/profile',              [CustomerPortalController::class, 'profile']);
        Route::post('/bookings/{booking}/cancel', [CustomerPortalController::class, 'cancelBooking']);
        Route::post('/pay',                       [CustomerPortalController::class, 'pay']);
    });

    // ── Staff / admin routes (role: admin or agent) ──────────
    Route::middleware('role:admin,agent')->group(function () {
        Route::apiResource('vehicles',    VehicleController::class);
        Route::apiResource('customers',   CustomerController::class);
        Route::apiResource('bookings',    BookingController::class);
        Route::post('/bookings/{booking}/status', [BookingController::class, 'status']);
        Route::apiResource('payments',    PaymentController::class);
        Route::apiResource('maintenance', MaintenanceController::class);
        Route::get('/reports/summary',    [ReportController::class, 'summary']);
    });
});
