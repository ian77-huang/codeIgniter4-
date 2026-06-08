# rbbr CodeIgniter 4 網站

測試帳號：`demo`  
密碼：`1234`

使用 CodeIgniter 4 建立的會員網站，包含註冊、登入、登出與首頁留言板。留言列表所有人都可以查看，登入後才可以新增留言。

## 功能

- 會員註冊、登入、登出
- 首頁留言板
- 登入後才能新增留言
- jQuery AJAX API
- CSRF token 自動帶入與更新
- 密碼使用 `password_hash()` 加密
- 繁體中文與英文語系
- production 環境自動強制 HTTPS，本機與測試環境不會被轉址

## 主要路由

| Method | Path                  | 說明         |
| ------ | --------------------- | ------------ |
| GET    | `/`                   | 首頁與留言板 |
| GET    | `/user/login`         | 登入頁       |
| GET    | `/user/register`      | 註冊頁       |
| GET    | `/user/logout`        | 登出         |
| POST   | `/api/user/login`     | 登入 API     |
| POST   | `/api/user/register`  | 註冊 API     |
| POST   | `/api/message/create` | 新增留言 API |

## 本機啟動

```bash
composer install
cp env .env
php spark migrate
php spark db:seed DatabaseSeeder
php spark serve
```

開啟：

```text
http://localhost:8080
```

`.env` 可依環境調整：

```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
```

## 資料庫

專案包含：

- `users`：會員帳號與加密密碼
- `messages`：留言內容、會員 ID、IP、User-Agent 與刪除狀態

`users`

| 欄位 | 說明 |
| ---- | ---- |
| `id` | 主鍵 |
| `account` | 帳號 |
| `password` | 加密後密碼 |
| `created_at` | 建立時間 |
| `updated_at` | 更新時間 |

`messages`

| 欄位 | 說明 |
| ---- | ---- |
| `id` | 主鍵 |
| `user_id` | 會員 ID |
| `content` | 留言內容 |
| `ip_address` | 留言來源 IP |
| `user_agent` | 瀏覽器資訊 |
| `is_deleted` | 是否已刪除 |
| `created_at` | 建立時間 |
| `updated_at` | 更新時間 |
| `deleted_at` | 刪除時間 |

目前版本庫也包含 `writable/database/app.sqlite`，可直接作為本機練習資料庫使用。

可使用 `DatabaseSeeder` 建立測試帳號與留言資料。

## 測試

```bash
composer test
```

## 安全性

- 已啟用 CSRF filter
- 已啟用 secureheaders filter
- API 成功或失敗都會回傳新的 CSRF token
- HTTPS 強制導向只在 production 且非 localhost 時啟用
