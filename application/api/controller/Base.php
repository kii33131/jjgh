<?php


namespace app\api\controller;

use think\App;
use think\Controller;
use think\Request;

class Base extends Controller
{
    protected $listRows = 10;//每页显示数量

    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $data = file_get_contents('php://input');
        $this->data_str = $data;
        $this->data_arr = json_decode($data, true);
        date_default_timezone_set('PRC'); //设置中国时区
        $this->setListRows();//设置分页数量
    }

    /**
     * 设置分页数量
     */
    protected function setListRows(){
        if(isset($this->data_arr['list_rows'])){
            if(preg_match("/^[1-9][0-9]*$/",$this->data_arr['list_rows'])){
                $this->listRows = $this->data_arr['list_rows'];
            }
        }

        if(isset($this->data_arr['page'])){
            if(preg_match("/^[1-9][0-9]*$/",$this->data_arr['page'])){
                $this->page = $this->data_arr['page'];
            }
        }

    }

    protected function checkParams(&$params)
    {
        foreach ($params as $key => $param) {
            if (!$param || $key == 'limit' || $key == 'page') {
                unset($params[$key]);
            }
        }
    }
}