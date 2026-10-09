<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraphs(3, true),
            'image' => null,
        ];
    }

    /**
     * Indicate that the post has an image stored at the given path.
     */
    public function withImage(string $path = 'posts/sample.jpg'): static
    {
        return $this->state(fn (array $attributes) => [
            'image' => $path,
        ]);
    }
}
