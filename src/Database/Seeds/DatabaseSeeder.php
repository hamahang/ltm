<?php
namespace Hamahang\LTM\Database\Seeds ;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CityTableSeeder::class);
        $this->call(IrCitiesTableSeeder::class);
        $this->call(IrProvincesTableSeeder::class);
        $this->call(ProvinceTableSeeder::class);
    }
}
