<?php

declare(strict_types=1);

namespace Wuwx\LaravelHashingMd5;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class Md5Hasher implements HasherContract
{
    /**
     * Get information about the given hashed value.
     */
    public function info($hashedValue): array
    {
        return password_get_info($hashedValue);
    }

    /**
     * Hash the given value using MD5.
     */
    public function make($value, array $options = []): string
    {
        return md5($value);
    }

    /**
     * Check the given plain value against a hash.
     */
    public function check($value, $hashedValue, array $options = []): bool
    {
        if (strlen($hashedValue) === 0) {
            return false;
        }

        return hash_equals($hashedValue, md5($value));
    }

    /**
     * Check if the given hash has been hashed using the given options.
     */
    public function needsRehash($hashedValue, array $options = []): bool
    {
        return false;
    }
}
