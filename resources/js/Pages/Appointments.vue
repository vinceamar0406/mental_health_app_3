<template>
    <div class="p-6 bg-gray-100 min-h-screen">
      <!-- Return Button -->
      <Link :href="route('admin.home')"
            class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition">
        &larr; Return to Home
      </Link>

      <h1 class="text-2xl font-semibold mb-4">Appointments</h1>

      <!-- Search & Filter -->
      <div class="flex flex-col md:flex-row md:justify-between mb-4">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search by user name..."
          class="p-2 border rounded w-full md:w-1/3"
        />
      </div>

      <!-- Appointments Table (Desktop) -->
      <div class="hidden md:block">
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
          <thead class="bg-gray-200">
            <tr>
              <th class="p-3 text-left">User</th>
              <th class="p-3 text-left">Assessment Type</th>
              <th class="p-3 text-left">Status</th>
              <th class="p-3 text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="appointment in filteredAppointments" :key="appointment.id" class="border-t">
              <td class="p-3">{{ appointment.user.name }}</td>
              <td class="p-3">{{ appointment.assessment.type }}</td>
              <td class="p-3">
                <span class="px-2 py-1 rounded text-white" :class="statusClass(appointment.status)">
                  {{ appointment.status }}
                </span>
              </td>
              <td class="p-3 text-center">
                <div v-if="appointment.status === 'pending'">
                  <!-- Input for Scheduled Date -->
                  <input
                    v-model="appointment.scheduled_at"
                    type="datetime-local"
                    class="p-2 border rounded w-36 mb-2"
                    :min="minScheduledDate"
                  />
                  <button
                    @click="approveAppointment(appointment)"
                    class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mr-2"
                  >
                    Approve
                  </button>
                </div>
                <button
                  v-if="appointment.status === 'approved'"
                  @click="completeAppointment(appointment.id)"
                  class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"
                >
                  Complete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Appointments Cards (Mobile) -->
      <div class="md:hidden">
        <div v-for="appointment in filteredAppointments" :key="appointment.id" class="bg-white p-4 mb-3 rounded-lg shadow">
          <p><strong>User:</strong> {{ appointment.user.name }}</p>
          <p><strong>Assessment:</strong> {{ appointment.assessment.type }}</p>
          <p><strong>Status:</strong>
            <span class="px-2 py-1 rounded text-white" :class="statusClass(appointment.status)">
              {{ appointment.status }}
            </span>
          </p>
          <div class="mt-3">
            <div v-if="appointment.status === 'pending'">
              <!-- Mobile Input for Scheduled Date -->
              <input
                v-model="appointment.scheduled_at"
                type="datetime-local"
                class="p-2 border rounded w-full mb-2"
                :min="minScheduledDate"
              />
              <button
                @click="approveAppointment(appointment)"
                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 w-full mb-2"
              >
                Approve
              </button>
            </div>
            <button
              v-if="appointment.status === 'approved'"
              @click="completeAppointment(appointment.id)"
              class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 w-full"
            >
              Complete
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { Link } from "@inertiajs/vue3"; // Import Inertia Link component
  import { defineProps, ref, computed } from "vue";
  import axios from "axios";
  import { router } from "@inertiajs/vue3"; // Use Inertia's router for API calls

  // Receive appointments as a prop from Laravel
  const props = defineProps({
    appointments: Array,
  });

  const searchQuery = ref("");
  const minScheduledDate = ref(new Date().toISOString().slice(0, 16)); // Ensures only future dates can be selected

  // Filtered list based on search query
  const filteredAppointments = computed(() => {
    return props.appointments.filter((a) =>
      a.user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });

  // Status class mapping
  const statusClass = (status) => {
    return {
      pending: "bg-red-500",
      approved: "bg-blue-500",
      completed: "bg-green-500",
    }[status] || "bg-gray-500";
  };

  // Approve appointment
  const approveAppointment = async (appointment) => {
    try {
      const response = await axios.post(`/appointments/${appointment.id}/approve`, {
        scheduled_at: appointment.scheduled_at,  // Pass the scheduled_at field
      });
      router.reload(); // Refresh data using Inertia
    } catch (error) {
      console.error("Error approving appointment:", error);
    }
  };

  // Complete appointment
  const completeAppointment = async (id) => {
    try {
      const response = await axios.post(`/api/appointments/${id}/complete`);
      router.reload(); // Refresh data using Inertia
    } catch (error) {
      console.error("Error completing appointment:", error);
    }
  };
  </script>
