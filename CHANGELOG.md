# Changelog

本项目所有显著变更均记录于此文件。

格式基于 [Keep a Changelog](https://keepachangelog.com/zh-CN/1.1.0/)，版本号遵循 [语义化版本](https://semver.org/lang/zh-CN/)。

## [Unreleased]

### Added

- 新增 `CHANGELOG.md` 变更日志
- 补充 `check()`（含空哈希边界）、`needsRehash()`、`info()` 的测试覆盖

### Changed

- `Md5Hasher::check()` 改用 `hash_equals()` 恒时比较，防范时序攻击
- 为 `Md5Hasher` 及服务提供者补充 `declare(strict_types=1)` 与返回类型声明
- `composer.json` 显式声明 `illuminate/contracts` 依赖，不再依赖传递关系
- `phpunit.xml.dist` 迁移为 PHPUnit 7–13 兼容配置
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
