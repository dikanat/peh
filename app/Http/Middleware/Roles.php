<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Auth;
use Closure;
use App\Role;

class Roles {
  public function handle($request, Closure $next, ... $roles)
  {
    if (!Auth::check())
    return redirect('login');

    $user = Auth::user();

    if($user->roles->name == 'administrator')
    return $next($request);

    foreach($roles as $role) {
      // Check if user has the role This check will depend on how your roles are set up
      if($user->roles->name == $role)
      return $next($request);
    }

    return redirect('login');
  }
}
