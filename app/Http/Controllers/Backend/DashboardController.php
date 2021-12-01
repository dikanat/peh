<?php

namespace App\Http\Controllers\Backend;

use Auth;
use DataTables;
use Redirect,Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\TestEvent;

use App\User;

class DashboardController extends Controller {

  /**
  **************************************************
  * @return Authentication
  * @return Auto-Configurations
  **************************************************
  **/

  public function __construct() {
    $this->middleware(['auth']);
    $this->url = '/dashboard';
    $this->path = 'pages.backend.system';
    $this->model = 'App\User';
  }

  /**
  **************************************************
  * @return Index
  **************************************************
  **/

  public function index(Request $request) {
    return view($this->path . '.dashboard.index');
  }

  public function filemanager() {
    return view($this->path . '.file-manager.index');
  }

  public function help_center() {
    return view($this->path . '.help-center.index');
  }

  /**
  **************************************************
  * @return Logout
  **************************************************
  **/

  public function logout() {
    Auth::logout();
    return redirect('login');
  }

}
