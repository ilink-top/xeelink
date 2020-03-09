<?php
namespace app\model;

use think\Db;
use think\Model;

class Base extends Model
{
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
    protected $hidden = [];
    protected $visible = [];
    protected $append = [];

    public static function instance($data = [])
    {
        return new static($data);
    }

    public static function getMap($param = [])
    {
        return [];
    }

    public static function transaction($callback)
    {
        try {
            $result = Db::transaction($callback);
        } catch (\Exception $e) {
            throw $e;
            return false;
        } catch (\Throwable $e) {
            throw $e;
            return false;
        }
        return $result;
    }

    public function __call($method, $args)
    {
        return parent::__call($method, $args)->hidden($this->hidden)->visible($this->visible)->append($this->append);
    }
}
