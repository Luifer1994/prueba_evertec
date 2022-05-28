<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $documentTypes = [
            ["cod" => "CC", "name" => "Cédula de ciudadanía"],
            ["cod" => "NIT", "name" => "Número de Identificación Tributaria"],
            ["cod" => "CE", "name" => "Cédula de extranjería"],
            ["cod" => "TI", "name" => "Tarjeta de identidad"]

        ];

        foreach ($documentTypes as $item) {
            DB::table('document_types')->insert([
                "cod"   => $item["cod"],
                "name"  => $item["name"]
            ]);
        }

        User::factory(1)->create();
        Product::factory(10)->create();
    }
}
