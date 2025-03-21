<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';  // Import SweetAlert2

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
        case 'Mild': return 'bg-green-500 text-black';
        case 'Moderate': return 'bg-yellow-500 text-black';
        case 'Severe': return 'bg-red-600 text-black';
        default: return 'bg-blue-300 text-black';
    }
};

// Sorting assessments by date (newest first)
const sortedAssessments = [...assessments].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

// Request Appointment function with loading state
const isLoading = ref(false);
const requestAppointment = async (assessmentId) => {
    // Show SweetAlert confirmation before proceeding
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to request an appointment for this assessment?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, request appointment!',
    });

    // If user confirms, proceed with the request
    if (result.isConfirmed) {
        try {
            isLoading.value = true;
            const response = await axios.post(route('appointments.request'), { assessment_id: assessmentId });

            if (response.status === 200) {
                // Dynamically find the assessment and update its status to 'pending'
                const assessment = sortedAssessments.find(a => a.id === assessmentId);
                if (assessment) {
                    assessment.appointment_status = 'pending'; // Update status in UI
                }

                // Show success message
                Swal.fire(
                    'Appointment Requested!',
                    'Your appointment request has been sent and is pending approval.',
                    'success'
                );
            }
        } catch (error) {
            console.error("Error requesting appointment:", error);
            Swal.fire(
                'Error!',
                error.response?.data?.message || 'An unexpected error occurred. Please try again.',
                'error'
            );
        } finally {
            isLoading.value = false;
        }
    }
};
</script>

<template>
    <Head title="Assessment History" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-black dark:text-white">
                Assessment History
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-blue-200 shadow-md sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-black mb-4">
                        Your Past Assessments
                    </h3>

                    <!-- Assessment History Table -->
                    <div v-if="sortedAssessments.length > 0">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-blue-200 text-black text-left">
                                    <th scope="col" class="py-4 px-5">Date</th>
                                    <th scope="col" class="py-4 px-5">Type</th>
                                    <th scope="col" class="py-4 px-5">Score</th>
                                    <th scope="col" class="py-4 px-5">Severity</th>
                                    <th scope="col" class="py-4 px-5">Impact</th>
                                    <th scope="col" class="py-4 px-5">Appointment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="assessment in sortedAssessments" :key="assessment.id"
                                    class="border-b border-gray-700 hover:bg-blue-200 transition">
                                    <td class="py-4 px-5 text-black">
                                        {{ formatDate(assessment.created_at) }}
                                    </td>
                                    <td class="py-4 px-5 text-black-semibold">
                                        {{ assessment.assessment_type || 'Unknown' }}
                                    </td>
                                    <td class="py-4 px-5 text-black font-semibold">
                                        {{ assessment.total_score ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-5">
                                        <span class="px-4 py-2 rounded-lg text-black-sm font-semibold" :class="getSeverityClass(assessment.severity)">
                                            {{ assessment.severity || 'Unknown' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-5 text-black">
                                        {{ assessment.impact ?? 'Not Available' }}
                                    </td>
                                    <td class="py-4 px-5 text-center">
                                        <!-- Request Appointment Button -->
                                        <template v-if="assessment.appointment_status === 'none'">
                                            <button
                                                @click="requestAppointment(assessment.id)"
                                                :disabled="isLoading"
                                                class="bg-blue-400 hover:bg-blue-300 text-black px-4 py-2 rounded-lg transition-all focus:ring-2 focus:ring-blue-500">
                                                <span v-if="isLoading">Loading...</span>
                                                <span v-else>Request Appointment</span>
                                            </button>
                                        </template>
                                        <!-- Appointment Pending -->
                                        <template v-else-if="assessment.appointment_status === 'pending'">
                                            <span class="text-yellow-500 font-semibold">
                                                Pending Approval
                                            </span>
                                            <div v-if="assessment.appointment_date">
                                                <span class="text-gray-400">Scheduled for: {{ formatDate(assessment.appointment_date) }}</span>
                                            </div>
                                        </template>
                                        <!-- Appointment Approved -->
                                        <template v-else-if="assessment.appointment_status === 'approved'">
                                            <span class="text-green-500 font-semibold">
                                                Approved - {{ formatDate(assessment.schedule_at) }}
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
                        <p class="text-black">No past assessments found.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
