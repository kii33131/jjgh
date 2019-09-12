<?php
/**
 * Created by originThink
 * Author: 原点 467490186@qq.com
 * Date: 2018/9/7
 * Time: 10:00
 */

namespace app\admin\service;

use app\admin\model\Activity;
use think\facade\Request;
use app\admin\traits\Result;
use think\Session;

class ActivityService
{
    use Result;

    public static function add($data)
    {
        $model = new Activity();
        $model->name = $data['name'];
        $model->begin_time = strtotime($data['begin_time']);
        $model->end_time = strtotime($data['end_time']);
        $model->address = $data['address'];
        $model->detail_time = $data['detail_time'];
        $model->linkman = $data['linkman'];
        $model->linkway = $data['linkway'];
        $model->detail = $data['detail'];
        $model->desc = $data['desc'];
        $model->create_user = get_user_id();
        $model->create_time = time();

        $res = $model->save();
        if ($res) {
            $msg = Result::success('添加成功');
        }else{
            $msg = Result::error('添加失败');
        }
        return $msg;
    }

    public static function edit($data)
    {
        $list = [
            'name' => $data['name'],
            'begin_time' => strtotime($data['begin_time']),
            'end_time' => strtotime($data['end_time']),
            'address' => $data['address'],
            'detail_time' => $data['detail_time'],
            'linkman' => $data['linkman'],
            'linkway' => $data['linkway'],
            'detail' => $data['detail'],
            'desc' => $data['desc'],
        ];

        $res = Activity::update($list, ['id' => $data['id']]);
        if ($res) {
            $msg = Result::success('编辑成功', url('/admin/activityList'));
        } else {
            $msg = Result::error('编辑失败');
        }
        return $msg;
    }

    public static function delete($id)
    {
        if (!$id) {
            return Result::error('参数错误');
        }
        $res = Activity::update(['status' => 0], ['id' => $id]);
        if ($res) {
            $msg = Result::success('删除成功');
        } else {
            $msg = Result::error('删除失败');
        }
        return $msg;
    }
}