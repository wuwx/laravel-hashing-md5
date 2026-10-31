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
        if (is_string($hashedValue) && preg_match('/^[0-9a-f]{32}$/i', $hashedValue)) {
            return ['algo' => 'md5', 'algoName' => 'md5', 'options' => []];
        }

        return ['algo' => null, 'algoName' => 'unknown', 'options' => []];
    }

    /**
     * Hash the given value using MD5.
     */
    public function make($value, array $options = []): string
    {
        return md5((string) $value);
    }

    /**
     * Check the given plain value against a hash.
     */
    public function check($value, $hashedValue, array $options = []): bool
    {
        if (is_null($hashedValue) || (string) $hashedValue === '') {
            return false;
        }

        return hash_equals(strtolower((string) $hashedValue), md5((string) $value));
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * MD5 没有可调参数（如 bcrypt 的 cost），格式正确即无需重算，故恒返回 false。
     * 注意：这意味着 Laravel 登录时自动重新哈希的机制（rehashOnLogin）
     * 在 md5 驱动下不会生效，详见 README 安全提示。
     */
    public function needsRehash($hashedValue, array $options = []): bool
    {
        return false;
    }

    /**
     * Verify that the configuration is less than or equal to what is configured.
     *
     * MD5 没有可调参数，恒返回 true（与 Laravel AbstractHasher 的默认实现一致）。
     * Laravel 11/12 的 hashed cast 写入时会经 HashManager 调用此方法。
     */
    public function verifyConfiguration($value): bool
    {
        return true;
    }
}
