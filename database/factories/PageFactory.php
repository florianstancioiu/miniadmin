<?php

namespace Database\Factories;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->realText();
        $slug = Str::slug($title);

        return [
            'title' => $title,
            'slug' => $slug,
            'image' => $this->faker->imageUrl(),
            'content' => $this->faker->realText(),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
