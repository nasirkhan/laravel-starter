<?php

namespace Modules\Comment\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Comment\Entities\Comment;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'              => $this->faker->sentence(2),
            'slug'              => '',
            'comment'           => $this->faker->paragraph,
            'user_id'           => $this->faker->numberBetween(1, 4),
            'commentable_id'    => $this->faker->numberBetween(1, 25),
            'commentable_type'  => 'Modules\Article\Entities\Post',
            'status'            => $this->faker->randomElement([0, 1]),
            'moderated_by'      => $this->faker->numberBetween(1, 2),
            'moderated_at'      => Carbon::now(),
            'published_at'      => Carbon::now(),
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];
    }
}
