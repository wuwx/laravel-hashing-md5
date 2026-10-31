# Laravel Hashing MD5

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![run-tests](https://github.com/wuwx/laravel-hashing-md5/actions/workflows/run-tests.yml/badge.svg)](https://github.com/wuwx/laravel-hashing-md5/actions/workflows/run-tests.yml)

为 Laravel 框架添加 MD5 哈希驱动支持。

> **注意**: MD5 是一种较弱的哈希算法，不推荐用于新项目的密码存储。此扩展包主要用于需要兼容旧系统或特定场景的项目。

## 功能特性

- 为 Laravel 哈希系统添加 MD5 驱动
- 完全兼容 Laravel 的 `Hash` Facade
- 支持 Laravel 5.6 到 13.x 版本
- 支持 PHP 7.3 到 8.x 版本
- 自动服务提供者注册

## 系统要求

- PHP >= 7.3
- Laravel >= 5.6

## 安装

通过 Composer 安装扩展包：

```bash
composer require wuwx/laravel-hashing-md5
```

Laravel 5.5+ 会自动注册服务提供者。

## 配置

编辑 `config/hashing.php` 配置文件，将 `driver` 更改为 `md5`：

```php
'driver' => 'md5',
```

或者在 `.env` 文件中设置：

```env
HASH_DRIVER=md5
```

## 使用方法

### 基本使用

配置完成后，可以像使用 Laravel 默认哈希驱动一样使用 MD5：

```php
use Illuminate\Support\Facades\Hash;

// 生成 MD5 哈希
$hashed = Hash::make('password');

// 验证密码
if (Hash::check('password', $hashed)) {
    // 密码匹配
}
```

### 指定驱动使用

也可以显式指定使用 MD5 驱动：

```php
$hashed = Hash::driver('md5')->make('password');
$isValid = Hash::driver('md5')->check('password', $hashed);
```

## 测试

运行测试套件：

```bash
composer test
```

生成测试覆盖率报告：

```bash
composer test-coverage
```

## 安全提示

MD5 算法存在以下安全问题：

- 容易受到彩虹表攻击
- 计算速度快，容易被暴力破解
- 存在哈希碰撞漏洞

**强烈建议**：
- 新项目使用 `bcrypt` 或 `argon2` 算法
- 仅在需要兼容旧系统时使用此扩展包
- 考虑逐步迁移到更安全的哈希算法

### 关于密码自动升级（rehashOnLogin）

`needsRehash()` 恒返回 `false`：MD5 没有可调参数（如 bcrypt 的 cost），格式正确即无需重算。这意味着 **Laravel 内置的登录时自动重新哈希机制（`rehashOnLogin`）在本驱动下不会生效**——即使用户表中的密码不是本驱动生成的格式，也不会在登录时被自动升级或转换。

### `hashed` cast 的已知限制

`Hash::isHashed()` 通过 32 位十六进制格式识别 MD5 哈希。若明文密码本身恰好是 32 位十六进制字符串（例如 `1234567890abcdef1234567890abcdef`），会被误判为已哈希而原样入库。若你的密码策略允许这类值，请勿对密码字段使用 `hashed` cast，直接使用 `$user->password = Hash::make($pwd)`。

该误判仅影响 `isHashed()` / `hashed` cast，不影响登录校验（`check()` 不依赖 `info()`）。

## 许可证

本项目基于 [MIT 许可证](LICENSE) 开源。

## 贡献

欢迎提交 Issue 和 Pull Request。
