<script setup>
import { ref, nextTick } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
});

const isMenuOpen = ref(false);
const activeSection = ref('home');
const contactSection = ref(null); // Reference to the contact section

const menuLinks = [
  { name: 'Home', section: 'home' },
  { name: 'About', section: 'about' },
  { name: 'Resources', section: 'resources' },
  { name: 'Contact', section: 'contact' },
];

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};

const scrollToSection = (section) => {
  activeSection.value = section;

  nextTick(() => {
    if (section === 'contact' && contactSection.value) {
      contactSection.value.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });

  isMenuOpen.value = false; // Close mobile menu after clicking
};
const form = useForm({
  name: '',
  email: '',
  message: '',
});

const submitForm = () => {
  form.post(route('contact.submit'), {
    onSuccess: () => {
      Swal.fire({
        icon: 'success',
        title: 'Message Sent!',
        text: 'Your message has been sent successfully. We will get back to you soon!',
        confirmButtonColor: '#facc15', // Yellow button
      });

      form.reset();
    },
    onError: (errors) => {
      Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: 'Please check your inputs and try again.',
        confirmButtonColor: '#f87171', // Red button
      });
    },
  });
};
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-900 text-white">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 top-0 bg-gray-900 shadow-md py-4 px-6 flex justify-between items-center">
      <h1 class="text-3xl font-bold text-white">Mental Health App</h1>

      <ul class="hidden md:flex space-x-6">
        <li v-for="link in menuLinks" :key="link.name">
          <button @click="scrollToSection(link.section)" class="text-white hover:text-yellow-400 transition-all">
            {{ link.name }}
          </button>
        </li>
      </ul>

      <div class="hidden md:flex space-x-4">
        <template v-if="canLogin">
          <Link :href="route('login')" class="bg-white text-gray-900 px-4 py-2 rounded-full hover:bg-yellow-400">Log in</Link>
          <Link v-if="canRegister" :href="route('register')" class="bg-white text-gray-900 px-4 py-2 rounded-full hover:bg-yellow-400">Register</Link>
        </template>
      </div>

      <button @click="toggleMenu" class="md:hidden text-white text-2xl">☰</button>
    </nav>

    <!-- Mobile Menu -->
    <transition name="slide-fade">
      <div v-if="isMenuOpen" class="md:hidden bg-gray-800 shadow-md absolute w-full z-10 py-4 top-16">
        <ul class="flex flex-col space-y-2 px-6">
          <li v-for="link in menuLinks" :key="link.name">
            <button @click="scrollToSection(link.section)" class="block text-white hover:text-yellow-400 py-2">
              {{ link.name }}
            </button>
          </li>
        </ul>
      </div>
    </transition>

    <!-- Hero Section -->
    <div v-if="activeSection === 'home'" class="flex flex-col md:flex-row items-center justify-center flex-grow text-center md:text-left px-6 py-32 mt-16">
      <div class="md:w-1/2">
        <p class="uppercase tracking-widest text-lg text-yellow-300">Your Mental Health Matters</p>
        <h2 class="text-6xl font-extrabold text-white leading-tight">Take Control of Your Well-Being</h2>
        <p class="text-xl text-gray-200 mt-4">Start your mental health screening today and gain insights into your well-being.</p>
        <Link href="/register" class="mt-6 inline-block bg-white text-gray-900 px-6 py-3 rounded-full text-lg font-semibold hover:bg-yellow-400 transition-all">Start Screening</Link>
      </div>
      <div class="md:w-1/2 mt-8 md:mt-0 flex justify-center">
        <img src="https://aestheticsjournal.com/wp-content/uploads/2024/10/3-1.jpg" alt="Mental Health Illustration" class="w-full max-w-lg mx-auto rounded-lg shadow-lg">
      </div>
    </div>

    <!-- Contact Section -->
<div v-if="activeSection === 'contact'" class="min-h-screen flex flex-col md:flex-row items-center bg-gray-900 text-white px-6 py-16 md:py-32">
  <div class="md:w-1/2 hidden md:block">
    <img src="https://source.unsplash.com/600x500/?help,support" alt="Contact Background" class="w-full rounded-lg shadow-lg">
  </div>
  <div class="md:w-1/2 bg-gray-800 text-white rounded-lg shadow-lg p-8 max-w-lg mx-auto">
    <h2 class="text-3xl font-bold bg-yellow-400 text-gray-900 px-4 py-2 rounded-t-lg">Contact Us</h2>
    <p class="mt-4">
      For further questions, including partnership opportunities, please email
      <a href="mailto:johnmichaelvincentbaldon040603@gmail.com" class="text-yellow-400 font-semibold">johnmichaelvincentbaldon040603@gmail.com</a>
      or use our contact form.
    </p>

    <form @submit.prevent="submitForm" class="mt-6">
      <div>
        <label class="block text-sm font-semibold">Full Name</label>
        <input v-model="form.name" type="text" class="w-full border-b-2 border-yellow-400 focus:border-yellow-500 bg-transparent outline-none py-2" placeholder="Your Full Name">
        <p v-if="form.errors.name" class="text-red-400 text-sm mt-1">{{ form.errors.name }}</p>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-semibold">Email</label>
        <input v-model="form.email" type="email" class="w-full border-b-2 border-yellow-400 focus:border-yellow-500 bg-transparent outline-none py-2" placeholder="Your Email">
        <p v-if="form.errors.email" class="text-red-400 text-sm mt-1">{{ form.errors.email }}</p>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-semibold">How can we help you?</label>
        <textarea v-model="form.message" class="w-full border-b-2 border-yellow-400 focus:border-yellow-500 bg-transparent outline-none py-2" rows="4" placeholder="Describe your problem in at least 250 characters"></textarea>
        <p v-if="form.errors.message" class="text-red-400 text-sm mt-1">{{ form.errors.message }}</p>
      </div>

      <button type="submit" :disabled="form.processing" class="mt-6 w-full bg-yellow-400 text-gray-900 px-4 py-2 rounded-full hover:bg-yellow-500 transition-all">
        {{ form.processing ? 'Sending...' : 'Send Message' }}
      </button>
    </form>
  </div>
</div>
  </div>

</template>

<style>
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
.animate-fade-in {
  animation: fadeIn 1s ease-in-out;
}

.slide-fade-enter-active, .slide-fade-leave-active {
  transition: opacity 0.5s, transform 0.5s;
}
.slide-fade-enter, .slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
