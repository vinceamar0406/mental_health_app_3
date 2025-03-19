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

// Descriptions for each assessment
const descriptions = {
    'anxiety_assessment': 'Assess your anxiety levels based on common symptoms.',
    'depression_assessment': 'Evaluate symptoms of depression and their severity.',
    'ptsd_assessment': 'Check for signs of post-traumatic stress disorder.',
    'stress_assessment': 'Measure your current stress levels.',
    'substance_use_assessment': 'Determine potential substance use risks.',
    'eating_disorder_assessment': 'Screen for symptoms of eating disorders.',
    'self_harm_assessment': 'Identify self-harm tendencies and risk factors.',
    'attention_issues_assessment': 'Assess focus and attention difficulties.'
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-900 dark:text-gray-100">
                Assessment Hub
            </h2>
        </template>

        <!-- Assessment Hub Content -->
        <div class="flex flex-col items-center justify-center px-8 py-12">
            <p class="text-lg text-center mb-8 text-gray-800 dark:text-gray-300">
                Select an assessment below to evaluate your mental health condition.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <a
                    v-for="assessment in assessments"
                    :key="assessment.route"
                    :href="route(assessment.route)"
                    class="block p-6 bg-white dark:bg-gray-900 rounded-xl shadow-md border border-gray-300 dark:border-gray-700
                    hover:shadow-lg transition-all transform hover:scale-105 cursor-pointer"
                >
                    <component
                        v-if="icons[assessment.route]"
                        :is="icons[assessment.route]"
                        class="w-12 h-12 text-blue-700 dark:text-blue-400 mb-4 mx-auto"
                    />
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 text-center">
                        {{ assessment.name }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center mt-2">
                        {{ descriptions[assessment.route] || 'Click to start the assessment.' }}
                    </p>
                </a>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
