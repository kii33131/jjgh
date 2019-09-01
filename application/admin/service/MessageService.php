<?php
/**
 * Created by originThink
 * Author: 原点 467490186@qq.com
 * Date: 2018/9/7
 * Time: 10:00
 */

namespace app\admin\service;


use app\admin\model\Message;
use app\admin\traits\Result;

class MessageService
{
    use Result;

    public static function channelList($category)
    {
        $list = array('入会申请信息发布'=>array('入会须知','工会组件指南','法人资格证办理须知'),
            '维权救助信息发布'=>array('在线律师咨询','职工维权指南','农民工欠薪求助绿色通道','普法课堂'),
            '帮扶救助信息发布'=>array('帮扶须知','建档条件','帮扶信息公示','帮扶政策查询'),
            '互助保障信息发布'=>array('互保办理须知','互保工作状态','赔付信息发布'),
            '劳动竞赛信息发布'=>array('劳动竞赛发布','劳模工匠风采','创新成果展示','职业技能培训'),
            '女工天地信息发布'=>array('组织建设','权益保护','提素建工','关爱行动'),
            '财务经审信息发布'=>array('财务制度','经审监督','业务活动'),
            '工会党建信息发布'=>array('主题教育','党建动态','党风廉政','规章制度'),
            '职工福利信息发布'=>array('1','2','3'),
            '建言献策留言查看'=>array('留言提交','留言结果查询','在线投票','问卷调查'));

        //echo $category;exit;
        if(!empty($list[$category]))
            return $list[$category];
    }

    public static function add($data)
    {
        $model = new Message();
        $model->category =  $data['category'];
        $model->channel = $data['channel'];
        $model->title = $data['title'];
        $model->content = $data['content'];
        unset($data['file']);
        if(isset($data['imgs'])){
            $model->image = json_encode($data['imgs']);
        }
        $model->pageview = $data['pageview'];
        $model->create_user = get_user_id();

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
            'channel' => $data['channel'],
            'title' => $data['title'],
            'content' => $data['content'],
            'category' => $data['category'],
            'pageview' => $data['pageview'],
        ];
        if(isset($data['imgs'])){
            $list['image'] = json_encode($data['imgs']);
        }
        $res = Message::update($list, ['id' => $data['id']]);
        if ($res) {
            $msg = Result::success('编辑成功', url('/admin/messageList'));
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
        $res = Message::where('id','=',$id)->update(array('status'=>0));
        if ($res) {
            $msg = Result::success('删除成功');
        } else {
            $msg = Result::error('删除失败');
        }
        return $msg;
    }
}