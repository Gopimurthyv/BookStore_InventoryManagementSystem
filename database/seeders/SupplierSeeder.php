<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            ['name'=>'ABC Books Pvt Ltd', 'email'=>'abc@books.com','contact_number'=> '9087654321'],
            ['name'=>'XYZ Distributors', 'email'=>'xyz@books.com','contact_number'=> '8907654321']
        ];
        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
