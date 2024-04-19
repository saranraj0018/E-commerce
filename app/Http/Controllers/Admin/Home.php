<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Home extends Controller
{
    public function index()
    {
       $admin = Auth::guard('admin')->user();
        echo 'welcome '.$admin->name.' <a href="'.route('admin.logout').'">Logout</a>';
    }


    public function logout(): \Illuminate\Http\RedirectResponse
    {
      Auth::guard('admin')->logout();
      return redirect()->route('admin.login');
    }
}
