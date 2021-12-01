<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
  /**
  * Register any application services.
  *
  * @return void
  */
  public function register() {

    $this->commands(
      'App\Console\Commands\CrudCommand',
      'App\Console\Commands\CrudControllerCommand',
      'App\Console\Commands\CrudModelCommand',
      'App\Console\Commands\CrudMigrationCommand',
      'App\Console\Commands\CrudViewCommand',
      'App\Console\Commands\CrudLangCommand',
      'App\Console\Commands\CrudApiCommand',
      'App\Console\Commands\CrudApiControllerCommand'
    );

    // System
    require_once app_path() . '/Helpers/System/Default.php';
    require_once app_path() . '/Helpers/System/Dummy.php';
  }

  /**
  * Bootstrap any application services.
  *
  * @return void
  */
  public function boot()
  {
    Schema::defaultStringLength(191);
    config(['app.locale' => 'en']);
    Carbon::setLocale('en');
    date_default_timezone_set('Asia/Jakarta');

    $this->publishes([
      __DIR__ . '/../config/crudgenerator.php' => config_path('crudgenerator.php'),
    ]);

    $this->publishes([
      __DIR__ . '/../publish/views/' => base_path('resources/views/'),
    ]);

    $this->publishes([
      __DIR__ . '/stubs/' => base_path('resources/crud-generator/'),
    ]);
  }
}
