<?php
namespace App\Repositories;


use App\User;
use App\Models\UserIntegral;
use App\Models\Setting;

class Users
{
    public static function getIntegral($user_id){
        $user = User::find($user_id);
        $set = Setting::find(1);
        // print_r($set->up_user_integral);die;
        if($user->up_id){
            $up_user = User::find($user->up_id);
            UserIntegral::where(['user_id'=>$user->up_id])->update(['integral'=>$up_user->integral->integral+$set->up_user_integral]);
            $res = UserIntegral::where(['user_id'=>$user_id])->update(['integral'=>$user->integral->integral+$set->user_integral]);
        }else{
            $res = UserIntegral::where(['user_id'=>$user_id])->update(['integral'=>$user->integral->integral+$set->user_integral]);
        }
        return $res;
    }
} 