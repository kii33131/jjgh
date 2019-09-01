<?php
/**
 * Created by originThink
 * Author: 原点 467490186@qq.com
 * Date: 2018/1/18
 * Time: 15:05
 */

namespace app\admin\controller;


use app\admin\model\Suggest as SuggestModel;

class Suggest extends Common
{
    public function suggestList()
    {
        if ($this->request->isAjax()) {
            $data = [
                'key' => $this->request->get('key', '', 'trim'),
                'limit' => $this->request->get('limit', 10, 'intval'),
            ];
            $list = SuggestModel::withSearch(['name'], ['name' => $data['key']])
                ->paginate($data['limit'], false, ['query' => $data]);
            $table = [];
            foreach ($list as $key => $val) {
                $table[$key] = $val;
            }
            return show($table, 0, '', ['count' => $list->total()]);
        }
        return $this->fetch();
    }
}