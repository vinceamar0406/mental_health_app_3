<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2'; // Import SweetAlert2
import { BookOpenIcon, HeartIcon, BrainIcon, ShieldCheckIcon, CloudDrizzleIcon, AlertTriangleIcon, ActivityIcon, EyeOffIcon } from 'lucide-vue-next';
import { Head } from '@inertiajs/vue3';

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

// Function to show the first prompt (Mental Health Screening Notice)
const startAssessment = (assessment) => {
    Swal.fire({
        title: "About This Screening",
        html: `
            <p><strong>Purpose:</strong> This screening tool helps identify potential mental health concerns through a series of questions about your thoughts, feelings, and behaviors.</p>
            <div style="text-align: left; margin-top: 10px;">
                <p><strong>What to Expect:</strong></p>
                <ul style="list-style: none; padding-left: 0;">
                    <li>✅ Quick assessment (5-10 minutes)</li>
                    <li>✅ Questions about your mental health</li>
                    <li>✅ Private and confidential</li>
                    <li>✅ Immediate results</li>
                </ul>
            </div>
            <hr style="margin: 10px 0;">
            <p><strong>⚠️ Important Notice:</strong></p>
            <p>This screening is for informational purposes only and does not replace professional medical advice or diagnosis.</p>
            <p><strong>🛡 Privacy & Confidentiality:</strong> Your responses are kept confidential.</p>
            <p style="color: red; font-weight: bold;">🚨 Need Immediate Help? If you're in crisis, contact emergency services or a crisis helpline.</p>
        `,
        icon: "info",
        showCancelButton: true,
        confirmButtonText: "I Understand & Continue",
        cancelButtonText: "Cancel",
        customClass: {
            popup: 'swal-wide' // Make it a bit wider for better readability
        }
    }).then((result) => {
        if (result.isConfirmed) {
            showPrivacyPolicy(assessment);
        }
    });
};

// Function to show the second prompt (Data Privacy Act of the Philippines)
const showPrivacyPolicy = (assessment) => {
    Swal.fire({
        title: "Data Privacy Notice",
        html: `
            <p><strong>Republic Act No. 10173 - Data Privacy Act of 2012</strong></p>
            <p>This website collects, processes, and stores personal data in accordance with the Data Privacy Act of 2012 (RA 10173). By proceeding, you acknowledge and agree that:</p>
            <ul style="text-align:left;">
                <li>✅ Your responses will be collected solely for providing insights into your mental health.</li>
                <li>✅ Your data will be kept confidential and will not be shared without consent.</li>
                <li>✅ This screening is for informational purposes only and is not a medical diagnosis.</li>
                <li>✅ You have the right to access, correct, or request deletion of your personal data.</li>
            </ul>
            <p>For more details, visit the <a href="https://www.privacy.gov.ph" target="_blank" style="color:blue;">National Privacy Commission (NPC)</a>.</p>
        `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "I Accept",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            showLoadingAnimation(assessment);
        }
    });
};

// Function to show a loading animation before proceeding
const showLoadingAnimation = (assessment) => {
    Swal.fire({
        title: "Loading...",
        html: '<div class="loader"></div>', // Custom loader
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
            setTimeout(() => {
                window.location.href = route(assessment.route);
            }, 1000); // Simulating a delay before redirecting
        }
    });
};
</script>

<template>
    <Head title="Assessment Hub" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-black dark:text-white">
                Assessment Hub
            </h2>
        </template>

        <!-- Assessment Hub Content -->
        <div class="flex flex-col items-center justify-center px-8 py-12 bg-blue-50 dark:bg-blue-900 min-h-screen">
            <p class="text-lg text-center mb-8 text-black dark:text-white">
                Select an assessment below to evaluate your mental health condition.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div
                    v-for="assessment in assessments"
                    :key="assessment.route"
                    @click="startAssessment(assessment)"
                    class="block p-6 bg-blue-100 dark:bg-blue-800 rounded-xl shadow-md border border-blue-300 dark:border-blue-600
                    hover:shadow-lg transition-all transform hover:scale-105 hover:bg-blue-200 dark:hover:bg-blue-700 cursor-pointer"
                >
                    <component
                        v-if="icons[assessment.route]"
                        :is="icons[assessment.route]"
                        class="w-12 h-12 text-black dark:text-white mb-4 mx-auto"
                    />
                    <h3 class="text-lg font-semibold text-black dark:text-white text-center">
                        {{ assessment.name }}
                    </h3>
                    <p class="text-sm text-black dark:text-white text-center mt-2">
                        {{ descriptions[assessment.route] || 'Click to start the assessment.' }}
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
