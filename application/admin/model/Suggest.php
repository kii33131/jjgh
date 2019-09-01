<?php
/**
 * Created by originThink
 * Author: 原点 467490186@qq.com
 * Date: 2017/5/5
 * Time: 13:46
 */

namespace app\admin\model;

use think\Model;

class Suggest extends Model
{
    protected $autoWriteTimestamp = true;

    /**
     * 搜索器
     * @param $query
     * @param $value
     */
    public function searchNameAttr($query, $value)
    {
        if ($value) {
            $query->where('phone|name', 'like', '%' . $value . '%');
        }
    }
}