<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'name'        => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'start_time'  => $this->faker->time('H:i'),
            'end_time'    => $this->faker->time('H:i'),
            'teacher_id'  => \App\Models\Teacher::factory(),
        ];
    }
}
