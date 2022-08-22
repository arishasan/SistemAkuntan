<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\SupplierModel;
use App\Models\UserModel;
use Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    
    public function __construct(){

    }

    public function showFormLogin(){
    	if(Auth::check()) {
    		return redirect()->route('landing-admin');
    	}
    	return view('admin.login');
    }

    public function login(Request $req){
    	$rules = [
    		'username' => 'required|string',
    		'password' => 'required|string'
    	];

    	$messages = [
    		'username.required' => 'Nama pengguna wajib diisi!',
    		'password.required' => 'Kata sandi wajib diisi!',
    	];

    	$validator = Validator::make($req->all(), $rules, $messages);

    	if($validator->fails()){
    		return redirect()->back()->withErrors($validator)->withInput($req->all());
    	}

    	$data = [
    		'username' => $req->input('username'),
    		'password' => $req->input('password')
    	];

        $fieldType = filter_var($req->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    	Auth::attempt(array($fieldType => $req->input('username'), 'password' => $req->input('password')));

    	if(Auth::check()){

            $user = User::find(Auth()->user()->id);
            $user->save();

    		return redirect()->route('landing-admin');

    	}else{
    		Session::flash('error', 'Nama pengguna atau kata sandi salah.');
    		return redirect()->route('login');
    	}
    }

    public function logout(){
    	Auth::logout();
    	return redirect()->route('login');
    }


}
