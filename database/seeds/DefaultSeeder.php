<?php

use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder {
  public function run() {

    // Default
    $this->call(Roles::class);

  }
}
