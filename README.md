# PHP 面試專用 CRUD API 專案

此專案為 Laravel 開發的簡易選課系統後端，適用於面試題目中的 CRUD API 實作練習，包含教師（teacher）、課程（course）、學生（student）相關的登入、查詢、建立、更新及刪除功能。

---

## 環境需求

- PHP >= 8.0
- Composer
- MySQL
- Laravel 10.x
- XAMPP（含 Apache + MySQL）
- VSCode

---

## 安裝與設定

1. 在本地安裝並啟動 XAMPP（Apache + MySQL）。
2. Clone 此專案：
   ```bash
   git clone <your-repo-url> php-interview-api
   cd php-interview-api
   ```
3. 安裝相依套件：
   ```bash
   composer install
   ```
4. 複製 `.env.example` 為 `.env`，並設定資料庫連線：
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=root
   DB_PASSWORD=
   ```
5. 產生應用程式金鑰：
   ```bash
   php artisan key:generate
   ```
6. 執行資料表 migration 與 seed：
   ```bash
   php artisan migrate
   php artisan db:seed --class=MockDataSeeder
   ```
7. 啟動本地開發伺服器：
   ```bash
   php artisan serve
   ```

---

## 主要功能與 API

### 教師 (Teacher)

| 方法   | 路徑                             | 說明                   |
| ------ | -------------------------------- | ---------------------- |
| GET    | `/api/teachers`                  | 列出所有教師           |
| POST   | `/api/teachers`                  | 建立新教師             |
| GET    | `/api/teachers/{id}/courses`     | 查詢指定教師的課程列表 |
| POST   | `/api/teacher/login`             | 教師登入               |

### 課程 (Course)

| 方法   | 路徑                         | 說明             |
| ------ | ---------------------------- | ---------------- |
| GET    | `/api/courses`               | 列出所有課程     |
| POST   | `/api/courses`               | 新增課程         |
| PUT    | `/api/courses/{id}`          | 更新課程         |
| DELETE | `/api/courses/{id}`          | 刪除課程         |

### 學生 (Student)

| 方法   | 路徑                                    | 說明                       |
| ------ | --------------------------------------- | -------------------------- |
| POST   | `/api/student/login`                    | 學生登入                   |
| POST   | `/api/students/{id}/courses`            | 學生選課                   |
| PUT    | `/api/students/{id}/courses/{courseId}` | 修改選課狀態 (例如退選)    |

---

## 測試 (Feature Tests)

- 使用 PHPUnit 撰寫 Feature Tests，檔案位於 `tests/Feature/*.php`。
- 常用指令：
  ```bash
  php artisan test
  ```
- 測試涵蓋：
  - 列出、建立、更新、刪除課程 API
  - 列出與建立教師 API
  - 查詢教師課程列表 API

---

## 手動測試 (Postman)

可匯入範例 Postman Collection，手動驗證 API：
1. 匯入 `postman_collection.json`
2. 設定環境變數 `baseUrl = http://127.0.0.1:8000`
3. 依序執行所有請求，檢查回應與測試結果一致。

---

## 使用到的主要工具

- VSCode
- XAMPP（Apache + MySQL）
- Composer
- Artisan CLI
- Eloquent ORM
- Factory & Seeder
- PHPUnit + Laravel Test Suite
- Postman

---

## 開發流程

1. 本地環境搭建 → 2. Model/Controller 產生 → 3. DB Migration & Seeder → 4. API 開發 → 5. 撰寫 Feature Tests → 6. 手動驗證 (Postman) → 7. 調整與優化

---

## License

MIT © Ryan Chuang

