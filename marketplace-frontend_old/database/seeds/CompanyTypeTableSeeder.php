<?php

use Illuminate\Database\Seeder;

class CompanyTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyTypes = [
          [
            'name' => 'Restaurants',
            'active' => 1,
          ],
          [
            'name' => 'Medical Stores',
            'active' => 1,
          ],
          [
            'name' => 'Grocery Stores',
            'active' => 1,
          ]
        ];

        foreach ($companyTypes as  $companyType) {
          $obj = new \App\CompanyType;
          $obj->name = $companyType['name'];
          $obj->active = $companyType['active'];
          $obj->save();
        }
    }
}
