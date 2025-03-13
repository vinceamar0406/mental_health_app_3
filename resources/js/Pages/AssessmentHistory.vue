<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

// Fetch past assessments from Laravel backend
const page = usePage();
const assessments = page.props.assessments || [];

// Format date function
const formatDate = (dateString) => {
    return dateString ? new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    }) : "No date available";
};

// Severity badge styling
const getSeverityClass = (severity) => {
    switch (severity) {
        case 'Mild': return 'bg-green-500';
        case 'Moderate': return 'bg-yellow-500';
        case 'Severe': return 'bg-red-500';
        default: return 'bg-gray-500';
    }
};
</script>

<template>
    <Head title="Assessment History" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Assessment History
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-4">
                        Your Past Assessments
                    </h3>

                    <!-- Assessment History Table -->
                    <div v-if="assessments.length > 0">
                        <table class="w-full border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden shadow-lg">
                            <thead>
                                <tr class="bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <th class="border border-gray-400 dark:border-gray-600 px-4 py-3">📅 Date</th>
                                    <th class="border border-gray-400 dark:border-gray-600 px-4 py-3">📋 Type</th>
                                    <th class="border border-gray-400 dark:border-gray-600 px-4 py-3">🧠 Score</th>
                                    <th class="border border-gray-400 dark:border-gray-600 px-4 py-3">⚠️ Severity</th>
                                    <th class="border border-gray-400 dark:border-gray-600 px-4 py-3">📊 Impact</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="assessment in assessments" :key="assessment.id"
                                    class="text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-3 text-center">
                                        {{ formatDate(assessment.created_at) }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-3 text-center">
                                        {{ assessment.assessment_type || 'Unknown' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-3 text-center font-semibold">
                                        {{ assessment.total_score ?? 'Not Available' }}
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-lg text-white" :class="getSeverityClass(assessment.severity)">
                                            {{ assessment.severity || 'Unknown' }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 dark:border-gray-600 px-4 py-3 text-center">
                                        {{ assessment.impact ?? 'Not Available' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- No Past Assessments -->
                    <div v-else>
                        <p class="text-gray-700 dark:text-gray-300 text-center">No past assessments found.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
