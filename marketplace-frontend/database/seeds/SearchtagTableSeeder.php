<?php

use Illuminate\Database\Seeder;

class SearchtagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
              $searchtags = [
          [
            'name' => 'pizza',
            'active' => 1,
          ],
          [
            'name' => 'grocery',
            'active' => 1,
          ],
          [
            'name' => 'dominos',
            'active' => 1,
          ],
          [
            'name' => 'Red Wine',
            'active' => 1,
          ],
          [
            'name' => 'Mcdonalds',
            'active' => 1,
          ],
          [
            'name' => 'Restaurant',
            'active' => 1,
          ],
          [
            'name' => 'Restaurants',
            'active' => 1,
          ],
        ];

        foreach ($searchtags as  $searchtag) {
          $obj = new \App\Searchtag;
          $obj->name = $searchtag['name'];
          $obj->active = $searchtag['active'];
          $obj->save();
        }
    }
}
