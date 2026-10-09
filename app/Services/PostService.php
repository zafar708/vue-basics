<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
    /**
     * Create a post, generating its slug from the title and storing the image.
     *
     * @param  array{title: string, description: string}  $data
     */
    public function store(array $data, ?UploadedFile $image = null): Post
    {
        $data['slug'] = $this->uniqueSlug($data['title']);

        if ($image) {
            $data['image'] = $image->store('posts', 'public');
        }

        return Post::create($data);
    }

    /**
     * Update a post, regenerating its slug when the title changed and
     * replacing its image when a new one is given.
     *
     * @param  array{title: string, description: string}  $data
     */
    public function update(Post $post, array $data, ?UploadedFile $image = null): Post
    {
        $oldImage = null;

        if ($data['title'] !== $post->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $post);
        }

        if ($image) {
            $oldImage = $post->image;
            $data['image'] = $image->store('posts', 'public');
        }

        $post->update($data);

        if ($oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return $post;
    }

    /**
     * Build a slug from the title that no other post is using.
     */
    private function uniqueSlug(string $title, ?Post $ignore = null): string
    {
        $base = Str::slug($title) ?: 'post';
        $slug = $base;
        $suffix = 2;

        while (
            $slug === 'create'
            || Post::where('slug', $slug)
                ->when($ignore, fn ($query) => $query->whereKeyNot($ignore->getKey()))
                ->exists()
        ) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
