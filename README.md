# Laravel Hashing MD5

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

为 Laravel 框架添加 MD5 哈希驱动支持。

> **注意**: MD5 是一种较弱的哈希算法，不推荐用于新项目的密码存储。此扩展包主要用于需要兼容旧系统或特定场景的项目。

## 功能特性

- 为 Laravel 哈希系统添加 MD5 驱动
- 完全兼容 Laravel 的 `Hash` Facade
- 支持 Laravel 5.6 到 12.0 版本
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

或使用 PHPUnit：

```bash
vendor/bin/phpunit
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

## 许可证

本项目基于 [MIT 许可证](LICENSE) 开源。

## 贡献

欢迎提交 Issue 和 Pull Request。
