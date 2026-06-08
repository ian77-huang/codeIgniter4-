# rbbr CodeIgniter 4 會員網站

這是一個使用 CodeIgniter 4 建立的會員登入與註冊網站。專案目前包含前台版型、會員表單、AJAX API、Session 登入狀態、CSRF 防護、安全標頭，以及使用者資料表遷移檔。

## 目前功能

- 首頁 `/`
- 會員登入頁 `/user/login`
- 會員註冊頁 `/user/register`
- 會員登出 `/user/logout`
- 登入與註冊表單的前端驗證
- 使用 jQuery AJAX 呼叫後端 API，並自動帶入 CSRF token
- 後端登入、註冊與錯誤訊息皆回傳 JSON
- 密碼使用 `password_hash()` 加密儲存
- 登入成功後寫入 Session：`user_id`、`account`、`is_logged_in`
- 導覽列依登入狀態顯示登入或登出
- 已登入使用者進入登入/註冊頁時會導回首頁
- 繁體中文與英文語系文字
- `users` 資料表遷移檔
- production 環境自動強制使用 HTTPS

## 主要路由

| Method | Path | 說明 |
| --- | --- | --- |
| GET | `/` | 首頁 |
| GET | `/user/login` | 登入頁 |
| GET | `/user/register` | 註冊頁 |
| GET | `/user/logout` | 登出並導回登入頁 |
| POST | `/api/user/login` | 登入 API |
| POST | `/api/user/register` | 註冊 API |

## 專案結構

```text
app/
  Config/Routes.php
  Controllers/
    Api/User/Login.php
    Api/User/Register.php
    User/Login.php
    User/Register.php
    User/Logout.php
  Database/Migrations/
    2026-06-07-123947_CreateUsersTable.php
  Filters/AuthFilter.php
  Helpers/auth_helper.php
  Language/zh-TW/
  Models/UserModel.php
  Services/AuthService.php
  Views/
    layouts/frontend.php
    index.php
    user/login.php
    user/register.php
public/
  assets/js/app.js
writable/
  database/app.sqlite
```

## 資料表

`users` 資料表欄位：

| 欄位 | 型別 | 說明 |
| --- | --- | --- |
| `id` | INTEGER | 主鍵，自動遞增 |
| `account` | VARCHAR(100) | 帳號，唯一 |
| `password` | VARCHAR(255) | 加密後密碼 |
| `created_at` | DATETIME | 建立時間 |
| `updated_at` | DATETIME | 更新時間 |

## 環境需求

- PHP 8.2 或以上
- Composer
- CodeIgniter 4.7
- PHP 擴充套件：`intl`、`mbstring`、`json`
- 若使用 MySQL，需啟用 `mysqlnd`
- 若使用 SQLite，需啟用 `sqlite3`

## 本機啟動

安裝套件：

```bash
composer install
```

建立環境設定：

```bash
cp env .env
```

依需要調整 `.env`，例如：

```ini
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'
```

啟動開發伺服器：

```bash
php spark serve
```

開啟：

```text
http://localhost:8080
```

## 資料庫

專案已包含資料表遷移檔：

```bash
php spark migrate
```

目前版本庫也包含 `writable/database/app.sqlite`，可作為本機練習資料庫使用。若改用 MySQL，請在 `.env` 設定資料庫連線資訊。

## 測試

```bash
composer test
```

## 使用流程

1. 進入 `/user/register` 建立帳號。
2. 註冊成功後系統會建立 Session 並維持登入狀態。
3. 登入狀態下導覽列會顯示「登出」。
4. 點擊 `/user/logout` 會清除 Session 並回到登入頁。
5. 若已登入又進入 `/user/login` 或 `/user/register`，會自動導回首頁。

## 安全性設定

- 已啟用 CSRF filter。
- 已啟用 secureheaders filter。
- 登入與註冊 API 會回傳新的 CSRF token，前端會自動更新下一次請求要使用的 token。
- `forceGlobalSecureRequests` 只會在 production 環境啟用，避免本機開發與測試環境被強制轉成 HTTPS。
