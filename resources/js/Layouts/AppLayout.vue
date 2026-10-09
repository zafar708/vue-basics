<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const user = computed(() => page.props.auth.user);
const successMessage = computed(() => page.props.flash?.success);
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <header class="bg-white shadow">
            <nav class="max-w-4xl mx-auto px-6 py-4 flex flex-wrap items-center gap-6">
                <Link href="/" class="text-blue-500 hover:underline">Home</Link>
                <Link href="/about-us" class="text-blue-500 hover:underline">About Us</Link>
                <Link href="/contact-us" class="text-blue-500 hover:underline">Contact Us</Link>
                <Link href="/posts" class="text-blue-500 hover:underline">Posts</Link>

                <div class="ml-auto flex items-center gap-6">
                    <template v-if="user">
                        <Link href="/dashboard" class="text-blue-500 hover:underline">Dashboard</Link>
                        <span class="text-gray-600">{{ user.name }}</span>
                        <Link href="/logout" method="post" as="button" class="text-red-500 hover:underline">
                            Logout
                        </Link>
                    </template>

                    <template v-else>
                        <Link href="/login" class="text-blue-500 hover:underline">Login</Link>
                        <Link
                            href="/register"
                            class="rounded-lg bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700"
                        >
                            Register
                        </Link>
                    </template>
                </div>
            </nav>
        </header>

        <main class="max-w-4xl mx-auto px-6 py-10">
            <div v-if="successMessage" class="mb-6 rounded-lg bg-green-100 px-4 py-3 text-green-800">
                {{ successMessage }}
            </div>

            <slot />
        </main>

        <footer class="text-center text-sm text-gray-500 py-6">
            © 2026 Vue Basics
        </footer>
    </div>
</template>
