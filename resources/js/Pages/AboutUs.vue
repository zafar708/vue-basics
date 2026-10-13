<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { contactUs } from '@/routes';

defineProps({
    message: String,
});

const stats = [
    { label: 'Years of experience', value: '10+' },
    { label: 'Happy clients', value: '250+' },
    { label: 'Projects delivered', value: '480' },
    { label: 'Team members', value: '24' },
];

const values = [
    {
        icon: '🎯',
        title: 'Focus on Quality',
        description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante venenatis dapibus.',
    },
    {
        icon: '🤝',
        title: 'Honest Partnership',
        description: 'Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper.',
    },
    {
        icon: '🚀',
        title: 'Always Improving',
        description: 'Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.',
    },
];

const teamMembers = [
    { name: 'Zafar Iqbal', role: 'Founder & CEO', initials: 'ZI' },
    { name: 'Bilal Ahmed', role: 'Lead Developer', initials: 'BA' },
    { name: 'Imran Malik', role: 'Product Designer', initials: 'IM' },
    { name: 'Usman Raza', role: 'Project Manager', initials: 'UR' },
];
</script>

<template>
    <Head title="About Us" />

    <div class="flex flex-col gap-10">
        <section class="rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 p-10 text-white shadow">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-200">About Us</p>
            <h1 class="mt-2 text-4xl font-bold">We build things people love to use.</h1>
            <p class="mt-4 max-w-2xl text-blue-100">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor
                incididunt ut labore et dolore magna aliqua.
            </p>
        </section>

        <section class="grid gap-8 rounded-xl bg-white p-10 shadow md:grid-cols-2">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Our Story</h2>
                <p class="mt-4 text-gray-600">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam quis risus eget urna mollis
                    ornare vel eu leo. Maecenas faucibus mollis interdum. Curabitur blandit tempus porttitor.
                </p>
                <p class="mt-4 text-gray-600">
                    Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Nulla vitae elit libero,
                    a pharetra augue. Etiam porta sem malesuada magna mollis euismod.
                </p>
            </div>

            <div class="flex flex-col gap-6">
                <div class="rounded-lg border-l-4 border-blue-600 bg-blue-50 p-5">
                    <h3 class="font-semibold text-gray-800">Our Mission</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Duis mollis,
                        est non commodo luctus.
                    </p>
                </div>

                <div class="rounded-lg border-l-4 border-indigo-600 bg-indigo-50 p-5">
                    <h3 class="font-semibold text-gray-800">Our Vision</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa
                        justo sit amet risus.
                    </p>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-2 gap-6 md:grid-cols-4">
            <div v-for="stat in stats" :key="stat.label" class="rounded-xl bg-white p-6 text-center shadow">
                <p class="text-3xl font-bold text-blue-600">{{ stat.value }}</p>
                <p class="mt-1 text-sm text-gray-500">{{ stat.label }}</p>
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-bold text-gray-800">What We Value</h2>

            <div class="mt-6 grid gap-6 md:grid-cols-3">
                <div v-for="value in values" :key="value.title" class="rounded-xl bg-white p-6 shadow">
                    <div class="flex size-12 items-center justify-center rounded-lg bg-blue-100 text-2xl">
                        {{ value.icon }}
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-gray-800">{{ value.title }}</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ value.description }}</p>
                </div>
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-bold text-gray-800">Meet the Team</h2>

            <div class="mt-6 grid gap-6 sm:grid-cols-2 md:grid-cols-4">
                <div v-for="member in teamMembers" :key="member.name" class="rounded-xl bg-white p-6 text-center shadow">
                    <div
                        class="mx-auto flex size-20 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-xl font-bold text-white"
                    >
                        {{ member.initials }}
                    </div>
                    <h3 class="mt-4 font-semibold text-gray-800">{{ member.name }}</h3>
                    <p class="text-sm text-gray-500">{{ member.role }}</p>
                </div>
            </div>
        </section>

        <section class="flex flex-col items-start gap-4 rounded-xl bg-white p-10 shadow md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Want to work with us?</h2>
                <p class="mt-2 text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>

            <Link
                :href="contactUs()"
                class="rounded-lg bg-blue-600 px-5 py-2 font-medium text-white hover:bg-blue-700"
            >
                Contact Us
            </Link>
        </section>
    </div>
</template>
