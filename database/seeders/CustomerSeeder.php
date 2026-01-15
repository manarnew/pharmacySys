<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Walk-in Customer',
                'phone' => '0000000000',
                'age' => null,
            ],
            [
                'name' => 'John Doe',
                'phone' => '0123456789',
                'age' => 30,
            ],
            [
                'name' => 'Jane Smith',
                'phone' => '0987654321',
                'age' => 25,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
