<script setup>
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    post: Object,
});

function deletePost() {
    if (confirm(`Delete "${props.post.title}"?`)) {
        router.delete(`/posts/${props.post.id}`);
    }
}
</script>

<template>
    <Head :title="post.title" />

    <article class="overflow-hidden rounded-xl bg-white shadow">
        <img v-if="post.image_url" :src="post.image_url" :alt="post.title" class="h-72 w-full object-cover" />

        <div class="flex flex-col gap-4 p-10">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ post.title }}</h1>
                <p class="mt-1 text-sm text-gray-400">{{ post.slug }}</p>
            </div>

            <p class="whitespace-pre-line text-gray-600">{{ post.description }}</p>

            <div class="flex gap-4 border-t border-gray-100 pt-4 text-sm">
                <Link href="/posts" class="text-gray-600 hover:underline">Back to posts</Link>
                <Link :href="`/posts/${post.id}/edit`" class="text-green-600 hover:underline">Edit</Link>
                <button type="button" class="text-red-500 hover:underline" @click="deletePost">Delete</button>
            </div>
        </div>
    </article>
</template>
