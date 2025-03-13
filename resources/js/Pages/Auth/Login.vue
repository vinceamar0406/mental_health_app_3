<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const isPasswordVisible = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div class="flex min-h-screen w-full items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600 dark:from-gray-900 dark:to-gray-800">
            <div class="w-full max-w-md p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl transform transition-all duration-500 hover:scale-[1.02]">
                <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-100">Welcome Back 👋</h2>
                <p class="text-center text-gray-600 dark:text-gray-400 mt-1">Log in to your account</p>

                <div v-if="status" class="p-4 mt-4 text-sm text-green-600 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="mt-6 space-y-5">
                    <!-- Email Field -->
                    <div>
                        <InputLabel for="email" value="Email" class="text-gray-700 dark:text-gray-300" />
                        <TextInput
                            id="email"
                            type="email"
                            class="w-full px-4 py-3 mt-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition-all duration-300"
                            v-model="form.email"
                            required
                            autofocus
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
                                class="w-full px-4 py-3 mt-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition-all duration-300"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                            />
                            <button
                                type="button"
                                @click="isPasswordVisible = !isPasswordVisible"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-400 transition-all duration-300"
                            >
                                <svg v-if="isPasswordVisible" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 3a7 7 0 00-7 7 7 7 0 0014 0 7 7 0 00-7-7zm0 12a5 5 0 110-10 5 5 0 010 10z" />
                                </svg>
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                        </label>
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-all duration-300"
                        >
                            Forgot password?
                        </Link>
                    </div>

                    <!-- Login Button -->
                    <div>
                        <PrimaryButton
                            class="w-full py-3 text-lg font-semibold tracking-wide bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-400 flex items-center justify-center"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Log in
                        </PrimaryButton>
                    </div>
                </form>

                <!-- Sign Up Option -->
                <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    Don't have an account?
                    <Link
                        :href="route('register')"
                        class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-all duration-300"
                    >
                        Sign up
                    </Link>
                </p>
            </div>
        </div>
    </GuestLayout>
</template>
