<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { store } from '@/actions/App/Http/Controllers/Auth/LoginController';
import { register } from '@/routes';
import { request as passwordRequest } from '@/routes/password';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const inputClasses = 'w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500';

function submit() {
    form.submit(store(), {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
    <Head title="Login" />

    <div class="mx-auto max-w-md rounded-xl bg-white p-10 shadow">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Login</h1>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="flex flex-col gap-1">
                <label for="email" class="font-medium text-gray-700">Email</label>
                <input id="email" v-model="form.email" type="email" autocomplete="email" autofocus :class="inputClasses" />
                <p v-if="form.errors.email" class="text-sm text-red-600">{{ form.errors.email }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <div class="flex items-center justify-between">
                    <label for="password" class="font-medium text-gray-700">Password</label>
                    <Link :href="passwordRequest()" class="text-sm text-blue-500 hover:underline">Forgot password?</Link>
                </div>
                <input id="password" v-model="form.password" type="password" autocomplete="current-password" :class="inputClasses" />
                <p v-if="form.errors.password" class="text-sm text-red-600">{{ form.errors.password }}</p>
            </div>

            <label class="flex items-center gap-2 text-gray-700">
                <input v-model="form.remember" type="checkbox" class="rounded border-gray-300" />
                Remember me
            </label>

            <button
                type="submit"
                :disabled="form.processing"
                class="rounded-lg bg-blue-600 px-5 py-2 font-medium text-white hover:bg-blue-700 disabled:opacity-50"
            >
                Login
            </button>

            <p class="text-center text-sm text-gray-600">
                Don't have an account?
                <Link :href="register()" class="text-blue-500 hover:underline">Register</Link>
            </p>
        </form>
    </div>
</template>
