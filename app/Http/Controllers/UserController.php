<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use Hash;
use File;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\HelperModel;
use App\Models\UserModel;
use App\Models\AksesModel;

class UserController extends Controller
{
    public function __construct(){

    }
    
    public function index(){
        // $cekAkses = HelperModel::allowedAccess('Master');

        // if($cekAkses == false){
        //     return view('admin.parts.404');
        // }

        $data = [
            'data_user' => Auth()->user()->level == 'ADMIN' ? UserModel::where('level', 'ADMIN')->get() : UserModel::all()
        ];
        return view('admin.system.user.index')->with($data);
    }

    public function edit($id){

        $data = [
            'data_user' => UserModel::where(DB::raw('md5(id)'), $id)->first(),
        ];
        return view('admin.system.user.edit')->with($data);
    }

    public function myacc(){

        $data = [
            'data_user' => Auth()->user(),
        ];
        return view('admin.system.user.akun_saya')->with($data);
    }

    public function myacc_update(Request $req){

        try {
            
            $data = UserModel::find($req->id);

            if($data){

                $rules = [
                ];
                $messages = [
                ];

                if($data->username != $req->username){
                    $rules['username'] = 'required|unique:tb_user,username';
                    $messages['username.unique'] = 'Username sudah digunakan!';
                }

                if($req->password == null || $req->password == ""){}else{
                    $rules['password'] = 'required|min:6|confirmed';
                    $rules['password_confirmation'] = 'required|min:6';
                }

                $validator = Validator::make($req->all(), $rules, $messages);

                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput($req->all());
                }
                
                $user = $data;
                $user->nama = $req->nama;
                $user->username = $req->username;
                $user->level = $req->level;
                
                if($req->password == null || $req->password == ""){}else{
                    $user->password = Hash::make($req->password);
                }

                if($user->save()){
                    Session::flash('success', 'Berhasil mengubah data user!');
                    return redirect()->back();
                }else{
                    Session::flash('error', 'Gagal mengubah data user!');
                    return redirect()->back();
                }
            }else{
                Session::flash('error', 'Data user tidak ditemukan!');
                return redirect()->route('landing-admin');
            }

        } catch (Exception $e) {
            Session::flash('error', 'Data user tidak ditemukan!');
            return redirect()->route('landing-admin');
        }

    }

    public function store(Request $req){

        $rules = [
            'username' => 'required|unique:tb_user,username',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ];

        $messages = [
            'username.unique' => 'Username sudah digunakan!',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }

        $user = new UserModel;
        $user->nama = $req->nama;
        $user->username = $req->username;
        $user->password = Hash::make($req->password);
        $user->level = $req->level;

        if($user->save()){
            Session::flash('success', 'Berhasil menambahkan data user baru!');
            return redirect()->route('users');
        }else{
            Session::flash('error', 'Gagal menambahkan data user baru!');
            return redirect()->route('users');
        }

    }

    public function update(Request $req){

        try {
            
            $data = UserModel::find($req->id);

            if($data){

                $rules = [
                ];
                $messages = [
                ];

                if($data->username != $req->username){
                    $rules['username'] = 'required|unique:tb_user,username';
                    $messages['username.unique'] = 'Username sudah digunakan!';
                }

                if($req->password == null || $req->password == ""){}else{
                    $rules['password'] = 'required|min:6|confirmed';
                    $rules['password_confirmation'] = 'required|min:6';
                }

                $validator = Validator::make($req->all(), $rules, $messages);

                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput($req->all());
                }
                
                $user = $data;
                $user->nama = $req->nama;
                $user->username = $req->username;
                $user->level = $req->level;
                
                if($req->password == null || $req->password == ""){}else{
                    $user->password = Hash::make($req->password);
                }

                if($user->save()){
                    Session::flash('success', 'Berhasil mengubah data user!');
                    return redirect()->back();
                }else{
                    Session::flash('error', 'Gagal mengubah data user!');
                    return redirect()->back();
                }
            }else{
                Session::flash('error', 'Data user tidak ditemukan!');
                return redirect()->route('users');
            }

        } catch (Exception $e) {
            Session::flash('error', 'Data user tidak ditemukan!');
            return redirect()->route('users');
        }

    }

    public function delete($id){

        if(md5(Auth()->user()->id) == $id){
            Session::flash('error', 'User sedang digunakan! tidak dapat dihapus.');
        }else{

            $user = UserModel::where(DB::raw('md5(id)'), $id);
            if($user->count() > 0){

                if($user->delete()){
                    Session::flash('success', 'Berhasil menghapus data user!');
                }else{
                    Session::flash('error', 'Gagal menghapus data user!');
                }


            }else{
                Session::flash('error', 'Gagal menghapus data user!');
            }
        }
        
    }

}
