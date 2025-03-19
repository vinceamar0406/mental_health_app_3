<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const isPasswordVisible = ref(false);
const isConfirmPasswordVisible = ref(false);

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <!-- Full-screen background with modern gradient -->
        <div class="flex min-h-screen w-full items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600 dark:from-gray-900 dark:to-gray-800 px-6">
            <div class="w-full max-w-lg text-center space-y-6">

                <!-- Welcome Title -->
                <h2 class="text-4xl font-extrabold text-white drop-shadow-md">Join Us Today </h2>
                <p class="text-lg text-gray-200">Create an account to begin your journey</p>

                <!-- Register Form -->
                <form @submit.prevent="submit" class="mt-4 space-y-5 bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 transition-all duration-500">
                    <!-- Name Field -->
                    <div>
                        <InputLabel for="name" value="Name" class="text-gray-700 dark:text-gray-300" />
                        <TextInput
                            id="name"
                            type="text"
                            class="w-full px-4 py-3 mt-2 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition-all duration-300"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <!-- Email Field -->
                    <div>
                        <InputLabel for="email" value="Email" class="text-gray-700 dark:text-gray-300" />
                        <TextInput
                            id="email"
                            type="email"
                            class="w-full px-4 py-3 mt-2 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition-all duration-300"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <!-- Password Field -->
                    <div>
                        <InputLabel for="password" value="Password" class="text-gray-700 dark:text-gray-300" />
                        <div class="relative">
                            <TextInput
                                id="password"
                                :type="isPasswordVisible ? 'text' : 'password'"
                                class="w-full px-4 py-3 mt-2 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition-all duration-300"
                                v-model="form.password"
                                required
                                autocomplete="new-password"
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <InputLabel for="password_confirmation" value="Confirm Password" class="text-gray-700 dark:text-gray-300" />
                        <div class="relative">
                            <TextInput
                                id="password_confirmation"
                                :type="isConfirmPasswordVisible ? 'text' : 'password'"
                                class="w-full px-4 py-3 mt-2 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition-all duration-300"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                            />
                        </div>
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                    </div>

                    <!-- Register Button -->
                    <div>
                        <PrimaryButton
    class="w-full py-3 text-lg font-semibold tracking-wide bg-yellow-400 hover:bg-yellow-500 !text-gray-900 rounded-full shadow-md transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-yellow-300 flex items-center justify-center gap-2"
    :disabled="form.processing"
>
    <svg v-if="form.processing" class="animate-spin h-5 w-5 text-gray-900" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <circle cx="12" cy="12" r="10" stroke-width="4" class="opacity-25"></circle>
        <path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M4 12a8 8 0 0116 0"></path>
    </svg>
    <span>Register</span>
</PrimaryButton>
                    </div>
                </form>

                <!-- Login Option -->
                <p class="mt-4 text-center text-sm text-gray-200">
                    Already have an account?
                    <Link
                        :href="route('login')"
                        class="text-yellow-200 hover:text-yellow-100 transition-all duration-300"
                    >
                        Log in
                    </Link>
                </p>
            </div>
        </div>
    </GuestLayout>
</template>

