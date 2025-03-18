<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
  reports: Array
});
</script>

<template>
  <Head title="Reports" />
  <AuthenticatedLayout>
    <div class="p-6">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Reports</h1>
      <p class="text-gray-600 dark:text-gray-400">View and manage reports.</p>

      <div v-if="reports.length">
        <ul>
          <li v-for="report in reports" :key="report.id">
            {{ report.title }} - {{ report.created_at }}
          </li>
        </ul>
      </div>
      <p v-else class="text-gray-500">No reports available.</p>
    </div>
  </AuthenticatedLayout>
</template>
