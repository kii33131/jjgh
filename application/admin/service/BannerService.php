<?php
namespace app\admin\service;

use app\admin\model\Banner;
use app\admin\traits\Result;

class BannerService
{
    use Result;

    public static function add($data)
    {
//        dump($data);die;
        $model = new Banner();
        $model->title =  $data['title'];
        $model->url = $data['url'];
        $model->image = $data['image'];
        unset($data['file']);
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
            'title' => $data['title'],
            'url' => $data['url'],
            'image' => $data['image'],
        ];
        $res = Banner::update($list, ['id' => $data['id']]);
        if ($res) {
            $msg = Result::success('编辑成功', url('/admin/editList'));
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
        $res = Banner::where('id','=',$id)->update(array('status'=>0));
        if ($res) {
            $msg = Result::success('删除成功');
        } else {
            $msg = Result::error('删除失败');
        }
        return $msg;
    }
}