<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { show } from '@/routes/posts';

defineProps({
    message: String,
    posts: Object,
});
</script>

<template>
    <Head title="Home" />

    <div class="bg-white p-10 rounded-xl shadow">
        <h1 class="text-3xl font-bold text-gray-800">Home</h1>
    </div>

    <section class="mt-10">
        <h2 class="text-2xl font-bold text-gray-800">Latest Posts</h2>

        <p v-if="posts.data.length === 0" class="mt-6 rounded-xl bg-white p-10 text-center text-gray-500 shadow">
            No posts yet.
        </p>

        <div v-else class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <article v-for="post in posts.data" :key="post.id" class="flex flex-col overflow-hidden rounded-xl bg-white shadow">
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

        <nav v-if="posts.last_page > 1" class="mt-8 flex flex-wrap justify-center gap-2">
            <template v-for="link in posts.links" :key="link.label">
                <Link
                    v-if="link.url"
                    :href="link.url"
                    class="rounded-lg px-3 py-1 text-sm"
                    :class="link.active ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200'"
                >
                    <span v-html="link.label"></span>
                </Link>
                <span v-else class="rounded-lg px-3 py-1 text-sm text-gray-400" v-html="link.label"></span>
            </template>
        </nav>
    </section>
</template>
