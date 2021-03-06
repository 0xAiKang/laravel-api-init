<?php
/**
 * 助手函数库
 */

if (!function_exists("get_page")) {
    /**
     * 返回客户端分页相关信息
     *
     * @param $data
     *
     * @return array
     */
    function get_page($data)
    {
        return [
            'row_count' => $data->count(),                  //当前页条数
            'limit'     => $data->perPage(),                //每页多少条
            'page'      => $data->currentPage(),            //当前页码
            'total'     => $data->total(),                  //总数
            'is_more'   => (int)$data->hasMorePages(),      //是否有更多
        ];
    }
}

if (!function_exists("get_item")) {
    /**
     * 返回客户端数据
     *
     * @param $data
     *
     * @return array
     */
    function get_item($data)
    {
        return $data->items();
    }
}

if (!function_exists("dda")) {
    /**
     * dd to array
     *
     * @param $model
     */
    function dda($model)
    {
        if (method_exists($model, 'toArray')) {
            dd($model->toArray());
        } else {
            dd($model);
        }
    }
}

if (!function_exists("user")) {
    /**
     * 获取当前登录用户实例
     *
     */
    function user()
    {
        return auth("api")->user();
    }
}

if (!function_exists("uid")) {
    /**
     * 获取当前登录用户ID
     *
     * @return int|string|null
     */
    function uid()
    {
        return auth("api")->id();
    }
}

if (!function_exists("admin")) {
    /**
     * 获取当前登录管理员实例
     *
     */
    function admin()
    {
        return auth("admin")->user();
    }
}

if (!function_exists("admin_id")) {
    /**
     * 获取当前登录管理员ID
     *
     * @return int|string|null
     */
    function admin_id()
    {
        return auth("admin")->id();
    }
}