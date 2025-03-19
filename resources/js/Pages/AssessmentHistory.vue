<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';

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
        case 'Mild': return 'bg-green-500 text-white';
        case 'Moderate': return 'bg-yellow-500 text-gray-900';
        case 'Severe': return 'bg-red-600 text-white';
        default: return 'bg-gray-500 text-white';
    }
};

// Sorting assessments by date (newest first)
const sortedAssessments = [...assessments].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

// Request Appointment function
const requestAppointment = async (assessmentId) => {
    try {
        // Make the request to the backend to request an appointment
        const response = await router.post(route('appointments.request'), { assessment_id: assessmentId });

        if (response.status === 200) {
            // Dynamically find the assessment and update its status to 'pending'
            const assessment = sortedAssessments.find(a => a.id === assessmentId);
            if (assessment) {
                assessment.appointment_status = 'pending'; // Update status in UI
            }
        }
    } catch (error) {
        console.error("Error requesting appointment:", error);
        alert("Something went wrong. Please try again.");
    }
};



</script>

<template>
    <Head title="Assessment History" />

    <AuthenticatedLayout>
        <template #header>
    <h2 class="text-xl font-semibold leading-tight text-white">
        Assessment History
    </h2>
</template>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-900 shadow-md sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold text-white mb-4">
                Your Past Assessments
            </h3>

            <!-- Assessment History Table -->
            <div v-if="sortedAssessments.length > 0">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left">
                            <th class="py-3 px-4">📅 Date</th>
                            <th class="py-3 px-4">📋 Type</th>
                            <th class="py-3 px-4">🧠 Score</th>
                            <th class="py-3 px-4">⚠️ Severity</th>
                            <th class="py-3 px-4">📊 Impact</th>
                            <th class="py-3 px-4">📅 Appointment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="assessment in sortedAssessments" :key="assessment.id"
                            class="border-b border-gray-700 hover:bg-gray-800 transition">
                            <td class="py-3 px-4 text-white">
                                {{ formatDate(assessment.created_at) }}
                            </td>
                            <td class="py-3 px-4 text-white font-semibold">
                                {{ assessment.assessment_type || 'Unknown' }}
                            </td>
                            <td class="py-3 px-4 text-white font-semibold">
                                {{ assessment.total_score ?? 'N/A' }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-lg text-sm font-semibold" :class="getSeverityClass(assessment.severity)">
                                    {{ assessment.severity || 'Unknown' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-white">
                                {{ assessment.impact ?? 'Not Available' }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <!-- Request Appointment Button -->
                                <template v-if="assessment.appointment_status === 'none'">
                                    <button
                                        @click="requestAppointment(assessment.id)"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg transition-all">
                                        Request Appointment
                                    </button>
                                </template>
                                <!-- Appointment Pending -->
                                <template v-else-if="assessment.appointment_status === 'pending'">
                                    <span class="text-yellow-500 font-semibold">Pending Approval</span>
                                </template>
                                <!-- Appointment Approved -->
                                <template v-else-if="assessment.appointment_status === 'approved'">
                                    <span class="text-green-500 font-semibold">
                                        Approved - {{ assessment.appointment_date }}
                                    </span>
                                </template>
                                <!-- Appointment Completed -->
                                <template v-else-if="assessment.appointment_status === 'completed'">
                                    <span class="text-gray-400 font-semibold">Completed</span>
                                </template>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- No Past Assessments -->
            <div v-else class="text-center py-6">
                <p class="text-white">No past assessments found.</p>
            </div>
        </div>
    </div>
</div>
</AuthenticatedLayout>
</template>
