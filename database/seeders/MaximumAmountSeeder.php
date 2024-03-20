<?php

namespace Database\Seeders;

use App\Models\Benefit;
use App\Models\MaximumAmount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaximumAmountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $benefits = Benefit::pluck('id')->all();

        foreach( $benefits as $benefit ) {
            MaximumAmount::factory()->create([
                'id_beneficio' => $benefit
            ]);
        }
    }
}
