<?php

namespace Wuwx\LaravelHashingMd5;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class Md5Hasher implements HasherContract
{

    public function info($hashedValue)
    {
        return password_get_info($hashedValue);
    }

    public function make($value, array $options = [])
    {
        $hash = md5($value);
        return $hash;
    }

    public function check($value, $hashedValue, array $options = [])
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }
        return $hashedValue === md5($value);
    }
    
    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
}
