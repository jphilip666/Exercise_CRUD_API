<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\SupplierRate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // user
        User::factory()->create([
            'first_name' => 'Jestin',
            'last_name' => 'Philip',
            'email' => 'jestin.philip@icloud.com',
            'password' => Hash::make('letmein'),
        ]);

        // supplier
        Supplier::factory()->create([
            'name' => 'Test Supplier 1 Name',
            'address' => 'Test Supplier 1 Address',
            'user_id' => 1,
        ]);

        Supplier::factory()->create([
            'name' => 'Test Supplier 2 Name',
            'address' => 'Test Supplier 2 Address',
            'user_id' => 1,
        ]);

        Supplier::factory()->create([
            'name' => 'Test Supplier 3 Name',
            'address' => 'Test Supplier 3 Address',
            'user_id' => 1,
        ]);

        // supplier rate
        SupplierRate::factory()->create([
            'supplier_id' => 1,
            'currency' => 10,
            'rate_start_date' => '2015-01-01',
            'rate_end_date' => '2015-03-31',
            'user_id' => 1,
        ]);

        SupplierRate::factory()->create([
            'supplier_id' => 1,
            'currency' => 20,
            'rate_start_date' => '2015-04-01',
            'rate_end_date' => '2015-05-01',
            'user_id' => 1,
        ]);

        SupplierRate::factory()->create([
            'supplier_id' => 1,
            'currency' => 10,
            'rate_start_date' => '2015-05-30',
            'rate_end_date' => '2015-07-25',
            'user_id' => 1,
        ]);

        SupplierRate::factory()->create([
            'supplier_id' => 1,
            'currency' => 25,
            'rate_start_date' => '2015-10-01',
            'rate_end_date' => null,
            'user_id' => 1,
        ]);

        SupplierRate::factory()->create([
            'supplier_id' => 2,
            'currency' => 100,
            'rate_start_date' => '2016-11-01',
            'rate_end_date' => null,
            'user_id' => 1,
        ]);

        SupplierRate::factory()->create([
            'supplier_id' => 3,
            'currency' => 30,
            'rate_start_date' => '2016-12-01',
            'rate_end_date' => '2017-01-01',
            'user_id' => 1,
        ]);

        SupplierRate::factory()->create([
            'supplier_id' => 3,
            'currency' => 30,
            'rate_start_date' => '2017-01-02',
            'rate_end_date' => null,
            'user_id' => 1,
        ]);
    }
}
