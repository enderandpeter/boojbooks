<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	if(Auth::check()){
    		return view('dashboard');
    	} else {
    		return view('welcome');
    	}
    }
    
    /**
     * Show the welcome message
     * 
     * @return \Illuminate\Http\Response
     */
    public function welcome(){
    	return view('welcome');
    }
}
