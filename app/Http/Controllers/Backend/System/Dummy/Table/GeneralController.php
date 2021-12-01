<?php

namespace App\Http\Controllers\Backend\System\Dummy\Table;

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

    $this->middleware('auth');
    $this->url = '/dashboard/dummy/table/generals';
    $this->path = 'pages.backend.system.dummy.table.general';
    $this->model = 'App\Models\Backend\System\Dummy\Table\General';

    if (request('date_start') && request('date_end')) { $this->data = $this->model::orderby('date_start', 'desc')->whereBetween('date_start', [request('date_start'), request('date_end')])->get(); }
    else { $this->data = $this->model::orderby('date_start', 'desc')->get(); }

  }

  /**
  **************************************************
  * @return Index
  **************************************************
  **/

  public function index() {
    $model = $this->model;
    if(request()->ajax()) {
      return DataTables::of($this->data)
      ->editColumn('date_start', function($order) { return \Carbon\Carbon::parse($order->date_start)->format('d F Y, H:i'); })
      ->editColumn('date_end', function($order) { return \Carbon\Carbon::parse($order->date_end)->format('d F Y, H:i'); })
      ->rawColumns(['description'])
      ->addIndexColumn()
      ->make(true);
    }
    return view($this->path . '.index', compact('model'));
  }

  /**
  **************************************************
  * @return Show
  **************************************************
  **/

  public function show($id) {
    $model = $this->model;
    $data = $this->model::findOrFail($id);
    return view($this->path . '.show', compact('data', 'model'));
  }

  /**
  **************************************************
  * @return Create
  **************************************************
  **/

  public function create() {
    $path = $this->path;
    $model = $this->model;
    return view($this->path . '.create', compact('path', 'model'));
  }

  /**
  **************************************************
  * @return Store
  **************************************************
  **/

  public function store(StoreRequest $request) {
    $store = $request->all();
    $this->model::create($store);
    return redirect($this->url)->with('success', trans('default.notification.success.item-created'));
  }

  /**
  **************************************************
  * @return Edit
  **************************************************
  **/

  public function edit($id) {
    $path = $this->path;
    $model = $this->model;
    $data = $this->model::findOrFail($id);
    return view($this->path . '.edit', compact('path', 'data', 'model'));
  }

  /**
  **************************************************
  * @return Update
  **************************************************
  **/

  public function update(UpdateRequest $request, $id) {
    $data = $this->model::findOrFail($id);
    $update = $request->all();
    $data->update($update);
    return redirect($this->url)->with('success', trans('default.notification.success.item-updated'));
  }

  /**
  **************************************************
  * @return Destroy
  **************************************************
  **/

  public function destroy($id) {
    try {
      $this->model::destroy($id);
      return redirect($this->url)->with('success', trans('default.notification.success.item-deleted'));
    } catch (\Exception $e) {
      return redirect($this->url)->with('error', trans('default.notification.error'));
    }
  }

  /**
  **************************************************
  * @return Enable
  * @return Disable
  * @return Status-Done
  * @return Status-Pending
  **************************************************
  **/

  public function enable($id) {
    $data = $this->model::where('id', $id)->update([ 'active' => 1 ]);
    return Response::json($data);
  }

  public function disable($id) {
    $data = $this->model::where('id', $id)->update([ 'active' => 2 ]);
    return Response::json($data);
  }

  public function status_done($id) {
    $data = $this->model::where('id', $id)->update([ 'status' => 1 ]);
    return Response::json($data);
  }

  public function status_pending($id) {
    $data = $this->model::where('id', $id)->update([ 'status' => 2 ]);
    return Response::json($data);
  }

  /**
  **************************************************
  * @return Delete
  **************************************************
  **/

  public function delete($id) {
    $this->model::destroy($id);
    $data = $this->model::where('id',$id)->delete();
    return Response::json($data);
  }

  /**
  **************************************************
  * @return Delete-All
  **************************************************
  **/

  public function deleteall(Request $request) {
    $exilednoname = $request->EXILEDNONAME;
    $this->model::whereIn('id',explode(",",$exilednoname))->delete();
    return Response::json($exilednoname);
  }

}
