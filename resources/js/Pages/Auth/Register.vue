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

        <div class="flex min-h-screen items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600 dark:from-gray-900 dark:to-gray-800">
            <div class="w-full max-w-md p-8 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl transform transition-all duration-500 hover:scale-[1.02]">
                <h2 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-100">Create an Account</h2>
                <p class="text-center text-gray-600 dark:text-gray-400 mt-1">Sign up to get started</p>

                <form @submit.prevent="submit" class="mt-6 space-y-5">
                    <!-- Name Field -->
                    <div>
                        <InputLabel for="name" value="Name" class="text-gray-700 dark:text-gray-300" />
                        <TextInput
                            id="name"
                            type="text"
                            class="w-full px-4 py-3 mt-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition-all duration-300"
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
                            class="w-full px-4 py-3 mt-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition-all duration-300"
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
                                class="w-full px-4 py-3 mt-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition-all duration-300"
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
                                class="w-full px-4 py-3 mt-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-500 transition-all duration-300"
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
                            class="w-full py-3 text-lg font-semibold tracking-wide bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-400 flex items-center justify-center"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Register
                        </PrimaryButton>
                    </div>
                </form>

                <!-- Login Option -->
                <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    Already have an account?
                    <Link
                        :href="route('login')"
                        class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-all duration-300"
                    >
                        Log in
                    </Link>
                </p>
            </div>
        </div>
    </GuestLayout>
</template>
