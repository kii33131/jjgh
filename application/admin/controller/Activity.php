<?php
/**
 * Created by originThink
 * Author: 原点 467490186@qq.com
 * Date: 2018/1/18
 * Time: 15:05
 */

namespace app\admin\controller;
use app\admin\model\Activity as ActivityModel;
use app\admin\service\ActivityService;

class Activity extends Common
{
    public function activityList()
    {
        if ($this->request->isAjax()) {
            $data = [
                'key' => $this->request->get('key', '', 'trim'),
                'limit' => $this->request->get('limit', 10, 'intval'),
            ];
            $list = ActivityModel::withSearch(['name'], ['name' => $data['key']])
                ->where('status',1)
                ->paginate($data['limit'], false, ['query' => $data]);
            $table = [];
            foreach ($list as $key => $val) {
                $table[$key] = $val;
                $table[$key]['user'] = $val->user;
            }
            return show($table, 0, '', ['count' => $list->total()]);
        }
        return $this->fetch();
    }

    public function edit()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if ($data['id']) {
                //编辑
                $res = ActivityService::edit($data);
                return $res;
            } else {
                //添加
                $data = ActivityService::add($data);
                return $data;
            }
        } else {
            $id = $this->request->get('id', 0, 'intval');
            if ($id) {
                $list = ActivityModel::where('id', '=', $id)->find();
                if(!empty($list['image'])){
                    $list['image'] = json_decode($list['image']);
                }
                if(!empty($list['enclosure'])){
                    $list['enclosure'] = json_decode($list['enclosure']);
                }
                $this->assign('list', $list);
            }
            return $this->fetch();
        }
    }

    public function delete()
    {
        $id = $this->request->param('id', 0, 'intval');
        if ($id) {
            $res = ActivityService::delete($id);
            return $res;
        } else {
            $this->error('参数错误');
        }
    }
}