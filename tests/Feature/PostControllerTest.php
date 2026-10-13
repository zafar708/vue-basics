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

test('an author can open the create post page', function () {
    $author = User::factory()->create()->assignRole('author');

    $this->actingAs($author)
        ->get('/posts/create')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('Posts/Create'));
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

test('guests are redirected to the login page when viewing posts', function () {
    $this->get('/posts')->assertRedirect('/login');
});

test('the posts list only shows an author their own posts', function () {
    $author = User::factory()->create()->assignRole('author');
    $ownPost = Post::factory()->for($author)->create();
    Post::factory()->create();

    $this->actingAs($author)
        ->get('/posts')
        ->assertInertia(fn (Assert $page) => $page
            ->where('auth.can.createPosts', true)
            ->has('posts.data', 1)
            ->where('posts.data.0.id', $ownPost->id)
            ->where('posts.data.0.can', ['update' => true, 'delete' => true])
            ->missing('posts.data.0.user'));
});

test('the posts list shows an admin every post with its author', function () {
    $admin = User::factory()->create()->assignRole('admin');
    $writer = User::factory()->create(['name' => 'Jane Writer']);
    Post::factory()->for($writer)->create(['created_at' => now()]);
    Post::factory()->create(['created_at' => now()->subDay()]);

    $this->actingAs($admin)
        ->get('/posts')
        ->assertInertia(fn (Assert $page) => $page
            ->has('posts.data', 2)
            ->where('posts.data.0.user.name', 'Jane Writer')
            ->where('posts.data.0.can', ['update' => true, 'delete' => true]));
});

test('guests see every user\'s posts on the home page', function () {
    Post::factory()->count(2)->create();

    $this->get('/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->has('posts.data', 2));
});

test('guests can read a post but cannot edit or delete it', function () {
    $post = Post::factory()->create();

    $this->get("/posts/{$post->slug}")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('post.id', $post->id)
            ->where('can', ['update' => false, 'delete' => false])
            ->missing('post.user'));
});

test('an author can read another user\'s post but cannot edit or delete it', function () {
    $author = User::factory()->create()->assignRole('author');
    $post = Post::factory()->create();

    $this->actingAs($author)
        ->get("/posts/{$post->slug}")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->where('can', ['update' => false, 'delete' => false]));
});

test('an admin can view another user\'s post with its author', function () {
    $admin = User::factory()->create()->assignRole('admin');
    $post = Post::factory()->for(User::factory()->create(['name' => 'Jane Writer']))->create();

    $this->actingAs($admin)
        ->get("/posts/{$post->slug}")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->where('post.user.name', 'Jane Writer'));
});

test('deleting a user deletes their posts', function () {
    $post = Post::factory()->create();

    $post->user->delete();

    $this->assertModelMissing($post);
});
