<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiTestController extends Controller
{
    public function index(){

        $users = Http::get('https://gorest.co.in/public/v1/users');

        return view('api-users', compact('users'));

    }

}
