<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Teacher;
use App\Models\Course;

class CourseApiTest extends BaseTestCase
{
    use DatabaseMigrations;

    // 自動跑 Migration 並 seed MockDataSeeder
    protected $seed   = true;
    protected $seeder = \Database\Seeders\MockDataSeeder::class;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * 名稱：查詢所有課程
     * 目的：確認 GET /api/courses 能正確回傳所有課程及對應講師資訊
     * 測試資料：透過 MockDataSeeder 已建立多筆 Course 與對應 Teacher
     * Assertions:
     *   - HTTP status 200
     *   - JSON structure contains:
     *     id, name, description, start_time,
     *     end_time, teacher{id, name, email, username}
     */
    public function test_can_list_all_courses()
    {
        $response = $this->getJson('/api/courses');

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'description',
                    'start_time',
                    'end_time',
                    'teacher' => [
                        'id',
                        'name',
                        'email',
                        'username',
                    ],
                ],
            ]);
    }

    /**
     * 名稱：建立新課程
     * 目的：確認 POST /api/courses 能新增一筆課程並回傳 201
     * 測試資料：
     *   - MockDataSeeder 已建立至少一位 Teacher (id=1)
     *   - Payload 包含 name, description, startTime,
     *     endTime, teacherId
     * Assertions:
     *   - HTTP status 201
     *   - JSON fragment: name = 測試課程
     *   - JSON path: teacher.id matches payload.teacherId
     *   - Database has record in courses table with
     *     correct name and teacher_id
     */
    public function test_can_create_a_course()
    {
        $teacher = Teacher::first();

        $payload = [
            'name'        => '測試課程',
            'description' => '測試內容',
            'startTime'   => '08:00',
            'endTime'     => '10:00',
            'teacherId'   => $teacher->id,
        ];

        $response = $this->postJson('/api/courses', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => '測試課程'])
            ->assertJsonPath('teacher.id', $teacher->id);

        $this->assertDatabaseHas('courses', [
            'name'       => '測試課程',
            'teacher_id' => $teacher->id,
        ]);
    }

    /**
     * 名稱：更新課程資訊
     * 目的：確認 PUT /api/courses/{id} 能更新指定課程的欄位並回傳 200
     * 測試資料：使用 MockDataSeeder 已建立一筆 Course (id=1)
     * Assertions:
     *   - HTTP status 200
     *   - JSON fragment: name = 更新後名稱
     *   - JSON fragment: end_time = 12:00
     */
    public function test_can_update_a_course()
    {
        $course = Course::first();

        $response = $this->putJson("/api/courses/{$course->id}", [
            'name'    => '更新後名稱',
            'endTime' => '12:00',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => '更新後名稱'])
            ->assertJsonFragment(['end_time' => '12:00']);
    }

    /**
     * 名稱：刪除課程
     * 目的：確認 DELETE /api/courses/{id} 能刪除指定課程並回傳 204
     * 測試資料：使用 MockDataSeeder 已建立一筆 Course (id=1)
     * Assertions:
     *   - HTTP status 204
     *   - Database no longer has record with that id
     */
    public function test_can_delete_a_course()
    {
        $course = Course::first();

        $response = $this->deleteJson("/api/courses/{$course->id}");
        $response->assertNoContent();

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    /**
     * 名稱：更新不存在的課程
     * 目的：確認對不存在的課程執行 PUT /api/courses/9999 回傳 404
     * 測試資料：未建立 id=9999 的 Course
     * Assertions:
     *   - HTTP status 404
     */
    public function test_returns_404_when_updating_nonexistent_course()
    {
        $response = $this->putJson('/api/courses/9999', ['name' => '不存在']);
        $response->assertStatus(404);
    }
}
