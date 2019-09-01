<?php


namespace app\api\controller;


use think\Request;

class Message extends Base
{
    public function getListByCategory(){

        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:OPTIONS, GET, POST'); // 允许option，get，post请求
        header('Access-Control-Allow-Headers:x-requested-with');
        $data = $this->data_arr;
        $model = new \app\admin\model\Message();
        $list=$model->getListByCategory($data,$this->listRows);
        success($list);
    }

    public function detail(){
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:OPTIONS, GET, POST'); // 允许option，get，post请求
        header('Access-Control-Allow-Headers:x-requested-with');
        $data = $this->data_arr;
        $model = new \app\admin\model\Message();
        $list=$model->detail($data);
        success($list);
    }
}