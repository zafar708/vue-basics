<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    message: String,
});
</script>

<template>
    <Head title="Contact Us" />

    <div class="bg-white p-10 rounded-xl shadow">
        <h1 class="text-3xl font-bold text-gray-800">Mera Contact Us Inertia page 🎉</h1>
        <p class="mt-4 text-gray-600">{{ message }}</p>
    </div>
</template>
