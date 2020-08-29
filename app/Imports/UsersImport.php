<?php

namespace App\Imports;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\User;
use App\Models\UserIntegral;

class UsersImport implements ToCollection,WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        // 此处应该有验证 以手机号验证用户是否存在 将已存在的用户放出数组 以提示框的形式告知前端导出人员哪些用户是已存在的
        // $res = User::insert($rows->toArray());
        foreach($rows->toArray() as $row){
            $data = [
                "code" => substr(md5(date('YmdHis').rand(1000,9999)),0,8),
                "phone" => $row['phone'],
                "name" => $row['name'],
                "up_id" => $row['up_id']
            ];
            $id = User::insertGetId($data);
            UserIntegral::insert(['user_id'=>$id]);
        }
    }
}