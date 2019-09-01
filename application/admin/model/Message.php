<?php
/**
 * Created by originThink
 * Author: 原点 467490186@qq.com
 * Date: 2017/5/5
 * Time: 13:46
 */

namespace app\admin\model;

use think\Model;

class Message extends Model
{
    protected $autoWriteTimestamp = true;
    protected $name = 'message';
    /**
     * 搜索器
     * @param $query
     * @param $value
     */
    public function searchTitleAttr($query, $value)
    {
        if ($value) {
            $query->where('title', 'like', '%' . $value . '%');
        }
    }

    public function getUserAttr($value, $data)
    {
        $user = User::where('uid', '=', $data['create_user'])
            ->column('name');
        return $user;
    }


    public function getListByCategory($data,$limit = 10){
        $where = [];
        if(isset($data['category'])&&$data['category']){
            $where['category'] = $data['category'];
        }
        if(isset($data['channel'])&&$data['channel']){
            $where['channel'] = $data['channel'];
        }
        $query = [];
        if(isset($data['page'])&&$data['page']){
            $query['page'] = $data['page'];
        }
        return self::where($where)->order('id desc')
            ->paginate($limit, false, $query)->each(function ($item){
                $item->image =json_decode($item->image);
            });
    }


    public function detail($data){
        $result=self::get($data['id']);
        if($result['image']){
            $result['image'] =json_decode($result['image']);
        }
        if($result['enclosure']){
            $result['enclosure'] =json_decode($result['enclosure']);
        }

        return $result;
    }

}