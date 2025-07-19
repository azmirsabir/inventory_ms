<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
  {
    DB::table('countries')->insert([
      [
        'name' => 'Iraq',
        'code' => 'IRQ',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'name' => 'Turkey',
        'code' => 'TUR',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'name' => 'United States',
        'code' => 'USA',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
      [
        'name' => 'Germany',
        'code' => 'DEU',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ],
    ]);
  }
}
