<?php


namespace app\api\controller;


use think\Request;

class Message extends Base
{

    public function getListByCategory(){

        $data = $this->data_arr;

       // var_dump($data);exit;
        $model = new \app\admin\model\Message();
        $list=$model->getListByCategory($data,$this->listRows);
        success($list);
    }
}