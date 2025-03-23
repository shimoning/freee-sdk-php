# Freee SDK for PHP

[Freee]() の PHP 用 SDK です。

現在は Webhook のみ対応。

API は未対応。

[![MIT License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)](LICENSE)
![PHP](https://img.shields.io/badge/PHP-ccc.svg?logo=php&style=flat)
[![Coverage](https://codecov.io/gh/shimoning/freee-sdk-php/graph/badge.svg)]

## Webhook

対応状況

| データ種別       | 作成 | 更新 | 削除 |
| ---------------- | :--: | :--: | :--: |
| [会計]経費精算   |  o   |  o   |  -   |
| [会計]各種申請   |  x   |  x   |  -   |
| [会計]支払依頼   |  x   |  x   |  -   |
| [人事労務]従業員 |  o   |  o   |  o   |

## API

_未対応_

[公式提供 SDK](https://github.com/freee/freee-accounting-sdk-php)
-- 2023 年 4 月にメンテナンス終了済み

## for Laravel

### 環境変数

`.env` などで指定する。

- 検証用トークン: `FREEE_VERIFICATION_TOKEN`
- デバッグログ: `FREEE_WEBHOOK_LOGGING`
  - false : 出力しない
  - true : デフォルトのチャンネルに出力
  - 文字列 : 指定したチャンネルに出力

### config

#### ファイルの配置

.env で設定するなら不要。

```cli
php artisan vendor:publish --provider="Shimoning\FreeeSdk\Laravel\FreeeServiceProvider" --tag=config
```
