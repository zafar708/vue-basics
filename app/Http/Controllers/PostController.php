<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function __construct(private PostService $postService) {}

    /**
     * Display a listing of the posts.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Posts/Index', [
            'posts' => Post::latest()->paginate(9)->through(fn (Post $post): array => [
                ...$post->toArray(),
                'can' => $this->postAbilities($request, $post),
            ]),
        ]);
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(): Response
    {
        Gate::authorize('create', Post::class);

        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created post.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $post = $this->postService->store(
            $request->user(),
            $request->safe()->except('image'),
            $request->file('image'),
        );

        return to_route('posts.show', $post)->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified post.
     */
    public function show(Request $request, Post $post): Response
    {
        return Inertia::render('Posts/Show', [
            'post' => $post,
            'can' => $this->postAbilities($request, $post),
        ]);
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post): Response
    {
        Gate::authorize('update', $post);

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
        Gate::authorize('delete', $post);

        $post->delete();

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        return to_route('posts.index')->with('success', 'Post deleted successfully.');
    }

    /**
     * What the current visitor may do with the post, for showing or hiding buttons.
     *
     * @return array{update: bool, delete: bool}
     */
    private function postAbilities(Request $request, Post $post): array
    {
        return [
            'update' => (bool) $request->user()?->can('update', $post),
            'delete' => (bool) $request->user()?->can('delete', $post),
        ];
    }
}
