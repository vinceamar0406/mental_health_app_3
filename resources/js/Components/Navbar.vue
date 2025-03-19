<template>
    <nav class="fixed w-full z-50 top-0 bg-gray-900 shadow-md py-4 px-6 flex justify-between items-center">
      <h1 class="text-3xl font-bold text-white">PRMSU Mental Health App</h1>

      <!-- Desktop Navigation -->
      <ul class="hidden md:flex space-x-6">
        <li v-for="link in menuLinks" :key="link.name">
          <button
            @click="scrollToSection(link.section)"
            class="transition-all"
            :class="{
              'text-yellow-400 font-bold': activeSection === link.section,
              'text-white hover:text-yellow-400': activeSection !== link.section
            }"
          >
            {{ link.name }}
          </button>
        </li>
      </ul>

      <!-- Login/Register Buttons -->
      <div class="hidden md:flex space-x-4">
        <template v-if="canLogin">
          <Link :href="route('login')" class="bg-white text-gray-900 px-4 py-2 rounded-full hover:bg-yellow-400">Log in</Link>
          <Link v-if="canRegister" :href="route('register')" class="bg-white text-gray-900 px-4 py-2 rounded-full hover:bg-yellow-400">Register</Link>
        </template>
      </div>

      <!-- Mobile Menu Button -->
      <button @click="toggleMenu" class="md:hidden text-white text-2xl" aria-label="Open Menu">☰</button>

      <!-- Mobile Dropdown Menu -->
      <transition name="slide-fade">
        <div v-if="isMenuOpen" class="md:hidden bg-gray-800 shadow-md absolute w-full z-10 py-4 top-16">
          <ul class="flex flex-col space-y-2 px-6">
            <li v-for="link in menuLinks" :key="link.name">
              <button
                @click="scrollToSection(link.section)"
                class="block py-2 transition-all"
                :class="{
                  'text-yellow-400 font-bold': activeSection === link.section,
                  'text-white hover:text-yellow-400': activeSection !== link.section
                }"
              >
                {{ link.name }}
              </button>
            </li>
          </ul>
        </div>
      </transition>
    </nav>
  </template>

  <script setup>
  import { ref, defineProps, defineEmits, nextTick, onMounted } from 'vue';
  import { Link } from '@inertiajs/vue3';

  defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
  });

  const isMenuOpen = ref(false);
  const activeSection = ref('home'); // Default to home

  const menuLinks = [
    { name: 'Home', section: 'home' },
    { name: 'About', section: 'about' },
    { name: 'Resources', section: 'resources' },
    { name: 'Contact', section: 'contact' },
  ];

  const emit = defineEmits(['scrollTo']);

  const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
  };

  const scrollToSection = (section) => {
    activeSection.value = section;
    emit('scrollTo', section);
    isMenuOpen.value = false; // Close mobile menu after clicking
  };

  // Detect scroll position and update active section
  const updateActiveSection = () => {
    const sections = menuLinks.map(link => document.getElementById(link.section));
    let currentSection = 'home';

    sections.forEach(section => {
      if (section && window.scrollY >= section.offsetTop - 100) {
        currentSection = section.id;
      }
    });

    activeSection.value = currentSection;
  };

  // Listen to scroll events
  onMounted(() => {
    window.addEventListener('scroll', updateActiveSection);
  });
  </script>

  <style>
  /* Add smooth transition for active state */
  button {
    transition: color 0.3s, font-weight 0.3s;
  }
  </style>
