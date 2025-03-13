<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    latest_result: Object,
    past_results: Array
});
</script>

<template>
  <div class="container">
    <h1>PTSD Assessment Results</h1>

    <!-- Latest Assessment -->
    <div v-if="latest_result">
      <h2>Latest Result</h2>
      <p><strong>Total Score:</strong> {{ latest_result.total_score }}</p>
      <p><strong>Severity Level:</strong> {{ latest_result.severity }}</p>
      <p><strong>Impact Level:</strong> {{ latest_result.impact }}</p>
    </div>
    <div v-else>
      <p>No PTSD assessments found.</p>
    </div>

    <!-- Past Assessments -->
    <h2>Past Assessments</h2>
    <ul v-if="past_results.length">
      <li v-for="(result, index) in past_results" :key="index">
        <p><strong>Date:</strong> {{ new Date(result.created_at).toLocaleDateString() }}</p>
        <p><strong>Score:</strong> {{ result.total_score }}</p>
        <p><strong>Severity:</strong> {{ result.severity }}</p>
      </li>
    </ul>
    <p v-else>No past PTSD assessments available.</p>
  </div>
</template>

<style scoped>
.container {
  max-width: 600px;
  margin: auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #f9f9f9;
}
</style>
