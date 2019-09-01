<?php
/**
 * Created by originThink
 * Author: 原点 467490186@qq.com
 * Date: 2017/5/5
 * Time: 13:46
 */

namespace app\admin\model;

use think\Model;

class Activity extends Model
{
    protected $autoWriteTimestamp = true;
    protected $type = [
        'begin_time' => 'timestamp',
        'end_time' => 'timestamp',
    ];

    public function searchNameAttr($query, $value)
    {
        if ($value) {
            $query->where('name', 'like', '%' . $value . '%');
        }
    }

    public function getUserAttr($value, $data)
    {
        $user = User::where('uid', '=', $data['create_user'])
            ->column('name');
        return $user;
    }
}