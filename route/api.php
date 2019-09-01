<?php
use \think\facade\Route;

Route::rule('api/message/getListByCategory', 'api/Message/getListByCategory')->allowCrossDomain();