<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const inputClasses = 'w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500';

function submit() {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <Head title="Register" />

    <div class="mx-auto max-w-md rounded-xl bg-white p-10 shadow">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Create Account</h1>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="flex flex-col gap-1">
                <label for="name" class="font-medium text-gray-700">Name</label>
                <input id="name" v-model="form.name" type="text" autocomplete="name" autofocus :class="inputClasses" />
                <p v-if="form.errors.name" class="text-sm text-red-600">{{ form.errors.name }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <label for="email" class="font-medium text-gray-700">Email</label>
                <input id="email" v-model="form.email" type="email" autocomplete="email" :class="inputClasses" />
                <p v-if="form.errors.email" class="text-sm text-red-600">{{ form.errors.email }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <label for="password" class="font-medium text-gray-700">Password</label>
                <input id="password" v-model="form.password" type="password" autocomplete="new-password" :class="inputClasses" />
                <p v-if="form.errors.password" class="text-sm text-red-600">{{ form.errors.password }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <label for="password_confirmation" class="font-medium text-gray-700">Confirm Password</label>
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    :class="inputClasses"
                />
            </div>

            <button
                type="submit"
                :disabled="form.processing"
                class="rounded-lg bg-blue-600 px-5 py-2 font-medium text-white hover:bg-blue-700 disabled:opacity-50"
            >
                Register
            </button>

            <p class="text-center text-sm text-gray-600">
                Already have an account?
                <Link href="/login" class="text-blue-500 hover:underline">Login</Link>
            </p>
        </form>
    </div>
</template>
