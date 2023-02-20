<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    if (config("admin.admin_email") && config("admin.admin_password")) {
      User::firstOrCreate(
        [
          "name" => "Admin",
          "email" => config("admin.admin_email"),
          "permission_level" => 3,
        ],
        ["password" => Hash::make(config("admin.admin_password"))]
      );
    }
  }
}
