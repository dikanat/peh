<?php

namespace App\Http\Controllers\Backend;

use Auth;
use DataTables;
use Redirect,Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\User;

class ProfileController extends Controller {

  /**
  **************************************************
  * @return Authentication
  * @return Auto-Configurations
  **************************************************
  **/

  public function __construct() {
    $this->middleware(['auth']);
    $this->url = '/dashboard/profile';
    $this->path = 'pages.backend.system.profile';
    $this->model = 'App\User';
  }

  /**
  **************************************************
  * @return Index
  **************************************************
  **/

  public function index() {
    return redirect($this->url . '/account-information');
  }

  public function update(Request $request, $id) {
    $data = $this->model::findOrFail($id);
    $update = $request->all();
    $data->update($update);
    return redirect($this->url . '/account-information')->with('success', trans('default.notification.success.profile-updated'));
  }

  public function account_information(Request $request) {
    $data = User::where('username', Auth::User()->username)->first();
    return view($this->path . '.index', compact('data'));
  }

  public function change_password(Request $request) {
    $data = User::where('username', Auth::User()->username)->first();
    return view($this->path . '.change-password', compact('data'));
  }

  public function update_password(Request $request){

    if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
      return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
    }

    if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
      return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
    }

    if(!(strcmp($request->get('new-password'), $request->get('new-password-confirm'))) == 0){
      return redirect()->back()->with("error", "New Password should be same as your confirmed password. Please retype new password.");
    }

    $user = Auth::user();
    $user->password = bcrypt($request->get('new-password'));
    $user->save();

    return redirect()->back()->with('success', trans('default.notification.success.password-changed'));

  }

}
