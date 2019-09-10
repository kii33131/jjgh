<?php
/**
 * Created by originThink
 * Author: 原点 467490186@qq.com
 * Date: 2018/1/18
 * Time: 15:05
 */

namespace app\admin\controller;

use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\Initiation;
use app\admin\model\Message as MessageModel;
use app\admin\model\User as UserModel;
use app\admin\service\MessageService;
use app\admin\service\UserService;

class Message extends Common
{

    /**
     * 入会申请信息
     * @return mixed
     * @throws \think\exception\DbException
     * @author 原点 <467490186@qq.com>
     */
    public function initiationList()
    {
        if ($this->request->isAjax()) {
            $data = [
                'key' => $this->request->get('key', '', 'trim'),
                'limit' => $this->request->get('limit', 10, 'intval'),
            ];

            $list = Initiation::withSearch(['name'], ['name' => $data['key']])->order('id desc')
                ->paginate($data['limit'], false, ['query' => $data]);
            $user_date = [];
            foreach ($list as $key => $val) {
                $user_date[$key] = $val;
            }
            return show($user_date, 0, '', ['count' => $list->total()]);
        }
        return $this->fetch();
    }

    /**
     * 信息列表
     * @return mixed
     * @throws \think\exception\DbException
     * @author 原点 <467490186@qq.com>
     */
    public function messageList()
    {
        if ($this->request->isAjax()) {
            $data = [
                'limit' => $this->request->get('limit', 10, 'intval'),
            ];
            $title=$this->request->get('key', '', 'trim');
            $channel= $this->request->get('channel', '', 'trim');
            $where = [
                'category'=>$this->request->get('name', '', 'trim')
            ];
            if(isset($title) && $title){
                $where['title'] = $title;
            }
            if(isset($channel) && $channel){
                $where['channel'] = $channel;
            }
            $where['status'] = 1;
            $list =MessageModel::where($where)->order('id desc')->paginate($data['limit'], false, ['query' => $data]);
           // echo MessageModel::getlastsql();exit;
            $user_date = [];
            foreach ($list as $key => $val) {
                $user_date[$key] = $val;
            }
            return show($user_date, 0, '', ['count' => $list->total()]);
        }else {

            $category = $_REQUEST;
            $category = '入会申请';
            $category =str_replace('.html','',$this->request->get('name', '', 'trim'));
            $channel_list=MessageService::channelList($category);
            $this->assign('channel_list', $channel_list);
            $this->assign('name', $category);

        }
        return $this->fetch();
    }

        public function edit()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            //var_dump($data);exit;
           // var_dump($data);exit;
            if ($data['id']) {
                //编辑
                $res = MessageService::edit($data);
                return $res;
            } else {
                //添加
                $data = MessageService::add($data);
                return $data;
            }
        } else {
            //var_dump($_REQUEST);exit;

            $id = $this->request->get('id', 0, 'intval');
            if ($id) {
                $list = MessageModel::where('id', '=', $id)->find();
                if($list['image']){
                    $list['image'] = json_decode($list['image']);
                }
                if($list['enclosure']){
                    $list['enclosure'] = json_decode($list['enclosure']);
                }
                $category=$list['category'];
                $this->assign('list', $list);
            }else{
                $category=$_REQUEST['name'];
            }
            $channel_list=MessageService::channelList($category);
            $this->assign('channel_list', $channel_list);
            $this->assign('category',$category);
            return $this->fetch();
        }
    }

    public function delete()
    {
       // echo '11';exit;
        $id = $this->request->param('id', 0, 'intval');
        if ($id) {
            $res = MessageService::delete($id);
            return $res;
        } else {
            $this->error('参数错误');
        }
    }

    public function down()
    {
        $data = [
            'key' => $this->request->get('key', '', 'trim'),
        ];
        $list = Initiation::withSearch(['name'], ['name' => $data['key']])->hidden(['id'])->select();
        $header = [
            '姓名'=>'string',
            '性别'=>'string',
            '民族'=>'string',
            '出生日期'=>'string',
            '身份证号码'=>'string',
            '申请时间'=>'string',
        ];
        return download_excel($list->toArray(), $header , '入会申请信息.xlsx');
    }

    public function upload(){
        //echo 'aaa';exit;
        $file = request()->file('file');

        $info = $file->move(config('upload_file'),false);
        if($info){
            return json([
                'errorCode' => 0,
                'data' => [
                    'url' => $info->getSaveName()
                ]
            ]);
        }else{
            return json([
                'errorCode' => 10001,
                'msg' => '上传图片失败'
            ]);
        }
    }

    public function uploads(){
        $file = request()->file('file');
        $info = $file->move(config('upload_file_admin'),false);
        if($info){
            $data =[];
            //web_url

            $data['src'] = config('web_url').'/assets/uploads/'.$info->getSaveName();
            echo json_encode(['code'=>0,'msg'=>'success','data'=>$data]);exit;
        }else{
            return json([
                'errorCode' => 10001,
                'msg' => '上传图片失败'
            ]);
        }
    }

    public function newUpload(){
        //echo 'aaa';exit;
        $file = request()->file('file');

        $info = $file->move(config('upload_file'),false);
        if($info){
//            、、{ location : "/demo/image/1.jpg" }
            return json_encode(['location' => $info->getSaveName()]);
        }else{
            return json([
                'errorCode' => 10001,
                'msg' => '上传图片失败'
            ]);
        }
    }
}