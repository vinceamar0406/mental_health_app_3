<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Header from '@/Components/Header.vue'; // Import the reusable header
import { Head, router, usePage } from '@inertiajs/vue3';
import { ref, computed, reactive } from 'vue';

const page = usePage();
const isLoading = ref(false);

// User's responses
const answers = reactive({
    q1: null, q2: null, q3: null, q4: null, q5: null, q6: null, q7: null, impact: ""
});

// GAD-7 Severity Levels
const severityLevels = [
    { min: 0, max: 4, label: "Minimal Anxiety" },
    { min: 5, max: 9, label: "Mild Anxiety" },
    { min: 10, max: 14, label: "Moderate Anxiety" },
    { min: 15, max: 21, label: "Severe Anxiety" },
];

// Compute total score
const totalScore = computed(() => {
    return Object.values(answers).slice(0, 7).reduce((sum, val) => sum + (parseInt(val) || 0), 0);
});

// Determine severity
const severity = computed(() => {
    return severityLevels.find(level => totalScore.value >= level.min && totalScore.value <= level.max)?.label || "Unknown";
});

// Submit function
const submitAssessment = async () => {
    if (isLoading.value) return;

    const unanswered = Object.values(answers).slice(0, 7).some(val => val === null);
    if (unanswered || !answers.impact) {
        alert("Please answer all questions and select an impact level before submitting.");
        return;
    }

    isLoading.value = true;

    try {
        router.post('/assessment/anxiety/store', {
            user_id: page.props.auth?.user?.id,
            responses: Object.values(answers).slice(0, 7),
            impact: answers.impact,
            total_score: totalScore.value,
            severity: severity.value
        }, {
            replace: true,
            onSuccess: () => {
                isLoading.value = false;
                router.get('/assessment/anxiety/results');
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
        <Head title="Anxiety Assessment" />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center">
            <div class="w-full max-w-4xl bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-300 dark:border-gray-700">

                <!-- Reusable Header -->
                <Header title="GAD-7 Anxiety Assessment" subtitle="Over the last two weeks, how often have you been bothered by the following problems?" />

                <div class="p-8 text-gray-900 dark:text-gray-100">

                    <!-- GAD-7 Questions -->
                    <div class="space-y-6">
                        <div v-for="(question, index) in [
                            'Feeling nervous, anxious, or on edge',
                            'Not being able to stop or control worrying',
                            'Worrying too much about different things',
                            'Trouble relaxing',
                            'Being so restless that it is hard to sit still',
                            'Becoming easily annoyed or irritable',
                            'Feeling afraid, as if something awful might happen'
                        ]" :key="index" class="p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <label class="block font-medium text-lg text-gray-800 dark:text-gray-200">
                                {{ index + 1 }}. {{ question }}
                            </label>
                            <div class="flex gap-6 mt-2">
                                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <input type="radio" :value="0" v-model="answers[`q${index + 1}`]" class="form-radio" />
                                    Not at all
                                </label>
                                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <input type="radio" :value="1" v-model="answers[`q${index + 1}`]" class="form-radio" />
                                    Several days
                                </label>
                                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <input type="radio" :value="2" v-model="answers[`q${index + 1}`]" class="form-radio" />
                                    More than half the days
                                </label>
                                <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300">
                                    <input type="radio" :value="3" v-model="answers[`q${index + 1}`]" class="form-radio" />
                                    Nearly every day
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
                        <button @click="submitAssessment"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg text-lg font-semibold hover:bg-blue-700 transition">
                            {{ isLoading ? 'Submitting...' : 'Submit Assessment' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
