<?php

use App\Models\Post;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('guests are redirected to the login page when creating a post', function () {
    $this->post('/posts', [
        'title' => 'Guest Post',
        'description' => 'Should not be saved.',
    ])->assertRedirect('/login');

    $this->assertDatabaseCount('posts', 0);
});

test('a user without a role cannot create a post', function () {
    $this->actingAs(User::factory()->create())
        ->post('/posts', [
            'title' => 'No Role Post',
            'description' => 'Should not be saved.',
        ])
        ->assertForbidden();

    $this->assertDatabaseCount('posts', 0);
});

test('a created post belongs to the logged in author', function () {
    $author = User::factory()->create()->assignRole('author');

    $this->actingAs($author)
        ->post('/posts', [
            'title' => 'My First Post',
            'description' => 'Hello world.',
        ])
        ->assertRedirect('/posts/my-first-post');

    expect(Post::sole()->user_id)->toBe($author->id);
});

test('an author can update their own post', function () {
    $author = User::factory()->create()->assignRole('author');
    $post = Post::factory()->for($author)->create();

    $this->actingAs($author)
        ->put("/posts/{$post->id}", [
            'title' => 'Updated Title',
            'description' => 'Updated description.',
        ])
        ->assertRedirect('/posts/updated-title');

    expect($post->fresh()->title)->toBe('Updated Title');
});

test('an author cannot update another user\'s post', function () {
    $author = User::factory()->create()->assignRole('author');
    $post = Post::factory()->create(['title' => 'Original Title']);

    $this->actingAs($author)
        ->put("/posts/{$post->id}", [
            'title' => 'Hijacked Title',
            'description' => 'Hijacked description.',
        ])
        ->assertForbidden();

    expect($post->fresh()->title)->toBe('Original Title');
});

test('an author cannot delete another user\'s post', function () {
    $author = User::factory()->create()->assignRole('author');
    $post = Post::factory()->create();

    $this->actingAs($author)
        ->delete("/posts/{$post->id}")
        ->assertForbidden();

    $this->assertModelExists($post);
});

test('an admin can delete any post', function () {
    $admin = User::factory()->create()->assignRole('admin');
    $post = Post::factory()->create();

    $this->actingAs($admin)
        ->delete("/posts/{$post->id}")
        ->assertRedirect('/posts');

    $this->assertModelMissing($post);
});

test('the posts list only allows an author to edit and delete their own posts', function () {
    $author = User::factory()->create()->assignRole('author');
    $ownPost = Post::factory()->for($author)->create(['created_at' => now()]);
    Post::factory()->create(['created_at' => now()->subDay()]);

    $this->actingAs($author)
        ->get('/posts')
        ->assertInertia(fn (Assert $page) => $page
            ->where('auth.can.createPosts', true)
            ->where('posts.data.0.id', $ownPost->id)
            ->where('posts.data.0.can', ['update' => true, 'delete' => true])
            ->where('posts.data.1.can', ['update' => false, 'delete' => false]));
});

test('deleting a user deletes their posts', function () {
    $post = Post::factory()->create();

    $post->user->delete();

    $this->assertModelMissing($post);
});
