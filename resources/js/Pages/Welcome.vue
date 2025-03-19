<script setup>
import { ref, nextTick, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import Navbar from '@/Components/Navbar.vue';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
});

const activeSection = ref('home');

const scrollToSection = (section) => {
  activeSection.value = section;
  nextTick(() => {
    const target = document.getElementById(section);
    if (target) {
      window.scrollTo({
        top: target.offsetTop - 80, // Adjust for fixed navbar
        behavior: 'smooth'
      });
    }
  });
};

const updateActiveSection = () => {
  const sections = ['home', 'about', 'resources', 'contact'];
  let currentSection = 'home';

  sections.forEach((section) => {
    const el = document.getElementById(section);
    if (el && window.scrollY >= el.offsetTop - 100) {
      currentSection = section;
    }
  });

  activeSection.value = currentSection;
};

onMounted(() => {
  window.addEventListener('scroll', updateActiveSection);
});

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
        confirmButtonColor: '#facc15',
      });
      form.reset();
    },
    onError: () => {
      Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: 'Please check your inputs and try again.',
        confirmButtonColor: '#f87171',
      });
    },
  });
};
</script>

<template>
  <div class="min-h-screen flex flex-col bg-gray-900 text-white">
    <!-- Navbar Component -->
    <Navbar :canLogin="canLogin" :canRegister="canRegister" @scrollTo="scrollToSection" />

    <!-- Sections -->
    <section id="home" class="min-h-screen flex flex-col md:flex-row items-center justify-center text-center md:text-left px-6 py-32 mt-16">
      <div class="md:w-1/2">
        <p class="uppercase tracking-widest text-lg text-yellow-300">Your Mental Health Matters</p>
        <h2 class="text-6xl font-extrabold text-white leading-tight">Take Control of Your Well-Being</h2>
        <p class="text-xl text-gray-200 mt-4">Start your mental health screening today and gain insights into your well-being.</p>
        <Link :href="route('register')" class="mt-6 inline-block bg-white text-gray-900 px-6 py-3 rounded-full text-lg font-semibold hover:bg-yellow-400 transition-all">
          Start Screening
        </Link>
      </div>
      <div class="md:w-1/2 mt-8 md:mt-0 flex justify-center">
        <img src="https://aestheticsjournal.com/wp-content/uploads/2024/10/3-1.jpg" alt="Mental Health Illustration" class="w-full max-w-lg mx-auto rounded-lg shadow-lg">
      </div>
    </section>

    <!-- About Section -->
<div id="about" class="min-h-screen flex flex-col items-center text-center bg-gray-900 text-white px-6 py-16">
  <h2 class="text-4xl font-extrabold text-yellow-400 animate-fade-in">About Us</h2>

  <p class="text-lg text-gray-300 mt-4 max-w-3xl animate-fade-in delay-200">
    At <span class="text-yellow-300 font-semibold">PRMSU Mental Health App</span>, we believe that mental well-being is just as important as physical health.
    Our mission is to empower individuals with <span class="font-semibold">accessible assessments, self-help resources, and expert guidance</span> to take charge of their mental health.
  </p>

  <!-- Why Choose Us Section -->
  <div class="mt-12 w-full max-w-3xl text-center animate-slide-in">
    <h3 class="text-2xl font-semibold text-yellow-300">Why Choose Us?</h3>
    <ul class="mt-6 space-y-4 text-lg">
      <li class="flex items-center justify-center">
        <span class="text-yellow-400 text-2xl">✔</span>
        <span class="ml-3">Science-backed mental health screenings</span>
      </li>
      <li class="flex items-center justify-center">
        <span class="text-yellow-400 text-2xl">✔</span>
        <span class="ml-3">User-friendly and confidential platform</span>
      </li>
      <li class="flex items-center justify-center">
        <span class="text-yellow-400 text-2xl">✔</span>
        <span class="ml-3">Free access to valuable mental health resources</span>
      </li>
      <li class="flex items-center justify-center">
        <span class="text-yellow-400 text-2xl">✔</span>
        <span class="ml-3">24/7 support and expert guidance</span>
      </li>
    </ul>
  </div>

  <!-- Call-to-Action Button -->
  <a href="#resources"
     class="mt-8 inline-block bg-yellow-400 text-gray-900 px-6 py-3 rounded-full text-lg font-semibold hover:bg-yellow-500 transition-all transform hover:scale-105 focus:ring-4 focus:ring-yellow-300 focus:outline-none"
     onclick="document.getElementById('resources').scrollIntoView({ behavior: 'smooth' }); return false;">
    Explore Resources
  </a>
</div>



  <!-- Meet the Team Section -->
  <div class="mt-16 w-full">
    <h3 class="text-3xl font-bold text-yellow-400 text-center">Meet Our Team</h3>
    <p class="text-gray-300 mt-2 max-w-2xl mx-auto text-center">
      Our dedicated team of professionals is committed to providing the best mental health support.
    </p>

    <!-- Team Members Grid -->
    <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-6xl mx-auto">
      <!-- Team Member 1 -->
      <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-center">
        <img src="/images/2x2.jpg" class="w-32 h-32 mx-auto rounded-full shadow-lg" alt="Your Name">
        <h4 class="text-xl font-semibold text-yellow-300 mt-4">John Michael Vincent Baldon</h4>
        <p class="text-gray-400">Web Developer</p>
      </div>

      <!-- Team Member 2 -->
      <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-center">
        <img src="https://source.unsplash.com/150x150/?woman,face" class="w-24 h-24 mx-auto rounded-full shadow-md" alt="Team Member">
        <h4 class="text-xl font-semibold text-yellow-300 mt-4">Jane Smith</h4>
        <p class="text-gray-400">Licensed Therapist & Counselor</p>
      </div>

      <!-- Team Member 3 -->
      <div class="bg-gray-800 p-6 rounded-lg shadow-lg text-center">
        <img src="https://source.unsplash.com/150x150/?doctor,face" class="w-24 h-24 mx-auto rounded-full shadow-md" alt="Team Member">
        <h4 class="text-xl font-semibold text-yellow-300 mt-4">Michael Brown</h4>
        <p class="text-gray-400">Psychologist & Researcher</p>
      </div>
    </div>
  </div>



    <!-- Resources Section -->
