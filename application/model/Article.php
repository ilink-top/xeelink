<?php
namespace app\model;

use think\model\concern\SoftDelete;

class Article extends Base
{
    use SoftDelete;
    protected $autoWriteTimestamp = true;
    protected $hidden = ['create_time', 'update_time', 'delete_time'];
}
