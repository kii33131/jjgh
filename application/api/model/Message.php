<?php

namespace app\model;

class Message extends BaseModel
{
    protected $name = 'message';

    public function getListByCategory($data,$limit = self::LIMIT){
        $where = [];
        if(isset($data['category'])&&$data['category']){
            $where['category'] = $data['category'];
        }
        if(isset($data['channel'])&&$data['channel']){
            $where['channel'] = $data['channel'];
        }
       return self::where($where)->order('id desc')
            ->paginate($limit, false, ['query' => request()->param()])->each(function ($item){
                $item->image =json_encode($item->image);
            });
    }

}