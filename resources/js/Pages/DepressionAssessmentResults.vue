<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';

// Fetch assessment data from Laravel backend
const page = usePage();
const latestResult = page.props.latest_result || { total_score: "Not Available", severity: "Unknown", impact: "Not provided" };
const pastResults = page.props.past_results || []; // Store previous assessments

// Retake assessment
const retakeAssessment = () => {
    router.get('/assessment/depression'); // Ensures a fresh state
};

// Go back to dashboard
const goToDashboard = () => {
    router.get('/dashboard');
};

// Format date function
const formatDate = (dateString) => {
    return dateString ? new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    }) : "No date available";
};
</script>

<template>
    <Head title="Depression Assessment Results" />

    <AuthenticatedLayout>
        <div class="py-12 flex justify-center">
            <div class="w-full max-w-3xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-md dark:bg-gray-800 sm:rounded-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-200 mb-4">
                        Depression Assessment Results
                    </h2>

                    <!-- Latest Assessment Result -->
                    <div class="border p-4 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-200 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200">Latest Result</h3>
                        <p class="text-lg"><strong>Total Score:</strong> {{ latestResult.total_score }}</p>
                        <p class="text-lg"><strong>Severity Level:</strong> {{ latestResult.severity }}</p>
                        <p class="text-lg"><strong>Impact Level:</strong> {{ latestResult.impact }}</p>
                    </div>

                    <!-- Past Assessments -->
                    <div class="border p-4 rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-gray-200" v-if="pastResults.length > 0">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-200 mb-3">Past Assessments</h3>
                        <div v-for="(result, index) in pastResults" :key="index" class="p-3 border-b last:border-b-0">
                            <p class="text-sm"><strong>Date:</strong> {{ formatDate(result.date) }}</p>
                            <p class="text-sm"><strong>Score:</strong> {{ result.total_score || 'Not Available' }}</p>
                            <p class="text-sm"><strong>Severity:</strong> {{ result.severity || 'Unknown' }}</p>
                        </div>
                    </div>
                    <p v-else class="text-gray-500 italic mt-3">No past assessments available.</p>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex flex-col sm:flex-row gap-4">
                        <button
                            @click="retakeAssessment"
                            class="w-full sm:w-auto flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            🔄 Retake Assessment
                        </button>
                        <button
                            @click="goToDashboard"
                            class="w-full sm:w-auto flex items-center justify-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                            ⬅️ Back to Dashboard
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
