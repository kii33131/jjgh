<?php
namespace app\admin\model;

use think\Model;

class Member extends Model
{
    protected $autoWriteTimestamp = true;
    protected $name = 'member';

    /**
     * 搜索器
     * @param $query
     * @param $value
     */
    public function searchUsernameAttr($query, $value)
    {
        if ($value) {
            $query->where('nickname|username', 'like', '%' . $value . '%');
        }
    }
}