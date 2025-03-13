<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

// Props for authentication links
defineProps({
  canLogin: {
    type: Boolean,
    default: false,
  },
  canRegister: {
    type: Boolean,
    default: false,
  },
});

// State for mobile menu toggle
const isMenuOpen = ref(false);

const menuLinks = [
  { name: 'Home', route: '/' },
  { name: 'About', route: '/about' },
  { name: 'Resources', route: '/resources' },
  { name: 'Contact', route: '/contact' },
];

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-900 text-white">
    <!-- Navbar -->
    <nav class="w-full bg-gray-800 shadow-md py-4 px-6 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-indigo-400">Mental Health App</h1>

      <!-- Desktop Navigation Links -->
      <ul class="hidden md:flex space-x-6">
        <li v-for="link in menuLinks" :key="link.name">
          <Link :href="link.route" class="text-gray-300 hover:text-indigo-400">{{ link.name }}</Link>
        </li>
      </ul>

      <!-- Auth Links (Desktop) -->
      <div class="hidden md:flex space-x-4">
        <template v-if="canLogin">
          <Link
            :href="route('login')"
            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-gray-300 focus:outline-none focus-visible:ring-indigo-400"
          >
            Log in
          </Link>

          <Link
            v-if="canRegister"
            :href="route('register')"
            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-gray-300 focus:outline-none focus-visible:ring-indigo-400"
          >
            Register
          </Link>
        </template>
      </div>

      <!-- Mobile Menu Button -->
      <button @click="toggleMenu" class="md:hidden text-gray-300 focus:outline-none">
        ☰
      </button>
    </nav>

    <!-- Animated Mobile Dropdown Menu -->
    <transition
      enter-active-class="transform transition duration-300 ease-out opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transform transition duration-200 ease-in opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div v-if="isMenuOpen" class="md:hidden bg-gray-800 shadow-md absolute w-full z-10 py-4">
        <ul class="flex flex-col space-y-2 px-6">
          <li v-for="link in menuLinks" :key="link.name">
            <Link :href="link.route" class="block text-gray-300 hover:text-indigo-400 py-2">{{ link.name }}</Link>
          </li>
        </ul>
      </div>
    </transition>

    <!-- Hero Section -->
    <div class="flex flex-col md:flex-row items-center justify-center flex-grow text-center md:text-left px-6 py-12">
      <!-- Text Section -->
      <div class="md:w-1/2">
        <h2 class="text-4xl font-extrabold text-white">Take Control of Your Mental Health</h2>
        <p class="text-lg text-gray-400 mt-4">Start your mental health screening today and get insights into your well-being.</p>
        <Link href="/register" class="mt-6 inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-indigo-500">
          Start Screening
        </Link>
      </div>

      <!-- Illustration (Dark mode & Bigger Image) -->
      <div class="md:w-1/2 mt-8 md:mt-0 flex justify-center">
        <img src="https://aestheticsjournal.com/wp-content/uploads/2024/10/3-1.jpg" alt="Mental Health Illustration" class="w-full max-w-lg mx-auto rounded-lg shadow-lg">
      </div>
    </div>
  </div>
</template>
