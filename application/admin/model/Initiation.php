<?php
/**
 * Created by originThink
 * Author: 原点 467490186@qq.com
 * Date: 2017/5/5
 * Time: 13:46
 */

namespace app\admin\model;

use think\Model;

class Initiation extends Model
{
    protected $autoWriteTimestamp = true;
    protected $type = [
        'birthday' => 'timestamp',
    ];

    /**
     * 搜索器
     * @param $query
     * @param $value
     */
    public function searchNameAttr($query, $value)
    {
        if ($value) {
            $query->where('card_number|name', 'like', '%' . $value . '%');
        }
    }
}