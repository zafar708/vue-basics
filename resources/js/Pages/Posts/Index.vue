<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { create, destroy, edit, show } from '@/routes/posts';

defineProps({
    posts: Object,
});

function deletePost(post) {
    if (confirm(`Delete "${post.title}"?`)) {
        router.delete(destroy(post.id), { preserveScroll: true });
    }
}
</script>

<template>
    <Head title="Posts" />

    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800">Posts</h1>
        <Link :href="create()" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
            New Post
        </Link>
    </div>

    <p v-if="posts.data.length === 0" class="mt-10 rounded-xl bg-white p-10 text-center text-gray-500 shadow">
        No posts yet. Create your first one!
    </p>

    <div v-else class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <article v-for="post in posts.data" :key="post.id" class="flex flex-col overflow-hidden rounded-xl bg-white shadow">
            <img v-if="post.image_url" :src="post.image_url" :alt="post.title" class="h-40 w-full object-cover" />
            <div v-else class="flex h-40 w-full items-center justify-center bg-gray-200 text-gray-400">No image</div>

            <div class="flex flex-1 flex-col gap-2 p-5">
                <h2 class="text-lg font-semibold text-gray-800">{{ post.title }}</h2>
                <p class="text-xs text-gray-400">{{ post.slug }}</p>
                <p class="line-clamp-3 text-sm text-gray-600">{{ post.description }}</p>

                <div class="mt-auto flex gap-4 pt-3 text-sm">
                    <Link :href="show(post.slug)" class="text-blue-500 hover:underline">View</Link>
                    <Link :href="edit(post.id)" class="text-green-600 hover:underline">Edit</Link>
                    <button type="button" class="text-red-500 hover:underline" @click="deletePost(post)">Delete</button>
                </div>
            </div>
        </article>
    </div>

    <nav v-if="posts.last_page > 1" class="mt-8 flex flex-wrap justify-center gap-2">
        <template v-for="link in posts.links" :key="link.label">
            <Link
                v-if="link.url"
                :href="link.url"
                class="rounded-lg px-3 py-1 text-sm"
                :class="link.active ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200'"
                v-html="link.label"
            />
            <span v-else class="rounded-lg px-3 py-1 text-sm text-gray-400" v-html="link.label"></span>
        </template>
    </nav>
</template>
