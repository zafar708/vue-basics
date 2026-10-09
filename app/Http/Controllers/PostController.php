<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function __construct(private PostService $postService) {}

    /**
     * Display a listing of the posts.
     */
    public function index(): Response
    {
        return Inertia::render('Posts/Index', [
            'posts' => Post::latest()->paginate(9),
        ]);
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(): Response
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created post.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $post = $this->postService->store(
            $request->safe()->except('image'),
            $request->file('image'),
        );

        return to_route('posts.show', $post)->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified post.
     */
    public function show(Post $post): Response
    {
        return Inertia::render('Posts/Show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post): Response
    {
        return Inertia::render('Posts/Edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified post.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->postService->update(
            $post,
            $request->safe()->except('image'),
            $request->file('image'),
        );

        return to_route('posts.show', $post)->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified post.
     */
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        return to_route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