<section id="resources" class="min-h-screen bg-gray-900 text-white px-6 py-16">
  <div class="max-w-6xl mx-auto text-center">
    <h2 class="text-4xl font-extrabold text-yellow-400">Mental Health Resources</h2>
    <p class="text-lg text-gray-300 mt-4 max-w-3xl mx-auto">
      Access evidence-based mental health guides, self-help articles, and expert advice to support your well-being.
    </p>
  </div>

  <!-- Section Image -->
  <div class="mt-10 flex justify-center">
    <img src="https://static.vecteezy.com/system/resources/previews/003/332/223/non_2x/mental-health-awareness-day-concept-free-vector.jpg"
      alt="Mental Health Awareness"
      class="w-full max-w-md rounded-lg shadow-lg">
  </div>

  <!-- Resource Categories -->
  <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
    <!-- Articles -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg hover:bg-gray-700 transition">
      <h3 class="text-xl font-semibold text-yellow-300">📖 Mental Health Articles</h3>
      <p class="text-gray-400 mt-2">
        Read expert-written articles on anxiety, depression, and stress management.
      </p>
      <a href="#" class="mt-4 inline-block text-yellow-400 font-semibold hover:text-yellow-500 transition">
        Explore Articles →
      </a>
    </div>

    <!-- Videos -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg hover:bg-gray-700 transition">
      <h3 class="text-xl font-semibold text-yellow-300">🎥 Video Library</h3>
      <p class="text-gray-400 mt-2">
        Watch engaging videos on coping strategies and mental wellness tips.
      </p>
      <a href="#" class="mt-4 inline-block text-yellow-400 font-semibold hover:text-yellow-500 transition">
        Watch Now →
      </a>
    </div>

    <!-- Self-Help Tools -->
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg hover:bg-gray-700 transition">
      <h3 class="text-xl font-semibold text-yellow-300">🛠 Self-Help Toolkit</h3>
      <p class="text-gray-400 mt-2">
        Download workbooks and exercises designed to improve mental health.
      </p>
      <a href="#" class="mt-4 inline-block text-yellow-400 font-semibold hover:text-yellow-500 transition">
        Download Resources →
      </a>
    </div>
  </div>

  <!-- Call to Action -->
  <div class="mt-16 text-center">
    <a href="#contact"
   class="mt-8 inline-block bg-yellow-400 text-gray-900 px-6 py-3 rounded-full text-lg font-semibold hover:bg-yellow-500 transition-all transform hover:scale-105 focus:ring-4 focus:ring-yellow-300 focus:outline-none"
   onclick="document.getElementById('contact').scrollIntoView({ behavior: 'smooth' }); return false;">
   Get Support Now
</a>
  </div>
</section>


    <!-- Contact Section -->
    <section id="contact" class="min-h-screen flex flex-col md:flex-row items-center bg-gray-900 text-white px-6 py-16 md:py-32">
      <div class="md:w-1/2 bg-gray-800 text-white rounded-lg shadow-lg p-8 max-w-lg mx-auto">
        <h2 class="text-3xl font-bold bg-yellow-400 text-gray-900 px-4 py-2 rounded-t-lg">Contact Us</h2>
        <p class="mt-4">
          For further questions, including partnership opportunities, please email
          <a href="mailto:mentalhealthprmsu@gmail.com" class="text-yellow-400 font-semibold">
            mentalhealthprmsu@gmail.com
          </a>
          or use our contact form.
        </p>
        <form @submit.prevent="submitForm" class="mt-6">
          <div>
            <label for="name" class="block text-sm font-semibold">Full Name</label>
            <input id="name" v-model="form.name" type="text" class="w-full border-b-2 border-yellow-400 bg-transparent py-2 outline-none" placeholder="Your Full Name">
            <p v-if="form.errors.name" class="text-red-400 text-sm mt-1">{{ form.errors.name }}</p>
          </div>

          <div class="mt-4">
            <label for="email" class="block text-sm font-semibold">Email</label>
            <input id="email" v-model="form.email" type="email" class="w-full border-b-2 border-yellow-400 bg-transparent py-2 outline-none" placeholder="Your Email">
            <p v-if="form.errors.email" class="text-red-400 text-sm mt-1">{{ form.errors.email }}</p>
          </div>

          <div class="mt-4">
            <label class="block text-sm font-semibold">How can we help you?</label>
            <textarea v-model="form.message" class="w-full border-b-2 border-yellow-400 bg-transparent py-2 outline-none" rows="4" placeholder="Describe your problem in at least 250 characters"></textarea>
            <p v-if="form.errors.message" class="text-red-400 text-sm mt-1">{{ form.errors.message }}</p>
          </div>

          <button type="submit" :disabled="form.processing" class="mt-6 w-full bg-yellow-400 text-gray-900 px-4 py-2 rounded-full hover:bg-yellow-500 transition-all">
            {{ form.processing ? 'Sending...' : 'Send Message' }}
          </button>
        </form>
      </div>
    </section>
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
</style>
