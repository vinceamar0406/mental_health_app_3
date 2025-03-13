<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

// Get the user's role from Inertia props
const userRole = usePage().props.auth.user.role;
const assessments = ref([]);

// Fetch assessment history when the component loads
onMounted(() => {
    router.get('/assessment/history', {}, {
        onSuccess: (page) => {
            assessments.value = page.props.assessments;
        }
    });
});

// Format date function
const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

// Generate result page links dynamically based on assessment type
const getResultPageLink = (type) => {
    return type.toLowerCase() === 'anxiety'
        ? '/assessment/anxiety/results'
        : '/assessment/depression/results';
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Welcome, {{ userRole === 'admin' ? 'Admin' : 'User' }}! This is your dashboard.
                    </div>
                </div>

                <!-- Admin Menu -->
                <div v-if="userRole === 'admin'" class="mt-6 bg-white dark:bg-gray-800 p-6 shadow-md rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                        Admin Menu
                    </h3>
                    <ul>
                        <li class="mb-2">
                            <Link :href="route('admin.results')" class="text-blue-500 hover:underline">
                                View Submitted Responses
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- User Assessment History -->
                <div v-if="userRole === 'user'" class="mt-6 bg-white dark:bg-gray-800 p-6 shadow-md rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                        Past Assessments
                    </h3>

                    <table v-if="assessments.length > 0" class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700">
                                <th class="p-2 border">Assessment Type</th>
                                <th class="p-2 border">Total Score</th>
                                <th class="p-2 border">Severity</th>
                                <th class="p-2 border">Date</th>
                                <th class="p-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="assessment in assessments" :key="assessment.id" class="text-center border">
                                <td class="p-2">{{ assessment.assessment_type }}</td>
                                <td class="p-2">{{ assessment.total_score }}</td>
                                <td class="p-2">{{ assessment.severity }}</td>
                                <td class="p-2">{{ formatDate(assessment.created_at) }}</td>
                                <td class="p-2">
                                    <Link :href="getResultPageLink(assessment.assessment_type)" class="text-blue-500 hover:underline">
                                        View Results
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <p v-else class="text-gray-500">No past assessments found.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
