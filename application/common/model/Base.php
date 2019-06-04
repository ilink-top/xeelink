<?php
namespace app\common\model;

use think\Db;
use think\Model;
use app\common\exception\ModelException;

class Base extends Model
{
    const FAILURE = 1;
    protected static $instance;

    public static function getInstance()
    {
        return new static;
    }

    public static function getAll($where = [], $order = 'id desc', $field = '*', $limit = 0)
    {
        return self::getInstance()
            ->where($where)
            ->field($field)
            ->order($order)
            ->limit($limit)
            ->all();
    }

    public static function getColumn($where = [], $order = 'id desc', $field = '*', $limit = 0)
    {
        return self::getInstance()
            ->where($where)
            ->order($order)
            ->limit($limit)
            ->column($field, $key);
    }

    public static function getTree($where = [], $order = 'id desc', $field = '*', $limit = 0, $repeat = '······')
    {
        $list = self::getAll($where, $order, $field, $limit);
        $list = tree_list($list);
        foreach ($list as $row) {
            $row['prev'] = string_repeat($repeat, $row['level']);
        }
        return $list;
    }

    public static function getPage($where = [], $order = 'id desc', $field = '*', $limit = 10)
    {
        $pagesize = input('limit', $limit);
        return self::getInstance()
            ->where($where)
            ->field($field)
            ->order($order)
            ->paginate($pagesize, false, [
                'query' => input('get.'),
            ]);
    }

    public static function saveData($data, $where = [])
    {
        $isUpdate = false;
        if (!empty($where)) {
            $isUpdate = true;
        }
        if (array_key_exists(self::getInstance()->getPk(), $data)) {
            $isUpdate = true;
        }

        return self::getInstance()
            ->isUpdate($isUpdate)
            ->save($data, $where);
    }

    public static function deleteData($id)
    {
        return self::destroy($id);
    }

    protected static function transaction($callback)
    {
        Db::startTrans();
        try {
            $result = null;
            if (is_callable($callback)) {
                $result = call_user_func_array($callback, [self::getInstance()]);
            }

            Db::commit();
            return $result;
        } catch (\Exception $e) {
            Db::rollback();
            throw $e;
        }
    }

    protected static function error($msg = '操作失败', $code = self::FAILURE)
    {
        throw new ModelException($msg, $code);
    }
}
