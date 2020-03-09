<?php
Route::group('admin', function () {
    // 登录
    Route::post('login', 'auth/login');
    Route::get('logout', 'auth/logout');
    // 公共
    Route::post('upload', 'common/upload');
    Route::get('userInfo', 'common/userInfo');
    Route::put('userInfo', 'common/userInfo');
    // 导出
    Route::get('export/article', 'export/article');
    // 用户
    Route::get('user', 'admin_user/index')->filter('page_size', null);
    Route::get('user', 'admin_user/list');
    Route::post('user', 'admin_user/create');
    Route::put('user', 'admin_user/update');
    Route::delete('user', 'admin_user/delete');
    // 角色
    Route::get('role', 'admin_role/index')->filter('page_size', null);
    Route::get('role', 'admin_role/list');
    Route::post('role', 'admin_role/create');
    Route::put('role', 'admin_role/update');
    Route::delete('role', 'admin_role/delete');
    Route::get('role/menu', 'admin_role/menu');
    Route::put('role/menu', 'admin_role/updateMenu');
    // 菜单
    Route::get('menu', 'admin_menu/index');
    Route::post('menu', 'admin_menu/create');
    Route::put('menu', 'admin_menu/update');
    Route::delete('menu', 'admin_menu/delete');
    // 部门
    Route::get('department', 'admin_department/index');
    Route::post('department', 'admin_department/create');
    Route::put('department', 'admin_department/update');
    Route::delete('department', 'admin_department/delete');
    Route::get('department/leader', 'admin_department/leader');
    // 数据字典
    Route::get('dictionaries', 'sys_dictionary/index');
    Route::post('dictionaries', 'sys_dictionary/create');
    Route::put('dictionaries', 'sys_dictionary/update');
    Route::delete('dictionaries', 'sys_dictionary/delete');
    // 文章
    Route::get('article', 'article/index')->filter('page_size', null);
    Route::get('article', 'article/list');
    Route::post('article', 'article/create');
    Route::put('article', 'article/update');
    Route::delete('article', 'article/delete');
    // 文章类型
    Route::get('articleType', 'article_type/index');
    Route::post('articleType', 'article_type/create');
    Route::put('articleType', 'article_type/update');
    Route::delete('articleType', 'article_type/delete');
})->prefix('admin.');
