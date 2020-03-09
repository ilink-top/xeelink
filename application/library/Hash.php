<?php
namespace app\library;

abstract class Hash
{
    abstract public function make($value, array $options = []);
    abstract public function check($value, $hashedValue, array $options = []);
}