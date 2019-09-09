<?php
/**
 * Created by originThink
 * Author: 原点 467490186@qq.com
 * Date: 2017/5/5
 * Time: 13:46
 */

namespace app\admin\model;

use think\Model;

class Banner extends Model
{
    protected $autoWriteTimestamp = true;
    protected $name = 'banner';

    public function searchTitleAttr($query, $value, $data)
    {
        $query->where('title','like',  '%' . $value . '%');
    }
}