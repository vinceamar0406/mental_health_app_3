<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { BookOpenIcon, HeartIcon, BrainIcon, ShieldCheckIcon, CloudDrizzleIcon, AlertTriangleIcon, ActivityIcon, EyeOffIcon } from 'lucide-vue-next';

// Define props
defineProps({
    assessments: Array
});

// Icon mapping for different assessments
const icons = {
    'anxiety_assessment': BrainIcon,
    'depression_assessment': HeartIcon,
    'ptsd_assessment': ShieldCheckIcon,
    'stress_assessment': CloudDrizzleIcon,
    'substance_use_assessment': AlertTriangleIcon,
    'eating_disorder_assessment': ActivityIcon,
    'self_harm_assessment': EyeOffIcon,
    'attention_issues_assessment': BookOpenIcon
};

// Default icon if an assessment isn't mapped
const defaultIcon = BookOpenIcon;
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Assessment Hub
            </h2>
        </template>

        <!-- Assessment Hub Content -->
        <div class="flex flex-col items-center justify-center px-8 py-12">
            <p class="text-lg text-center mb-8 text-gray-700 dark:text-gray-300">
                Select an assessment below to evaluate your mental health condition.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div
                    v-for="assessment in assessments"
                    :key="assessment.route"
                    class="p-6 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-md border border-gray-300 dark:border-gray-600
                    hover:shadow-lg transition-all transform hover:scale-105 flex flex-col items-center"
                >
                    <component
                        :is="icons[assessment.route] || defaultIcon"
                        class="w-12 h-12 text-blue-700 dark:text-blue-400 mb-4"
                    />
                    <Link
                        :href="route(assessment.route)"
                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition"
                    >
                        {{ assessment.name }}
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
