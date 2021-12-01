<?php

namespace App\Http\Controllers\Api\Dummy\Table;

use Auth;
use DataTables;
use Redirect,Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

use App\Http\Requests\Backend\System\Dummy\Table\General\StoreRequest;
use App\Http\Requests\Backend\System\Dummy\Table\General\UpdateRequest;

class GeneralController extends Controller {

  /**
  **************************************************
  * @return Authentication
  * @return Auto-Configurations
  **************************************************
  **/

  public function __construct() {


    $this->url = '/dashboard/dummy/table/generals';
    $this->path = 'pages.backend.system.dummy.table.general';
    $this->model = 'App\Models\Backend\System\Dummy\Table\General';

    if (request('date_start') && request('date_end')) { $this->data = $this->model::orderby('date_start', 'desc')->whereBetween('date_start', [request('date_start'), request('date_end')])->get(); }
    else { $this->data = $this->model::orderby('date_start', 'desc')->get(); }

  }

  public function index() {
    $model = $this->model::all();
    return response()->json($model);
  }


}
