make the retake assessment button to redirect to http://localhost:8000/assessment/ptsd

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Header from '@/Components/Header.vue';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
const results = page.props.results;
const pastResults = page.props.past_results;
</script>

<template>
    <AuthenticatedLayout>
        <Head title="PTSD Assessment Results" />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center">
            <div class="w-full max-w-4xl bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-300 dark:border-gray-700">

                <!-- Header -->
                <Header title="PTSD Assessment Results" subtitle="Review your PTSD assessment results below." />

                <div class="p-8 text-gray-900 dark:text-gray-100">

                    <!-- Latest Result -->
                    <div v-if="results" class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg mb-4">
                        <p class="text-lg font-medium">Your Total PTSD Score:</p>
                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ results.total_score }}</p>
                    </div>

                    <div v-if="results" class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg mb-4">
                        <p class="text-lg font-medium">Severity Level:</p>
                        <p class="text-2xl font-bold text-red-500 dark:text-red-400">{{ results.severity }}</p>
                    </div>

                    <div v-if="results" class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg mb-4">
                        <p class="text-lg font-medium">Impact on Daily Life:</p>
                        <p class="text-xl font-semibold">{{ results.impact }}</p>
                    </div>

                    <!-- No Results -->
                    <div v-if="!results" class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg mb-4">
                        <p class="text-lg font-medium text-gray-600">No PTSD assessment results found.</p>
                    </div>

                    <!-- Past Results -->
                    <div v-if="pastResults && pastResults.length > 0" class="mt-6">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Past Results:</h2>

                        <div v-for="(result, index) in pastResults" :key="index" class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg mb-4">
                            <p class="text-lg font-medium">Total PTSD Score:</p>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ result.total_score }}</p>

                            <p class="text-lg font-medium">Severity Level:</p>
                            <p class="text-2xl font-bold text-red-500 dark:text-red-400">{{ result.severity }}</p>

                            <p class="text-lg font-medium">Impact on Daily Life:</p>
                            <p class="text-xl font-semibold">{{ result.impact }}</p>

                            <!-- Display Date and Time -->
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                <strong>Assessment Date:</strong> {{ new Date(result.created_at).toLocaleString() }}
                            </p>
                        </div>
                    </div>

                    <!-- Recommendations -->
                    <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <p class="text-lg font-medium">Recommendations:</p>
                        <ul class="list-disc ml-6 mt-2 space-y-2">
                            <li>If your symptoms are affecting daily life, consider reaching out to a counselor.</li>
                            <li>Practice stress management techniques such as mindfulness or journaling.</li>
                            <li>Engage in physical activities to help regulate emotions.</li>
                            <li>Connect with support groups or trusted individuals for emotional support.</li>
                        </ul>
                    </div>

                    <!-- Retake Assessment Button -->
                    <div class="mt-6">
                        <a href="http://localhost:8000/assessment/ptsd"
                            class="w-full block text-center bg-green-600 text-white py-3 rounded-lg text-lg font-semibold hover:bg-green-700 transition">
                            Retake Assessment
                        </a>
                    </div>

                    <!-- Back to Dashboard Button -->
                    <div class="mt-6">
                        <a href="/dashboard"
                            class="w-full block text-center bg-blue-600 text-white py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition">
                            Back to Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
