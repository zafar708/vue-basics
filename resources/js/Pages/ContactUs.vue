<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { store } from '@/routes/contact-us';

defineProps({
    message: String,
});

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const inputClasses = 'w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500';

function submit() {
    form.submit(store(), {
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head title="Contact Us" />

    <div class="bg-white p-10 rounded-xl shadow">
        <h1 class="text-3xl font-bold text-gray-800">Contact Us</h1>

        <form @submit.prevent="submit" class="mt-8 flex flex-col gap-6">
            <div class="grid gap-6 sm:grid-cols-2">
                <div class="flex flex-col gap-1">
                    <label for="name" class="font-medium text-gray-700">Name</label>
                    <input id="name" v-model="form.name" type="text" autocomplete="name" :class="inputClasses" />
                    <p v-if="form.errors.name" class="text-sm text-red-600">{{ form.errors.name }}</p>
                </div>

                <div class="flex flex-col gap-1">
                    <label for="email" class="font-medium text-gray-700">Email</label>
                    <input id="email" v-model="form.email" type="email" autocomplete="email" :class="inputClasses" />
                    <p v-if="form.errors.email" class="text-sm text-red-600">{{ form.errors.email }}</p>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label for="subject" class="font-medium text-gray-700">Subject</label>
                <input id="subject" v-model="form.subject" type="text" :class="inputClasses" />
                <p v-if="form.errors.subject" class="text-sm text-red-600">{{ form.errors.subject }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <label for="message" class="font-medium text-gray-700">Message</label>
                <textarea id="message" v-model="form.message" rows="6" :class="inputClasses"></textarea>
                <p v-if="form.errors.message" class="text-sm text-red-600">{{ form.errors.message }}</p>
            </div>

            <div>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-lg bg-blue-600 px-5 py-2 font-medium text-white hover:bg-blue-700 disabled:opacity-50"
                >
                    Send Message
                </button>
            </div>
        </form>
    </div>
</template>
