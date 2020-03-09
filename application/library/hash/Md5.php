<?php
namespace app\library\hash;

use app\library\Hash;

class Md5 extends Hash
{
    public function make($value, array $options = [])
    {
        $salt = isset($options['salt']) ? $options['salt'] : app('config')->get('hash.md5.salt', 'think');
        return md5(md5($value) . $salt);
    }

    public function check($value, $hashedValue, array $options = [])
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }
        $salt = isset($options['salt']) ? $options['salt'] : app('config')->get('hash.md5.salt', 'think');
        return md5(md5($value) . $salt) == $hashedValue;
    }
}
