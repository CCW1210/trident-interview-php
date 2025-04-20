<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;

class TeacherFactory extends Factory
{
    /**
     * 对应的 Model 类
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * 定义 Factory 默认生成的数据。
     *
     * @return array
     */
    public function definition()
    {
        $username = $this->faker->unique()->userName();

        return [
            'name'     => $this->faker->name(),
            'email'    => $this->faker->unique()->safeEmail(),
            'username' => $username,
            // bcrypt 一个固定密码，测试时可以统一用 'password'
            'password' => bcrypt('password'),
        ];
    }
}
