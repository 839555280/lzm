<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\UserIntegral;
use App\Models\Setting;
use App\Imports\UsersImport;
use App\Repositories\Users;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends Controller
{
    protected $user_list = [];

    public function index(){
        return view('index.index');
    }
    
    public function import(Request $request){
        $file = $request->file('file');
        // print_r($file);die;
        if (!$file) {
            error('上传文件不能为空');
            return view('index.index');

        }
        try {
            Excel::import(new UsersImport(), $file);
            return view('index.login');
        }catch (\Throwable $th) {
            error($th->getMessage());
            return view('index.index');
        }
    }

    public function login(Request $request){
        return view('index.login');
    }

    public function user(Request $request){
        $user = User::where('phone',$request->input('phone'))->first();
        return view('index.user',compact('user'));
    }

    public function register(Request $request){
        
        $user_id = $request->input('user_id',0);
        return view('index.register',compact('user_id'));
    }

    public function createUser(Request $request){
        $is_find = User::where(['phone'=>$request->input("phone")])->first();

        if($is_find){
            error('用户已存在');
            return ;
        }
        if($request->input('user_id')){
            $data = [
                'phone' => $request->input("phone"),
                'name' => $request->input("name"),
                'code' => substr(md5(date('YmdHis').rand(1000,9999)),0,8),
                'up_id' =>$request->input('user_id')
            ];
            $id = user::insertGetId($data);
            UserIntegral::insert(['user_id'=>$id]);
            Users::getIntegral($request->input('user_id'));
        }else{
            $data = [
                'phone' => $request->input("phone"),
                'name' => $request->input("name"),
                'code' => substr(md5(date('YmdHis').rand(1000,9999)),0,8),
                'up_id' =>$request->input('user_id')
            ];
            $id = user::insertGetId($data);
            UserIntegral::insert(['user_id'=>$id]);
        }
        return view('index.login');
    }

    public function info($id){

        $user = User::where(['up_id'=>$id])->get()->toArray();

        foreach ($user as $key=>$value){
            $this->user_list = array_merge($this->user_list,[$value]);
            $user = User::where(['up_id'=>$value['id']])->get()->toArray();
            if($user){
                $this->info($value['id']);
            }
        }
        
        $users_list = $this->user_list;

        return view('index.info',compact('users_list'));
    }


    public function setting(){
        return view('index.setting');
    }

    public function set(Request $request){
        $res = Setting::insert([
            "user_integral" => $request->input('user_integral'),
            "up_user_integral" => $request->input('up_user_integral')
        ]);
        if($res){
            error('设置成功');
        }else{
            error('设置出错，请重试');
            return back();
        }
    }
}
