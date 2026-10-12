<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { index, show } from '@/routes/posts';

defineProps({
    message: String,
    posts: Array,
});
</script>

<template>
    <Head title="Home" />

    <div class="bg-white p-10 rounded-xl shadow">
        <h1 class="text-3xl font-bold text-gray-800">Laravel + Inertia + Vue 🎉</h1>
        <p class="mt-4 text-gray-600">{{ message }}</p>
    </div>

    <section class="mt-10">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">Latest Posts</h2>
            <Link :href="index()" class="text-blue-500 hover:underline">View all posts</Link>
        </div>

        <p v-if="posts.length === 0" class="mt-6 rounded-xl bg-white p-10 text-center text-gray-500 shadow">
            No posts yet.
        </p>

        <div v-else class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <article v-for="post in posts" :key="post.id" class="flex flex-col overflow-hidden rounded-xl bg-white shadow">
                <img v-if="post.image_url" :src="post.image_url" :alt="post.title" class="h-40 w-full object-cover" />
                <div v-else class="flex h-40 w-full items-center justify-center bg-gray-200 text-gray-400">No image</div>

                <div class="flex flex-1 flex-col gap-2 p-5">
                    <h3 class="text-lg font-semibold text-gray-800">{{ post.title }}</h3>
                    <p class="line-clamp-3 text-sm text-gray-600">{{ post.description }}</p>

                    <Link :href="show(post.slug)" class="mt-auto pt-3 text-sm text-blue-500 hover:underline">
                        Read more
                    </Link>
                </div>
            </article>
        </div>
    </section>
</template>
