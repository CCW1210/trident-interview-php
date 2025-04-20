<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Teacher;
use App\Models\Course;

class CourseApiTest extends BaseTestCase
{
    use DatabaseMigrations;

    // 自动跑迁移且 seed MockDataSeeder
    protected $seed   = true;
    protected $seeder = \Database\Seeders\MockDataSeeder::class;

    protected function setUp(): void
    {
        parent::setUp();
        // Laravel 自带的 BaseTestCase 已经用 CreatesApplication trait
        // 不用再手动 bootstrap
    }

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

    public function test_can_delete_a_course()
    {
        $course = Course::first();

        $response = $this->deleteJson("/api/courses/{$course->id}");
        $response->assertNoContent();

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_returns_404_when_updating_nonexistent_course()
    {
        $response = $this->putJson('/api/courses/9999', ['name' => '不存在']);
        $response->assertStatus(404);
    }
}
