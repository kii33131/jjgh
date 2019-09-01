<?php
use \think\facade\Route;


Route::group('api', [
    '/message/getListByCategory'=>'api/message/getListByCategory',
    '/Message/detail'=>'api/Message/detail',
])->allowCrossDomain();