<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MockDataSeeder extends Seeder
{
    public function run(): void
    {
        // 清空舊資料（視需求可刪除）
        DB::table('class_record')->truncate();
        DB::table('courses')->truncate();
        DB::table('students')->truncate();
        DB::table('teachers')->truncate();

        // 1. 假資料：5 筆講師
        DB::table('teachers')->insert([
            ['id'=>1,'name'=>'王小明','email'=>'wang@example.com','username'=>'wangxm','password'=>'P@ssw0rd1','created_at'=>now(),'updated_at'=>now()],
            ['id'=>2,'name'=>'李小華','email'=>'li@example.com','username'=>'lixh','password'=>'P@ssw0rd2','created_at'=>now(),'updated_at'=>now()],
            ['id'=>3,'name'=>'張美麗','email'=>'zhang@example.com','username'=>'zhangm','password'=>'P@ssw0rd3','created_at'=>now(),'updated_at'=>now()],
            ['id'=>4,'name'=>'許佳玲','email'=>'xu@example.com','username'=>'xujl','password'=>'P@ssw0rd4','created_at'=>now(),'updated_at'=>now()],
            ['id'=>5,'name'=>'周志強','email'=>'zhou@example.com','username'=>'zhouzq','password'=>'P@ssw0rd5','created_at'=>now(),'updated_at'=>now()],
        ]);

        // 2. 假資料：5 筆學生
        DB::table('students')->insert([
            ['id'=>1,'name'=>'陳大文','email'=>'chen@example.com','username'=>'chendw','password'=>'pass123','created_at'=>now(),'updated_at'=>now()],
            ['id'=>2,'name'=>'林小英','email'=>'lin@example.com','username'=>'linxy','password'=>'pass456','created_at'=>now(),'updated_at'=>now()],
            ['id'=>3,'name'=>'黃小強','email'=>'huang@example.com','username'=>'huangqq','password'=>'pass789','created_at'=>now(),'updated_at'=>now()],
            ['id'=>4,'name'=>'吳怡君','email'=>'wu@example.com','username'=>'wuij','password'=>'pass321','created_at'=>now(),'updated_at'=>now()],
            ['id'=>5,'name'=>'趙明志','email'=>'zhao@example.com','username'=>'zhaomz','password'=>'pass654','created_at'=>now(),'updated_at'=>now()],
        ]);

        // 3. 假資料：5 筆課程
        DB::table('courses')->insert([
            ['id'=>101,'name'=>'微積分導論','description'=>'涵蓋極限與導函數概念','start_time'=>'13:00','end_time'=>'15:00','teacher_id'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>102,'name'=>'程式設計基礎','description'=>'C++ 與資料結構入門','start_time'=>'09:00','end_time'=>'11:00','teacher_id'=>2,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>103,'name'=>'線性代數','description'=>'矩陣與向量運算基礎','start_time'=>'15:00','end_time'=>'17:00','teacher_id'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>104,'name'=>'資料庫概論','description'=>'SQL 與 NoSQL 基礎','start_time'=>'10:00','end_time'=>'12:00','teacher_id'=>2,'created_at'=>now(),'updated_at'=>now()],
            ['id'=>105,'name'=>'物件導向程式','description'=>'Java 與設計模式實作','start_time'=>'14:00','end_time'=>'16:00','teacher_id'=>3,'created_at'=>now(),'updated_at'=>now()],
        ]);

        // 4. 假資料：5 筆選課紀錄
        DB::table('class_record')->insert([
            ['student_id'=>1,'course_id'=>101,'selected_at'=>Carbon::parse('2025-04-19 10:00:00')],
            ['student_id'=>2,'course_id'=>102,'selected_at'=>Carbon::parse('2025-04-19 10:10:00')],
            ['student_id'=>3,'course_id'=>103,'selected_at'=>Carbon::parse('2025-04-19 10:20:00')],
            ['student_id'=>4,'course_id'=>104,'selected_at'=>Carbon::parse('2025-04-19 10:30:00')],
            ['student_id'=>5,'course_id'=>105,'selected_at'=>Carbon::parse('2025-04-19 10:40:00')],
        ]);
    }
}
