<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $user = User::create([
      'name'  => 'Simon Tampubolon',
      'email' => 'simon@gmail.com',
      'email_verified_at' => now(),
      'password' => bcrypt('12345678'),
      'username' => 'simon',
    ]);
  }
}

//'password' => bcrypt('12345678'),
