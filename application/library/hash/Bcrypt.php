<?php
namespace app\library\hash;

use app\library\Hash;

class Bcrypt extends Hash
{
    public function make($value, array $options = [])
    {
        $cost = isset($options['rounds']) ? $options['rounds'] : app('config')->get('hash.bcrypt.rounds', 10);
        $hash = password_hash($value, PASSWORD_BCRYPT, ['cost' => $cost]);
        if ($hash === false) {
            throw new \RuntimeException('Bcrypt hashing not supported.');
        }
        return $hash;
    }

    public function check($value, $hashedValue, array $options = [])
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }
        return password_verify($value, $hashedValue);
    }
}
