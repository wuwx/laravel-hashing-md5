# Changelog

本项目所有显著变更均记录于此文件。

格式基于 [Keep a Changelog](https://keepachangelog.com/zh-CN/1.1.0/)，版本号遵循 [语义化版本](https://semver.org/lang/zh-CN/)。

## [4.4.3] - 2026-10-31

### Fixed

- `info()` 按 32 位十六进制格式识别 MD5 哈希，修复 `Hash::isHashed()` 对 MD5 哈希误判为明文、导致 `hashed` cast 对预哈希值（数据导入等场景）二次哈希的问题
- `make()` / `check()` 恢复对非字符串输入的宽容处理（`(string)` 转换与 null 防御），收回 4.4.0 由 `strict_types` 引入的 BC break（`Hash::make(123456)` 抛 TypeError）
- `check()` 兼容大写十六进制哈希
- `Md5Hasher` 补充 `verifyConfiguration()` 方法（恒 `true`，MD5 无可调参数）：Laravel 11/12 的 `hashed` cast 写入时会经 `HashManager` 调用该方法，缺失导致报错。Laravel 13 的 `HashManager` 已含 `method_exists` 防御
- `isHashed()` 与 `hashed` cast 相关测试改为按 Laravel 版本（>= 11）决定是否运行：Laravel 10.x 的 `HashManager::isHashed()` 硬编码 `password_get_info()`，不委托给驱动的 `info()`，该特性在 10.x 下无法支持自定义驱动，属框架限制；README 已补充说明

### Added

- 测试补充：`isHashed()` 双分支、`make(123456)`、`check('x', null)`、大写哈希、`verifyConfiguration()`，以及匿名 Model + `hashed` cast 的端到端回归用例
- 新增 `.gitattributes`（dist 导出排除开发文件）
- README 安全提示补充 `rehashOnLogin` 失效说明与 `hashed` cast 已知限制

## [4.4.0] - 2026-10-31

### Added

- 新增 `CHANGELOG.md` 变更日志
- 补充 `check()`（含空哈希边界）、`needsRehash()`、`info()` 的测试覆盖

### Changed

- `Md5Hasher::check()` 改用 `hash_equals()` 恒时比较，防范时序攻击
- 为 `Md5Hasher` 及服务提供者补充 `declare(strict_types=1)` 与返回类型声明（事后补记：`strict_types` 导致 `Hash::make(123456)` 等非字符串输入抛出 TypeError，属 BC break，已在 4.4.3 收回）
- `composer.json` 显式声明 `illuminate/contracts` 依赖，不再依赖传递关系
- `phpunit.xml.dist` 迁移为 PHPUnit 10+ 语法（PHPUnit ≤ 9 下测试可运行，但覆盖率过滤失效并产生 schema 警告）
- CI 中 `actions/checkout` 升级至 v4

## [4.3.0] - 2026-03-22

- CI 从测试矩阵中排除不兼容的 PHP 和 Laravel 版本组合

## [4.2.0] - 2025-03-02

- 更新 Laravel 版本支持

## [4.1.0] - 2024-11-23

- 更新 CI 工作流

## [4.0.0] - 2022-11-02

- 重构项目结构，更新依赖

## [3.0.0] - 2020-09-14

- 合并社区贡献（[#3](https://github.com/wuwx/laravel-hashing-md5/pull/3)）

## [2.0.0] - 2020-03-05

- 更新 `composer.json` 依赖约束

## [1.6.2] - 2018-06-24

- 新增英文 README

## [1.6.1] - 2018-05-02

- 要求 Laravel 5.6 以上

## [1.6.0] - 2018-05-02

- 初始发布：为 Laravel 提供 MD5 哈希驱动
