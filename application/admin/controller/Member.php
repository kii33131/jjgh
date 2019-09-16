<?php
namespace app\admin\controller;

use app\admin\model\Member as MemberModel;

class Member extends Common
{
    public function memberList()
    {
        if ($this->request->isAjax()) {
            $data = [
                'key' => $this->request->get('key', '', 'trim'),
                'limit' => $this->request->get('limit', 10, 'intval'),
            ];
            $list = MemberModel::withSearch(['username'], ['username' => $data['key']])
                ->hidden(['password'])
                ->paginate($data['limit'], false, ['query' => $data]);
            $user_data = [];
            foreach ($list as $key => $val) {
                $gender = $val['gender'];
                if($gender == 0){
                    $val['gender'] = '未知';
                }elseif ($gender == 1){
                    $val['gender'] = '男';
                }else{
                    $val['gender'] = '女';
                }
                $user_data[$key] = $val;
            }
            return show($user_data, 0, '', ['count' => $list->total()]);
        }
        return $this->fetch();
    }
}