<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Customer;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Maintenance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin user ────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@yuasafleet.test'],
            [
                'name'     => 'Yuasa Administrator',
                'password' => Hash::make('ChangeMe123!'),
                'role'     => 'admin',
                'active'   => true,
            ]
        );

        // ── Vehicles ──────────────────────────────────────────
        $vehicles = [
            ['name'=>'Toyota Land Cruiser V8',  'registration_number'=>'UAA 001A', 'type'=>'SUV',     'seats'=>7, 'daily_rate'=>250000, 'status'=>'available',    'make'=>'Toyota',   'model'=>'Land Cruiser V8',  'year'=>2021, 'color'=>'White',
             'image_url'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/6/sixth/2008_Toyota_Land_Cruiser_(UZJ200R)_GXL_wagon_(2009-11-27).jpg/320px-2008_Toyota_Land_Cruiser_(UZJ200R)_GXL_wagon_(2009-11-27).jpg'],
            ['name'=>'Toyota Hiace Minibus',     'registration_number'=>'UAB 234B', 'type'=>'Minibus', 'seats'=>14,'daily_rate'=>180000, 'status'=>'rented',       'make'=>'Toyota',   'model'=>'Hiace',            'year'=>2020, 'color'=>'White',
             'image_url'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Toyota_Hiace_H200_(facelift%2C_second_gen)%2C_front_8.28.19.jpg/320px-Toyota_Hiace_H200_(facelift%2C_second_gen)%2C_front_8.28.19.jpg'],
            ['name'=>'Toyota Fortuner',          'registration_number'=>'UAC 567C', 'type'=>'SUV',     'seats'=>7, 'daily_rate'=>200000, 'status'=>'available',    'make'=>'Toyota',   'model'=>'Fortuner',         'year'=>2022, 'color'=>'Silver',
             'image_url'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/2016_Toyota_Fortuner_2.4_VRZ_AT_(facelift%2C_silver)%2C_front_8.27.19.jpg/320px-2016_Toyota_Fortuner_2.4_VRZ_AT_(facelift%2C_silver)%2C_front_8.27.19.jpg'],
            ['name'=>'Toyota Corolla Sedan',     'registration_number'=>'UAD 890D', 'type'=>'Sedan',   'seats'=>5, 'daily_rate'=>100000, 'status'=>'available',    'make'=>'Toyota',   'model'=>'Corolla',          'year'=>2020, 'color'=>'Black',
             'image_url'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/2019_Toyota_Corolla_sedan_%28facelift%2C_black%29%2C_front_8.15.19.jpg/320px-2019_Toyota_Corolla_sedan_%28facelift%2C_black%29%2C_front_8.15.19.jpg'],
            ['name'=>'Nissan X-Trail',           'registration_number'=>'UAE 112E', 'type'=>'SUV',     'seats'=>5, 'daily_rate'=>150000, 'status'=>'maintenance',  'make'=>'Nissan',   'model'=>'X-Trail',          'year'=>2019, 'color'=>'Grey',
             'image_url'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e9/2014_Nissan_X-Trail_%28T32%29_Ti_wagon_(2018-10-26)_01.jpg/320px-2014_Nissan_X-Trail_%28T32%29_Ti_wagon_(2018-10-26)_01.jpg'],
            ['name'=>'Toyota RAV4',              'registration_number'=>'UAF 345F', 'type'=>'SUV',     'seats'=>5, 'daily_rate'=>170000, 'status'=>'rented',       'make'=>'Toyota',   'model'=>'RAV4',             'year'=>2021, 'color'=>'Red',
             'image_url'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7f/2019_Toyota_RAV4_XLE_AWD_%28facelift%29%2C_front_12.2.19.jpg/320px-2019_Toyota_RAV4_XLE_AWD_%28facelift%29%2C_front_12.2.19.jpg'],
            ['name'=>'Mercedes Sprinter',        'registration_number'=>'UAG 678G', 'type'=>'Van',     'seats'=>16,'daily_rate'=>350000, 'status'=>'available',    'make'=>'Mercedes', 'model'=>'Sprinter',         'year'=>2020, 'color'=>'White',
             'image_url'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Mercedes-Benz_Sprinter_W907_%28facelift_2022%29%2C_front_8.12.22.jpg/320px-Mercedes-Benz_Sprinter_W907_%28facelift_2022%29%2C_front_8.12.22.jpg'],
            ['name'=>'Toyota Prado TX',          'registration_number'=>'UAH 901H', 'type'=>'SUV',     'seats'=>7, 'daily_rate'=>220000, 'status'=>'available',    'make'=>'Toyota',   'model'=>'Prado TX',         'year'=>2022, 'color'=>'Blue',
             'image_url'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/3/32/2010_Toyota_Prado_%28GRJ150R%29_GXL_wagon_(2011-04-23).jpg/320px-2010_Toyota_Prado_%28GRJ150R%29_GXL_wagon_(2011-04-23).jpg'],
            ['name'=>'Mitsubishi Pajero',        'registration_number'=>'UAI 234I', 'type'=>'SUV',     'seats'=>7, 'daily_rate'=>190000, 'status'=>'available',    'make'=>'Mitsubishi','model'=>'Pajero',          'year'=>2019, 'color'=>'Black',
             'image_url'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Mitsubishi_Pajero_Sport_%28KH0W%29_%28facelift%2C_black%29%2C_front_9.3.19.jpg/320px-Mitsubishi_Pajero_Sport_%28KH0W%29_%28facelift%2C_black%29%2C_front_9.3.19.jpg'],
            ['name'=>'Toyota Coaster Bus',       'registration_number'=>'UAJ 567J', 'type'=>'Bus',     'seats'=>30,'daily_rate'=>500000, 'status'=>'available',    'make'=>'Toyota',   'model'=>'Coaster',          'year'=>2021, 'color'=>'White',
             'image_url'=>'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Toyota_Coaster_%28B50%2C_facelift%29%2C_front_8.28.19.jpg/320px-Toyota_Coaster_%28B50%2C_facelift%29%2C_front_8.28.19.jpg'],
        ];

        $vehicleIds = [];
        foreach ($vehicles as $v) {
            $vehicle = Vehicle::updateOrCreate(
                ['registration_number' => $v['registration_number']],
                $v
            );
            $vehicleIds[] = $vehicle->id;
        }

        // ── Customers ─────────────────────────────────────────
        $customers = [
            ['name'=>'Kato Brian Ssemwanga',    'phone'=>'+256 700 123 456', 'email'=>'kato.brian@gmail.com',     'customer_type'=>'individual', 'address'=>'Kampala, Nakasero',    'national_id_reference'=>'CM9200000XXXX'],
            ['name'=>'Achieng Grace Otieno',    'phone'=>'+256 701 234 567', 'email'=>'grace.achieng@gmail.com',  'customer_type'=>'individual', 'address'=>'Entebbe, Kitooro',     'national_id_reference'=>'CF8900000XXXX'],
            ['name'=>'Mugisha Robert',          'phone'=>'+256 702 345 678', 'email'=>'r.mugisha@email.com',      'customer_type'=>'individual', 'address'=>'Kampala, Mengo',       'national_id_reference'=>'CM9100000XXXX'],
            ['name'=>'Nantale Sarah Namutebi',  'phone'=>'+256 703 456 789', 'email'=>'sarah.nantale@yahoo.com',  'customer_type'=>'individual', 'address'=>'Jinja, Main Street',   'national_id_reference'=>'CF9300000XXXX'],
            ['name'=>'Okello James Odongo',     'phone'=>'+256 704 567 890', 'email'=>'j.okello@outlook.com',     'customer_type'=>'individual', 'address'=>'Gulu, Laroo Division', 'national_id_reference'=>'CM8800000XXXX'],
            ['name'=>'Acme Uganda Ltd',         'phone'=>'+256 414 567 890', 'email'=>'fleet@acmeuganda.co.ug',   'customer_type'=>'corporate',  'address'=>'Kampala, Industrial Area', 'national_id_reference'=>'Corp-00123'],
            ['name'=>'Pearl Tours & Travel',    'phone'=>'+256 414 678 901', 'email'=>'bookings@pearltours.ug',   'customer_type'=>'corporate',  'address'=>'Kampala, Kololo',      'national_id_reference'=>'Corp-00456'],
            ['name'=>'Nakato Prossy Nalwanga',  'phone'=>'+256 705 678 901', 'email'=>'prossy.nakato@gmail.com',  'customer_type'=>'individual', 'address'=>'Kampala, Rubaga',      'national_id_reference'=>'CF9000000XXXX'],
            ['name'=>'Byamugisha Francis',      'phone'=>'+256 706 789 012', 'email'=>'f.byamugisha@gmail.com',   'customer_type'=>'individual', 'address'=>'Mbarara, Kakoba',      'national_id_reference'=>'CM8700000XXXX'],
            ['name'=>'Horizon Logistics Uganda','phone'=>'+256 414 789 012', 'email'=>'ops@horizonlogistics.ug', 'customer_type'=>'corporate',  'address'=>'Kampala, Port Bell Road','national_id_reference'=>'Corp-00789'],
        ];

        $customerIds = [];
        foreach ($customers as $c) {
            $customer = Customer::updateOrCreate(
                ['phone' => $c['phone']],
                $c
            );
            $customerIds[] = $customer->id;
        }

        // ── Bookings ──────────────────────────────────────────
        $bookingsData = [
            ['cIdx'=>0,'vIdx'=>0,'start'=>'-30 days','end'=>'-23 days','rate'=>250000,'days'=>7, 'status'=>'completed','pickup'=>'Kampala Airport','return'=>'Kampala Airport'],
            ['cIdx'=>1,'vIdx'=>2,'start'=>'-20 days','end'=>'-13 days','rate'=>200000,'days'=>7, 'status'=>'completed','pickup'=>'Entebbe Hotel','return'=>'Kampala CBD'],
            ['cIdx'=>2,'vIdx'=>3,'start'=>'-15 days','end'=>'-12 days','rate'=>100000,'days'=>3, 'status'=>'completed','pickup'=>'Kampala CBD','return'=>'Kampala CBD'],
            ['cIdx'=>5,'vIdx'=>6,'start'=>'-10 days','end'=>'-3 days', 'rate'=>350000,'days'=>7, 'status'=>'completed','pickup'=>'Industrial Area','return'=>'Industrial Area'],
            ['cIdx'=>3,'vIdx'=>7,'start'=>'-5 days', 'end'=>' +2 days','rate'=>220000,'days'=>7, 'status'=>'active',   'pickup'=>'Jinja Town','return'=>'Kampala CBD'],
            ['cIdx'=>6,'vIdx'=>1,'start'=>'-3 days', 'end'=>'+4 days', 'rate'=>180000,'days'=>7, 'status'=>'active',   'pickup'=>'Kampala CBD','return'=>'Entebbe Airport'],
            ['cIdx'=>4,'vIdx'=>5,'start'=>' +2 days','end'=>'+7 days', 'rate'=>170000,'days'=>5, 'status'=>'confirmed','pickup'=>'Gulu Town','return'=>'Kampala CBD'],
            ['cIdx'=>7,'vIdx'=>8,'start'=>' +5 days','end'=>'+8 days', 'rate'=>190000,'days'=>3, 'status'=>'pending',  'pickup'=>'Kampala CBD','return'=>'Kampala CBD'],
            ['cIdx'=>9,'vIdx'=>9,'start'=>'+10 days','end'=>'+12 days','rate'=>500000,'days'=>2, 'status'=>'pending',  'pickup'=>'Port Bell','return'=>'Port Bell'],
            ['cIdx'=>8,'vIdx'=>0,'start'=>'+15 days','end'=>'+22 days','rate'=>250000,'days'=>7, 'status'=>'confirmed','pickup'=>'Mbarara Town','return'=>'Kampala CBD'],
        ];

        $bookingIds = [];
        foreach ($bookingsData as $i => $b) {
            $cId   = $customerIds[$b['cIdx']];
            $vId   = $vehicleIds[$b['vIdx']];
            $start = Carbon::now()->modify($b['start'])->toDateString();
            $end   = Carbon::now()->modify($b['end'])->toDateString();
            $total = $b['rate'] * $b['days'];
            $ref   = 'BK-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT);

            $booking = Booking::updateOrCreate(
                ['booking_number' => $ref],
                [
                    'customer_id'      => $cId,
                    'vehicle_id'       => $vId,
                    'start_date'       => $start,
                    'end_date'         => $end,
                    'pickup_location'  => $b['pickup'],
                    'return_location'  => $b['return'],
                    'daily_rate'       => $b['rate'],
                    'days'             => $b['days'],
                    'total_amount'     => $total,
                    'status'           => $b['status'],
                ]
            );
            $bookingIds[] = ['id' => $booking->id, 'customer_id' => $cId, 'amount' => $total, 'status' => $b['status']];
        }

        // ── Payments ──────────────────────────────────────────
        $paymentMethods = ['Mobile Money', 'Cash', 'Bank Transfer', 'Card'];
        foreach ($bookingIds as $i => $bk) {
            $isPaid    = in_array($bk['status'], ['completed', 'active']);
            $pStatus   = $isPaid ? 'paid' : 'pending';
            $paidAt    = $isPaid ? Carbon::now()->modify('-' . rand(1, 5) . ' days') : null;
            $ref       = 'PAY-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT);
            $method    = $paymentMethods[$i % count($paymentMethods)];

            Payment::updateOrCreate(
                ['payment_reference' => $ref],
                [
                    'booking_id'  => $bk['id'],
                    'customer_id' => $bk['customer_id'],
                    'amount'      => $bk['amount'],
                    'currency'    => 'UGX',
                    'method'      => $method,
                    'status'      => $pStatus,
                    'paid_at'     => $paidAt,
                ]
            );
        }

        // ── Maintenance ───────────────────────────────────────
        $maintenanceTasks = [
            ['vIdx'=>0,'task'=>'Full service & oil change',       'due'=>'+30 days','cost'=>350000,'priority'=>'medium','status'=>'scheduled'],
            ['vIdx'=>1,'task'=>'Tyre replacement (front pair)',   'due'=>'+7 days', 'cost'=>480000,'priority'=>'high',  'status'=>'scheduled'],
            ['vIdx'=>4,'task'=>'Brake pad replacement',           'due'=>'-2 days', 'cost'=>220000,'priority'=>'high',  'status'=>'in_progress'],
            ['vIdx'=>2,'task'=>'AC servicing & regas',            'due'=>'+14 days','cost'=>150000,'priority'=>'low',   'status'=>'scheduled'],
            ['vIdx'=>3,'task'=>'Windshield chip repair',          'due'=>'+5 days', 'cost'=>80000, 'priority'=>'low',   'status'=>'scheduled'],
            ['vIdx'=>6,'task'=>'Annual vehicle inspection',       'due'=>'+45 days','cost'=>120000,'priority'=>'medium','status'=>'scheduled'],
            ['vIdx'=>5,'task'=>'Engine oil & filter change',      'due'=>'-10 days','cost'=>95000, 'priority'=>'medium','status'=>'completed'],
            ['vIdx'=>7,'task'=>'Battery replacement',             'due'=>'+20 days','cost'=>180000,'priority'=>'medium','status'=>'scheduled'],
            ['vIdx'=>8,'task'=>'Suspension check & alignment',   'due'=>'+10 days','cost'=>200000,'priority'=>'high',  'status'=>'scheduled'],
            ['vIdx'=>9,'task'=>'Deep interior cleaning & valet', 'due'=>'+3 days', 'cost'=>60000, 'priority'=>'low',   'status'=>'scheduled'],
        ];

        foreach ($maintenanceTasks as $m) {
            Maintenance::create([
                'vehicle_id'     => $vehicleIds[$m['vIdx']],
                'task'           => $m['task'],
                'due_date'       => Carbon::now()->modify($m['due'])->toDateString(),
                'estimated_cost' => $m['cost'],
                'priority'       => $m['priority'],
                'status'         => $m['status'],
                'completed_at'   => $m['status'] === 'completed' ? Carbon::now()->modify('-1 day') : null,
            ]);
        }
    }
}
