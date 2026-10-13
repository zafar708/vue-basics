<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { home } from '@/routes';
import { destroy, edit, index } from '@/routes/posts';

const page = usePage();

const props = defineProps({
    post: Object,
    can: Object,
});

function deletePost() {
    if (confirm(`Delete "${props.post.title}"?`)) {
        router.delete(destroy(props.post.id));
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
                <p v-if="post.user" class="mt-1 text-sm text-gray-500">By {{ post.user.name }}</p>
            </div>

            <p class="whitespace-pre-line text-gray-600">{{ post.description }}</p>

            <div class="flex gap-4 border-t border-gray-100 pt-4 text-sm">
                <Link v-if="page.props.auth.user" :href="index()" class="text-gray-600 hover:underline">Back to posts</Link>
                <Link v-else :href="home()" class="text-gray-600 hover:underline">Back to home</Link>
                <Link v-if="can.update" :href="edit(post.id)" class="text-green-600 hover:underline">Edit</Link>
                <button v-if="can.delete" type="button" class="text-red-500 hover:underline" @click="deletePost">Delete</button>
            </div>
        </div>
    </article>
</template>
