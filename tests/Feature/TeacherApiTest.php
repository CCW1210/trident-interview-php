<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Teacher;
use App\Models\Course;

class TeacherApiTest extends BaseTestCase
{
    use DatabaseMigrations;

    protected $seed   = true;
    protected $seeder = \Database\Seeders\MockDataSeeder::class;

    public function test_can_list_all_teachers()
    {
        $response = $this->getJson('/api/teachers');

        $response->assertStatus(200)
                 ->assertJsonCount(5)
                 ->assertJsonStructure([
                     '*' => ['id','name','email','username'],
                 ]);
    }

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

    public function test_can_list_courses_for_a_teacher()
    {
        $teacher = Teacher::first();

        // 使用 CourseFactory 生成两门课程给此讲师
        Course::factory()->count(2)->create(['teacher_id' => $teacher->id]);

        $response = $this->getJson("/api/teachers/{$teacher->id}/courses");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['id','name','start_time','end_time'],
                 ]);
    }

    public function test_returns_404_for_nonexistent_teacher_courses()
    {
        $response = $this->getJson('/api/teachers/9999/courses');
        $response->assertStatus(404);
    }
}
