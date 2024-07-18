<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Node\FunctionNode;

class UserController extends Controller
{
    public function index(){

        $users=User::all();
        return view('dashboard.users.index',compact('users'));
    }
}
