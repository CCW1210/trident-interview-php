<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Teacher;
use App\Models\Course;

class TeacherApiTest extends BaseTestCase
{
    use DatabaseMigrations;

    // 自動跑 Migration 並 seed MockDataSeeder
    protected $seed   = true;
    protected $seeder = \Database\Seeders\MockDataSeeder::class;

    /**
     * 名稱：查詢所有講師
     * 目的：確認 GET /api/teachers 能回傳所有講師並回傳 200
     * 測試資料：透過 MockDataSeeder 已建立 5 筆 Teacher
     * Assertions:
     *   - HTTP status 200
     *   - JSON count = 5
     *   - Each item has id, name, email, username
     */
    public function test_can_list_all_teachers()
    {
        $response = $this->getJson('/api/teachers');

        $response->assertStatus(200)
            ->assertJsonCount(5)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'email', 'username'],
            ]);
    }

    /**
     * 名稱：建立新講師
     * 目的：確認 POST /api/teachers 能新增一位講師並回傳 201
     * 測試資料：Payload 包含 name, email, username, password
     * Assertions:
     *   - HTTP status 201
     *   - JSON fragment: name = 測試講師
     *   - JSON fragment: email = test@test.com
     *   - Database has teacher with email test@test.com
     */
    public function test_can_create_a_teacher()
    {
        $payload = [
            'name'     => '測試講師',
            'email'    => 'test@test.com',
            'username' => 'testuser',
            'password' => 'secret123',
        ];

        $response = $this->postJson('/api/teachers', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => '測試講師'])
            ->assertJsonFragment(['email' => 'test@test.com']);

        $this->assertDatabaseHas('teachers', [
            'email' => 'test@test.com',
        ]);
    }

    /**
     * 名稱：查詢講師課程列表
     * 目的：確認 GET /api/teachers/{id}/courses 能回傳該講師所屬的所有課程
     * 測試資料：
     *   - MockDataSeeder 建立一筆 Teacher (id=1)
     *   - Course::factory() 為該 Teacher 建立 2 筆 Course
     * Assertions:
     *   - HTTP status 200
     *   - JSON structure: each item has
     *     id, name, start_time, end_time
     */
    public function test_can_list_courses_for_a_teacher()
    {
        $teacher = Teacher::first();
        Course::factory()->count(2)->create(['teacher_id' => $teacher->id]);

        $response = $this->getJson("/api/teachers/{$teacher->id}/courses");

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'name', 'start_time', 'end_time'],
            ]);
    }

    /**
     * 名稱：查詢不存在講師的課程
     * 目的：確認 GET /api/teachers/9999/courses 回傳 404
     * 測試資料：未建立 id=9999 的 Teacher
     * Assertions:
     *   - HTTP status 404
     */
    public function test_returns_404_for_nonexistent_teacher_courses()
    {
        $response = $this->getJson('/api/teachers/9999/courses');
        $response->assertStatus(404);
    }
}
