<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Header from '@/Components/Header.vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref, computed, reactive } from 'vue';

const page = usePage();
const isLoading = ref(false);

// Stress Questions (Perceived Stress Scale)
const questions = [
    "In the last month, how often have you been upset because of something that happened unexpectedly?",
    "In the last month, how often have you felt that you were unable to control the important things in your life?",
    "In the last month, how often have you felt nervous and stressed?",
    "In the last month, how often have you felt confident about your ability to handle your personal problems?",
    "In the last month, how often have you felt that things were going your way?",
    "In the last month, how often have you found that you could not cope with all the things that you had to do?",
    "In the last month, how often have you been able to control irritations in your life?",
    "In the last month, how often have you felt that you were on top of things?",
    "In the last month, how often have you been angered because of things that happened that were outside of your control?",
    "In the last month, how often have you felt difficulties were piling up so high that you could not overcome them?"
];

// Store responses
const answers = reactive({ impact: "" });
questions.forEach((_, index) => answers[`q${index + 1}`] = null);

// Stress Severity Levels
const severityLevels = [
    { min: 0, max: 13, label: "Low Stress" },
    { min: 14, max: 26, label: "Moderate Stress" },
    { min: 27, max: 40, label: "High Stress" },
];

// Compute total score
const totalScore = computed(() => {
    return Object.values(answers)
        .slice(0, questions.length)
        .reduce((sum, val) => sum + (parseInt(val) || 0), 0);
});

// Determine severity level
const severity = computed(() => {
    return (
        severityLevels.find(
            (level) => totalScore.value >= level.min && totalScore.value <= level.max
        )?.label || "Unknown"
    );
});

// Submit function
const submitStressAssessment = async () => {
    if (isLoading.value) return;

    const unanswered = Object.values(answers).slice(0, questions.length).some(val => val === null);
    if (unanswered || !answers.impact) {
        alert("Please answer all questions and select an impact level before submitting.");
        return;
    }

    isLoading.value = true;

    try {
        router.post('/assessment/stress/store', {
            user_id: page.props.auth?.user?.id,
            responses: Object.values(answers).slice(0, questions.length),
            impact: answers.impact,
            total_score: totalScore.value,
            severity: severity.value
        }, {
            replace: true,
            onSuccess: () => {
                isLoading.value = false;
                router.get('/assessment/stress/results');
            },
            onError: () => {
                isLoading.value = false;
                alert("Failed to submit assessment. Please try again.");
            }
        });

    } catch (error) {
        console.error("Error submitting assessment:", error);
        alert("Failed to submit assessment. Please try again.");
        isLoading.value = false;
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Stress Assessment" />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center">
            <div class="w-full max-w-4xl bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-300 dark:border-gray-700">

                <!-- Reusable Header -->
                <Header title="Perceived Stress Questionnaire" subtitle="In the last month, how often have you experienced the following?" />

                <div class="p-8 text-gray-900 dark:text-gray-100">

                    <!-- Stress Questions -->
                    <div class="space-y-6">
                        <div v-for="(question, index) in questions" :key="index" class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <label class="block font-medium text-lg text-gray-800 dark:text-gray-200">
                                {{ index + 1 }}. {{ question }}
                            </label>
                            <div class="flex gap-6 mt-2">
                                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <input type="radio" :value="0" v-model="answers[`q${index + 1}`]" class="form-radio" />
                                    Never
                                </label>
                                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <input type="radio" :value="1" v-model="answers[`q${index + 1}`]" class="form-radio" />
                                    Almost Never
                                </label>
                                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <input type="radio" :value="2" v-model="answers[`q${index + 1}`]" class="form-radio" />
                                    Sometimes
                                </label>
                                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <input type="radio" :value="3" v-model="answers[`q${index + 1}`]" class="form-radio" />
                                    Fairly Often
                                </label>
                                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <input type="radio" :value="4" v-model="answers[`q${index + 1}`]" class="form-radio" />
                                    Very Often
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Impact Level -->
                    <div class="mt-8 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <label class="block font-medium text-lg text-gray-800 dark:text-gray-200">
                            How difficult have these problems made it for you to function in daily life?
                        </label>
                        <div class="flex gap-6 mt-2">
                            <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                <input type="radio" value="Not difficult at all" v-model="answers.impact" class="form-radio" />
                                Not difficult at all
                            </label>
                            <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                <input type="radio" value="Somewhat difficult" v-model="answers.impact" class="form-radio" />
                                Somewhat difficult
                            </label>
                            <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                <input type="radio" value="Very difficult" v-model="answers.impact" class="form-radio" />
                                Very difficult
                            </label>
                            <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                <input type="radio" value="Extremely difficult" v-model="answers.impact" class="form-radio" />
                                Extremely difficult
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button @click="submitStressAssessment"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition">
                            {{ isLoading ? 'Submitting...' : 'Submit Assessment' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
