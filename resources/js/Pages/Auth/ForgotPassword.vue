<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
});

const inputClasses = 'w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500';

function submit() {
    form.post('/forgot-password');
}
</script>

<template>
    <Head title="Forgot Password" />

    <div class="mx-auto max-w-md rounded-xl bg-white p-10 shadow">
        <h1 class="mb-2 text-3xl font-bold text-gray-800">Forgot Password</h1>
        <p class="mb-6 text-gray-600">
            Enter your email and we'll send you a link to choose a new password.
        </p>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="flex flex-col gap-1">
                <label for="email" class="font-medium text-gray-700">Email</label>
                <input id="email" v-model="form.email" type="email" autocomplete="email" autofocus :class="inputClasses" />
                <p v-if="form.errors.email" class="text-sm text-red-600">{{ form.errors.email }}</p>
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="rounded-lg bg-blue-600 px-5 py-2 font-medium text-white hover:bg-blue-700 disabled:opacity-50"
            >
                Send Reset Link
            </button>

            <p class="text-center text-sm text-gray-600">
                Remembered it?
                <Link href="/login" class="text-blue-500 hover:underline">Back to login</Link>
            </p>
        </form>
    </div>
</template>
