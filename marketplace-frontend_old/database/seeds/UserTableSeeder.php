<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $users = [
        [
          'name' => 'Admin',
          'email' => 'admin@abboda.com',
          'password' => '12345678',
          'phone' => '1234567890',
          'user_type' => '2',
        ],
        [
          'name' => 'Super User',
          'email' => 'worksh707@gmail.com',
          'password' => '12345678',
          'phone' => '1234567890',
          'user_type' => '1',
        ],
      ];
        
        foreach ($users as $user) {
                $userObj = new \App\User;
                $userObj->name = $user['name'];
                $userObj->email = $user['email'];
                $userObj->password = Hash::make($user['password']);
                $userObj->phone = $user['phone'];
                $userObj->user_type = $user['user_type'];
                $userObj->save();
                }
    }
}
