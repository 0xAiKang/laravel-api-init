<?php
/**
 * 助手函数库
 */

if (!function_exists("page")) {
    function page($data)
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