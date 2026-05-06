<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Service;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\ShipmentTracking;
use App\Models\ShippingRoute;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoEkspedisiSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('shipment_trackings')->truncate();
        DB::table('shipment_items')->truncate();
        DB::table('payments')->truncate();
        DB::table('shipments')->truncate();
        DB::table('vehicles')->truncate();
        DB::table('customers')->truncate();
        DB::table('users')->truncate();
        DB::table('routes')->truncate();
        DB::table('services')->truncate();
        DB::table('branches')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // ── BRANCHES ─────────────────────────────────────────────
        $branchData = [
            ['code'=>'JKT-01','name'=>'Cabang Jakarta Pusat',   'city'=>'Jakarta',   'phone'=>'021-5550001','email'=>'jakarta@ekspedisiku.id'],
            ['code'=>'BDG-01','name'=>'Cabang Bandung',          'city'=>'Bandung',   'phone'=>'022-5550002','email'=>'bandung@ekspedisiku.id'],
            ['code'=>'SBY-01','name'=>'Cabang Surabaya',         'city'=>'Surabaya',  'phone'=>'031-5550003','email'=>'surabaya@ekspedisiku.id'],
            ['code'=>'MDN-01','name'=>'Cabang Medan',            'city'=>'Medan',     'phone'=>'061-5550004','email'=>'medan@ekspedisiku.id'],
            ['code'=>'MKS-01','name'=>'Cabang Makassar',         'city'=>'Makassar',  'phone'=>'0411-550005','email'=>'makassar@ekspedisiku.id'],
        ];
        $branches = collect($branchData)->map(fn($d) => Branch::create($d + ['address'=>'Jl. Raya '.$d['city'].' No.1','is_active'=>true]));

        // ── SERVICES ─────────────────────────────────────────────
        $services = collect([
            ['name'=>'Reguler',    'description'=>'Pengiriman standar 3-7 hari kerja',         'price_multiplier'=>1.00],
            ['name'=>'Express',    'description'=>'Pengiriman cepat 1-2 hari kerja',            'price_multiplier'=>1.80],
            ['name'=>'Same Day',   'description'=>'Pengiriman hari yang sama (dalam kota)',      'price_multiplier'=>2.50],
            ['name'=>'Kargo',      'description'=>'Untuk barang berat dan volume besar',         'price_multiplier'=>0.85],
            ['name'=>'COD',        'description'=>'Bayar di tempat, jangkauan area tertentu',    'price_multiplier'=>1.20],
        ])->map(fn($d) => Service::create($d));

        // ── ROUTES ───────────────────────────────────────────────
        $routeData = [
            ['origin_city'=>'Jakarta','destination_city'=>'Bandung',   'price_per_kg'=>8000,  'estimated_days'=>1],
            ['origin_city'=>'Jakarta','destination_city'=>'Surabaya',  'price_per_kg'=>12000, 'estimated_days'=>2],
            ['origin_city'=>'Jakarta','destination_city'=>'Medan',     'price_per_kg'=>18000, 'estimated_days'=>3],
            ['origin_city'=>'Jakarta','destination_city'=>'Makassar',  'price_per_kg'=>20000, 'estimated_days'=>4],
            ['origin_city'=>'Jakarta','destination_city'=>'Yogyakarta','price_per_kg'=>10000, 'estimated_days'=>2],
            ['origin_city'=>'Bandung','destination_city'=>'Jakarta',   'price_per_kg'=>8000,  'estimated_days'=>1],
            ['origin_city'=>'Bandung','destination_city'=>'Surabaya',  'price_per_kg'=>13000, 'estimated_days'=>2],
            ['origin_city'=>'Surabaya','destination_city'=>'Jakarta',  'price_per_kg'=>12000, 'estimated_days'=>2],
            ['origin_city'=>'Surabaya','destination_city'=>'Bandung',  'price_per_kg'=>13000, 'estimated_days'=>2],
            ['origin_city'=>'Surabaya','destination_city'=>'Makassar', 'price_per_kg'=>15000, 'estimated_days'=>3],
            ['origin_city'=>'Medan','destination_city'=>'Jakarta',     'price_per_kg'=>18000, 'estimated_days'=>3],
            ['origin_city'=>'Makassar','destination_city'=>'Jakarta',  'price_per_kg'=>20000, 'estimated_days'=>4],
            ['origin_city'=>'Makassar','destination_city'=>'Surabaya', 'price_per_kg'=>15000, 'estimated_days'=>3],
        ];
        $routes = collect($routeData)->map(fn($d) => ShippingRoute::create($d));

        // ── VEHICLES ─────────────────────────────────────────────
        $vehicleData = [
            ['branch_id'=>$branches[0]->id,'plate_number'=>'B 9012 XYZ','brand'=>'Isuzu',     'type'=>'truck',      'capacity_kg'=>5000,'driver_name'=>'Rudi Santoso',    'status'=>'available'],
            ['branch_id'=>$branches[0]->id,'plate_number'=>'B 7788 ABC','brand'=>'Mitsubishi','type'=>'van',        'capacity_kg'=>2000,'driver_name'=>'Andi Pratama',     'status'=>'in_use'],
            ['branch_id'=>$branches[1]->id,'plate_number'=>'D 4455 QWE','brand'=>'Toyota',    'type'=>'van',        'capacity_kg'=>1500,'driver_name'=>'Budi Hartono',     'status'=>'available'],
            ['branch_id'=>$branches[2]->id,'plate_number'=>'L 1234 DEF','brand'=>'Honda',     'type'=>'motorcycle', 'capacity_kg'=>50,  'driver_name'=>'Slamet Raharjo',   'status'=>'available'],
            ['branch_id'=>$branches[2]->id,'plate_number'=>'L 5678 GHI','brand'=>'Isuzu',     'type'=>'truck',      'capacity_kg'=>8000,'driver_name'=>'Dwi Kurniawan',    'status'=>'maintenance'],
            ['branch_id'=>$branches[3]->id,'plate_number'=>'BK 9901 JKL','brand'=>'Mitsubishi','type'=>'van',       'capacity_kg'=>2000,'driver_name'=>'Fajar Nugroho',    'status'=>'available'],
        ];
        $vehicles = collect($vehicleData)->map(fn($d) => Vehicle::create($d));

        // ── USERS ────────────────────────────────────────────────
        $admin = User::create([
            'name'=>'Admin EkspedisiKu','email'=>'admin@ekspedisiku.id','phone'=>'081200000001',
            'branch_id'=>$branches[0]->id,'role'=>'admin','is_active'=>true,'password'=>'password',
        ]);
        $manager = User::create([
            'name'=>'Budi Manager','email'=>'manager@ekspedisiku.id','phone'=>'081200000002',
            'branch_id'=>$branches[0]->id,'role'=>'manager','is_active'=>true,'password'=>'password',
        ]);
        $branchAdmins = collect([
            ['name'=>'Siti Branch Jakarta', 'email'=>'branch.jkt@ekspedisiku.id', 'branch_id'=>$branches[0]->id],
            ['name'=>'Ahmad Branch Bandung', 'email'=>'branch.bdg@ekspedisiku.id','branch_id'=>$branches[1]->id],
            ['name'=>'Dewi Branch Surabaya', 'email'=>'branch.sby@ekspedisiku.id','branch_id'=>$branches[2]->id],
        ])->map(fn($d) => User::create($d + ['phone'=>'0812'.rand(10000000,99999999),'role'=>'branch_admin','is_active'=>true,'password'=>'password']));

        $couriers = collect([
            ['name'=>'Kurir Andi',   'email'=>'kurir1@ekspedisiku.id','branch_id'=>$branches[0]->id],
            ['name'=>'Kurir Beni',   'email'=>'kurir2@ekspedisiku.id','branch_id'=>$branches[1]->id],
            ['name'=>'Kurir Candra', 'email'=>'kurir3@ekspedisiku.id','branch_id'=>$branches[2]->id],
        ])->map(fn($d) => User::create($d + ['phone'=>'0813'.rand(10000000,99999999),'role'=>'courier','is_active'=>true,'password'=>'password']));

        // ── CUSTOMERS ────────────────────────────────────────────
        $customerData = [
            ['name'=>'Toko Sinar Jaya',   'email'=>'sinar.jaya@gmail.com',    'phone'=>'08111111111','city'=>'Jakarta',  'address'=>'Jl. Sudirman No.10, Jakarta'],
            ['name'=>'PT Maju Lancar',    'email'=>'maju.lancar@gmail.com',   'phone'=>'08222222222','city'=>'Bandung',  'address'=>'Jl. Dago No.5, Bandung'],
            ['name'=>'CV Prima Abadi',    'email'=>'prima.abadi@gmail.com',   'phone'=>'08333333333','city'=>'Surabaya', 'address'=>'Jl. Pemuda No.20, Surabaya'],
            ['name'=>'Bu Ani Florist',    'email'=>'ani.florist@gmail.com',   'phone'=>'08444444444','city'=>'Yogyakarta','address'=>'Jl. Malioboro No.45, Yogyakarta'],
            ['name'=>'Pak Budi Online',   'email'=>'budi.online@gmail.com',   'phone'=>'08555555555','city'=>'Jakarta',  'address'=>'Jl. Kebon Jeruk No.3, Jakarta'],
            ['name'=>'Toko Elektronik Maju','email'=>'elektronik.maju@gmail.com','phone'=>'08666666666','city'=>'Medan', 'address'=>'Jl. Gatot Subroto No.77, Medan'],
        ];
        $customers = collect($customerData)->map(fn($d) => Customer::create($d + ['password'=>'password']));

        // ── SHIPMENTS ────────────────────────────────────────────
        $shipmentDefs = [
            // (sender_idx, receiver_idx, route_idx, service_idx, vehicle_idx, courier_idx, status, payment_status, days_ago)
            [0, 1, 0, 0, 0, 0, 'delivered',      'paid',    7],
            [1, 2, 6, 1, 2, 1, 'delivered',      'paid',    5],
            [2, 0, 7, 0, 3, 2, 'in_transit',     'partial', 3],
            [3, 4, 4, 2, 1, 0, 'out_for_delivery','unpaid', 1],
            [4, 0, 0, 4, 0, 0, 'picked_up',      'unpaid',  2],
            [0, 3, 1, 3, 0, 2, 'pending',        'unpaid',  0],
            [5, 1, 3, 1, 5, null,'delivered',    'paid',    10],
            [1, 5, 2, 0, 2, 1, 'arrived_at_branch','partial',4],
        ];

        $statusFlow = [
            'pending'           => ['pending'],
            'picked_up'         => ['pending','picked_up'],
            'in_transit'        => ['pending','picked_up','in_transit'],
            'arrived_at_branch' => ['pending','picked_up','in_transit','arrived_at_branch'],
            'out_for_delivery'  => ['pending','picked_up','in_transit','arrived_at_branch','out_for_delivery'],
            'delivered'         => ['pending','picked_up','in_transit','arrived_at_branch','out_for_delivery','delivered'],
            'cancelled'         => ['pending','cancelled'],
        ];

        foreach ($shipmentDefs as $idx => $def) {
            [$si, $ri, $rti, $svi, $vi, $ci, $status, $pstatus, $dAgo] = $def;
            $route   = $routes[$rti];
            $service = $services[$svi];
            $weight  = round(rand(10, 200) / 10, 1); // 1.0 - 20.0 kg
            $price   = $route->price_per_kg * $weight * $service->price_multiplier;
            $created = Carbon::now()->subDays($dAgo)->subHours(rand(1,10));

            $shipment = Shipment::create([
                'tracking_number'        => 'EKS-' . strtoupper(substr(md5($idx . microtime()), 0, 10)),
                'sender_id'              => $customers[$si]->id,
                'receiver_id'            => $customers[$ri]->id,
                'origin_branch_id'       => $branches[$si % $branches->count()]->id,
                'destination_branch_id'  => $branches[$ri % $branches->count()]->id,
                'vehicle_id'             => $vehicles[$vi]->id,
                'courier_id'             => $ci !== null ? $couriers[$ci]->id : null,
                'service_id'             => $service->id,
                'created_by'             => $admin->id,
                'route_id'               => $route->id,
                'origin_city'            => $route->origin_city,
                'destination_city'       => $route->destination_city,
                'sender_address'         => $customers[$si]->address,
                'receiver_address'       => $customers[$ri]->address,
                'description'            => 'Paket elektronik dan perlengkapan rumah tangga',
                'total_weight'           => $weight,
                'total_price'            => round($price),
                'status'                 => $status,
                'payment_status'         => $pstatus,
                'shipment_date'          => $created->toDateString(),
                'estimated_delivery_date'=> $created->copy()->addDays($route->estimated_days)->toDateString(),
                'delivered_at'           => $status === 'delivered' ? $created->copy()->addDays($route->estimated_days) : null,
                'notes'                  => 'Harap ditangani dengan hati-hati.',
                'created_at'             => $created,
                'updated_at'             => $created,
            ]);

            // Items
            ShipmentItem::create([
                'shipment_id' => $shipment->id,
                'item_name'   => 'Barang Paket '.($idx+1),
                'description' => 'Deskripsi barang pengiriman',
                'quantity'    => rand(1, 5),
                'weight'      => $weight,
            ]);

            // Tracking history
            $flow = $statusFlow[$status] ?? ['pending'];
            foreach ($flow as $fIdx => $fStatus) {
                ShipmentTracking::create([
                    'shipment_id' => $shipment->id,
                    'recorded_by' => $admin->id,
                    'status'      => $fStatus,
                    'location'    => $fStatus === 'pending' ? $route->origin_city : $route->destination_city,
                    'description' => match($fStatus) {
                        'pending'           => 'Paket telah diterima di cabang '.$route->origin_city,
                        'picked_up'         => 'Paket diambil oleh kurir',
                        'in_transit'        => 'Paket dalam perjalanan ke '.$route->destination_city,
                        'arrived_at_branch' => 'Paket tiba di cabang '.$route->destination_city,
                        'out_for_delivery'  => 'Paket sedang diantar ke alamat penerima',
                        'delivered'         => 'Paket berhasil diterima oleh penerima',
                        'cancelled'         => 'Pengiriman dibatalkan',
                    },
                    'checked_at'  => $created->copy()->addHours($fIdx * 8),
                    'created_at'  => $created->copy()->addHours($fIdx * 8),
                    'updated_at'  => $created->copy()->addHours($fIdx * 8),
                ]);
            }

            // Payment
            if ($pstatus !== 'unpaid') {
                $amount = $pstatus === 'paid' ? $shipment->total_price : $shipment->total_price * 0.5;
                Payment::create([
                    'shipment_id'    => $shipment->id,
                    'received_by'    => $admin->id,
                    'payment_number' => 'PAY-'.strtoupper(substr(md5($idx.rand()), 0, 8)),
                    'amount'         => $amount,
                    'payment_method' => ['cash','bank_transfer','e_wallet'][$idx % 3],
                    'payment_status' => 'paid',
                    'payment_date'   => $created->toDateString(),
                    'notes'          => 'Pembayaran untuk '.$shipment->tracking_number,
                    'created_at'     => $created,
                    'updated_at'     => $created,
                ]);
            }
        }

        $this->command->info('✅ Demo data berhasil di-seed!');
        $this->command->info('👤 Admin:        admin@ekspedisiku.id / password');
        $this->command->info('👤 Manager:      manager@ekspedisiku.id / password');
        $this->command->info('👤 Branch Admin: branch.jkt@ekspedisiku.id / password');
        $this->command->info('👤 Courier:      kurir1@ekspedisiku.id / password');
        $this->command->info('👤 Customer:     sinar.jaya@gmail.com / password');
    }
}
