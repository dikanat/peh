<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon as Carbon;
use App\Role;

class Roles extends Seeder {
  public function run() {
    $data = [
      [
        'name'          => 'Administrator',
        'created_at'    => Carbon::now(),
      ],
      [
        'name'          => 'Member',
        'created_at'    => Carbon::now(),
      ],
      [
        'name'          => 'User',
        'created_at'    => Carbon::now(),
      ],
    ];

    Role::insert($data);
  }
}
