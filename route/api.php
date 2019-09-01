<?php
use \think\facade\Route;

Route::rule('api/message/getListByCategory', 'api/Message/getListByCategory')->allowCrossDomain();
Route::rule('api/message/detail', 'api/Message/detail')->allowCrossDomain();