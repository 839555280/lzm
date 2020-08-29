<?php
namespace App\Repositories;


use App\User;
use App\Models\UserIntegral;

class Users
{
    public static function getIntegral($user_id){
        $user = User::find($user_id);
        if($user->up_id){
            $up_user = User::find($user->up_id);
            UserIntegral::where(['user_id'=>$user->up_id])->update(['integral'=>$up_user->integral->integral+5]);
            $res = UserIntegral::where(['user_id'=>$user_id])->update(['integral'=>$user->integral->integral+10]);
        }else{
            $res = UserIntegral::where(['user_id'=>$user_id])->update(['integral'=>$user->integral->integral+10]);
        }
        return $res;
    }
} 