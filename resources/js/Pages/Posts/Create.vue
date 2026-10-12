<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { index, store } from '@/routes/posts';

const form = useForm({
    title: '',
    description: '',
    image: null,
});

const imagePreview = ref(null);

const inputClasses = 'w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500';

function selectImage(event) {
    const file = event.target.files[0] ?? null;

    form.image = file;
    imagePreview.value = file ? URL.createObjectURL(file) : null;
}

function submit() {
    form.submit(store(), { forceFormData: true });
}
</script>

<template>
    <Head title="New Post" />

    <div class="rounded-xl bg-white p-10 shadow">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">New Post</h1>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="flex flex-col gap-1">
                <label for="title" class="font-medium text-gray-700">Title</label>
                <input id="title" v-model="form.title" type="text" :class="inputClasses" />
                <p v-if="form.errors.title" class="text-sm text-red-600">{{ form.errors.title }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <label for="description" class="font-medium text-gray-700">Description</label>
                <textarea id="description" v-model="form.description" rows="6" :class="inputClasses"></textarea>
                <p v-if="form.errors.description" class="text-sm text-red-600">{{ form.errors.description }}</p>
            </div>

            <div class="flex flex-col gap-1">
                <label for="image" class="font-medium text-gray-700">Image</label>
                <img
                    v-if="imagePreview"
                    :src="imagePreview"
                    alt="Post image preview"
                    class="mb-2 h-48 w-full rounded-lg object-cover"
                />
                <input
                    id="image"
                    type="file"
                    accept="image/png,image/jpeg,image/webp"
                    class="text-sm text-gray-600 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-blue-600 hover:file:bg-blue-100"
                    @change="selectImage"
                />
                <p v-if="form.errors.image" class="text-sm text-red-600">{{ form.errors.image }}</p>
            </div>

            <div class="flex items-center gap-4">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="rounded-lg bg-blue-600 px-5 py-2 font-medium text-white hover:bg-blue-700 disabled:opacity-50"
                >
                    Create Post
                </button>

                <Link :href="index()" class="text-gray-600 hover:underline">Cancel</Link>
            </div>
        </form>
    </div>
</template>
