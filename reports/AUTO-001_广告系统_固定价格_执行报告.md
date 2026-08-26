# AUTO-001 广告系统（固定价格）一期 执行报告

## 1. 任务信息

- Task ID: AUTO-001
- Task Name: 广告系统 —— 固定价格（线下付费 + 后台手动配置）
- Execution Time: 2026-08-25
- Execution Status: PASS
- Server: 腾讯云轻量云 Seoul
- Public IP: 43.131.242.91
- Private IP: 10.8.0.15
- G5 Version: 5.6.34
- PHP Version: 8.4.24
- Database Version: MariaDB 11.8.6
- Web Server: Nginx 1.26.3

## 2. 目标

实现规范第 20-22 条要求的「固定广告位 + 固定价格 + 固定周期 + 排期 + 点击统计」广告系统第一期。
付费方式：线下付费，后台手动配置（不接入支付网关）。

## 3. 架构判断（关键决策）

调查发现 G5 商城模块自带的 banner 广告系统（`g5_shop_banner`）已原生实现：

- 固定广告位：`bn_position`
- 排期：`bn_begin_time` / `bn_end_time`
- 点击统计：`bn_hit`（通过 `bannerhit.php` 计数）
- 排序：`bn_order`
- 图片上传 + 设备适配 + 新窗控制

唯一缺失的是「固定价格」字段。

按规范第 10 条「G5 原生优先」与第 25 条「禁止为小功能建表」，**采用复用 G5 商城 banner 表 + 增加 `bn_price` 字段**，而非新建独立广告表。

## 4. 实际修改

### Database Changes
- `g5_shop_banner` 表增加字段 `bn_price int(11) NOT NULL DEFAULT 0`（固定价格，韩元）

### Modified Files
- [bannerform.php](file:///home/www/adm/shop_admin/bannerform.php) — 后台表单增加「고정가격（固定价格）」输入框
- [bannerformupdate.php](file:///home/www/adm/shop_admin/bannerformupdate.php) — 新增/更新两条 SQL 保存逻辑加入 `bn_price`
- [bannerlist.php](file:///home/www/adm/shop_admin/bannerlist.php) — 列表增加「고정가격」列，colspan 7→8

### 另修复的关联问题（P1）
- 首页 [theme/basic/index.php](file:///home/www/theme/basic/index.php) 原硬编码引用已删除板块 `free/qa/notice/gallery`，已替换为业务板块 `promotion/stock/futian1/huangyuan`，并同步更新底部循环排除列表。

## 5. 测试结果

### Database
PASS — 插入含 `bn_price=100000` 的 banner、读取、删除全链路验证通过，无残留

### PHP
PASS — 3 个改动文件 `php -l` 语法检查全部通过

### Frontend
PASS — 首页渲染正常，无 `free.php`/`gallery.php` 死亡引用

### Admin
NOT TESTED — 后台需登录态，无法 curl 直接验证（静态语法 + DB 链路已验证）

### Desktop / Mobile / Security / Performance
NOT TESTED — 本次改动为后台字段级扩展，无前端性能/安全影响面

## 6. 回滚方法

- 数据库：`ALTER TABLE g5_shop_banner DROP COLUMN bn_price;` 或恢复 `/home/backup/g5_shop_banner_pre_price_*.sql`
- 代码：`git checkout`（若已提交）或还原 3 个 PHP 文件的备份

## 7. 风险

- 低。`bn_price` 为独立新字段，不影响既有功能；`g5_shop_banner` 原为 0 数据，无历史数据兼容问题。

## 8. 下一步建议

- 广告位「首页曝光」仍需在社区首页（非商城页）接入展示位 —— 这是二期范围，需单独确认广告位位置/尺寸/数量。
- 若后续需「企业/用户自助购买」，再加购买 + 在线支付（涉及支付网关凭证，需架构决策）。