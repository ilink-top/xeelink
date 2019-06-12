<?php
namespace app\common\service;

class Article extends Base
{
    public static function getPage($param = [], $order = 'id desc', $field = '*', $limit = 10)
    {
        $where = [];
        if (!empty($param['category_id'])) {
            $where[] = ['category_id', '=', $param['category_id']];
        }
        return parent::getPage($where, $order, $field, $limit);
    }
}
