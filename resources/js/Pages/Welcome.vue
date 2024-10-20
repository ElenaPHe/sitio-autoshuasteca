<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps({
    inicios: Object,
});

const isContentLoaded = ref(false);

onMounted(() => {
  // Add a small delay to trigger the load animation
  setTimeout(() => {
    isContentLoaded.value = true;
  }, 300);
});
</script>

<template>
  <Head title="Home" />

  <UserLayout>
    <div class="relative h-screen" v-for="info in inicios" :key="info.id">
      <!-- <div class="bg-image h-3/4  bg-cover bg-center" style=" background-image: url('https://vw-huasteca.com.mx/Assets/ModelosNuevos/PortaHome/web_1920x720.jpg');"> -->
        <div class="bg-image h-3/4  bg-cover bg-center" :style="` background-image: url('/storage/${info.imagen}'); `">
        <!-- Contenido superpuesto en la imagen -->
        <!-- <div class="absolute inset-0 flex items-center justify-center">
          <h1 :class="[
            'text-6xl font-bold text-white shadow-lg transition-all duration-1000 ease-out',
            {'opacity-0 translate-y-[-20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded}
          ]">
            Home
          </h1>
        </div> -->
      </div>

      <!-- Contenido adicional -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 font-vwtext">
        <h2 :class="[
          'text-3xl font-bold mb-4 transition-all duration-1000 ease-out font-vwheadbold',
          {'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded}
        ]">
          Autos de la Huasteca
        </h2>
        <p :class="[
          'text-lg transition-all duration-1000 ease-out delay-200 font-vwheadlight',
          {'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded}
        ]">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </p>
      </div>

      <div class="container mx-auto py-12">
        <h2 class="text-3xl font-bold text-center mb-8">Descubre todas las promociones</h2>

      </div>

    </div>

  </UserLayout>
</template>

<style scoped>
/* Puedes agregar estilos adicionales aquí si es necesario */
</style>
