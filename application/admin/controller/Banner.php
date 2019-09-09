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
use app\admin\model\Banner as BannerModel;
use app\admin\model\User as UserModel;
use app\admin\service\BannerService;
use app\admin\service\UserService;

class Banner extends Common
{
    /**
     * 轮播图列表
     * @return mixed|void
     * @throws \think\exception\DbException
     */
    public function bannerList()
    {
        if ($this->request->isAjax()) {
            $data = [
                'key' => $this->request->get('key', '', 'trim'),
                'limit' => $this->request->get('limit', 10, 'intval'),
            ];
//            dump($this->request->domain());die;
            $list = BannerModel::withSearch(['title'], ['title' => $data['key']])
                ->where('status',1)
                ->order('id desc')
                ->paginate($data['limit'], false, ['query' => $data]);
            $domain = $this->request->domain();
            $user_data = [];
            foreach ($list as $key => $val) {
                $val['image'] = $domain . '/assets/uploads/' . $val['image'];
                $user_data[$key] = $val;
            }
            return show($user_data, 0, '', ['count' => $list->total()]);
        }
        return $this->fetch();
    }

    public function edit()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
//            dump($data);exit;
            if ($data['id']) {
                //编辑
                $res = BannerService::edit($data);
                return $res;
            } else {
                //添加
                $data = BannerService::add($data);
                return $data;
            }
        } else {
            $id = $this->request->get('id', 0, 'intval');
            if ($id) {
                $list = BannerModel::where('id', '=', $id)->find();
                $this->assign('list', $list);
            }
            return $this->fetch();
        }
    }

    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id) {
            $res = BannerService::delete($id);
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
}