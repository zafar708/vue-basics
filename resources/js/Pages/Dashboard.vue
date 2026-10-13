<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { create, index } from '@/routes/posts';

defineProps({
    memberSince: String,
    totalPosts: Number,
});

const page = usePage();

const user = computed(() => page.props.auth.user);
</script>

<template>
    <Head title="Dashboard" />

    <div class="rounded-xl bg-white p-10 shadow">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ user.name }} 👋</h1>
        <p class="mt-2 text-gray-600">You're logged in. This page is only visible to logged-in users.</p>
    </div>

    <div class="mt-6 grid gap-6 sm:grid-cols-3">
        <div class="rounded-xl bg-white p-6 shadow">
            <p class="text-sm text-gray-500">Email</p>
            <p class="mt-1 truncate font-semibold text-gray-800">{{ user.email }}</p>
        </div>

        <div class="rounded-xl bg-white p-6 shadow">
            <p class="text-sm text-gray-500">Member since</p>
            <p class="mt-1 font-semibold text-gray-800">{{ memberSince }}</p>
        </div>

        <div class="rounded-xl bg-white p-6 shadow">
            <p class="text-sm text-gray-500">Total posts</p>
            <p class="mt-1 font-semibold text-gray-800">{{ totalPosts }}</p>
        </div>
    </div>

    <div class="mt-6 flex gap-4">
        <Link v-if="page.props.auth.can.createPosts" :href="create()" class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">
            New Post
        </Link>
        <Link :href="index()" class="rounded-lg bg-white px-4 py-2 font-medium text-gray-700 shadow hover:bg-gray-200">
            View Posts
        </Link>
    </div>
</template>
