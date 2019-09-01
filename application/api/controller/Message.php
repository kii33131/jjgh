<?php


namespace app\api\controller;


use think\Request;

class Message extends Base
{

    public function getListByCategory(){

        $data = $this->data_arr;
        $model = new \app\admin\model\Message();
        $list=$model->getListByCategory($data,$this->listRows);
        success($list);
    }
}