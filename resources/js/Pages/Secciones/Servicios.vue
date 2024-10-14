<script setup>
import { ref, onMounted } from 'vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';

const isContentLoaded = ref(false);

onMounted(() => {
  // Add a small delay to trigger the load animation
  setTimeout(() => {
    isContentLoaded.value = true;
  }, 300);
});
</script>

<template>
  <Head title="Nueva Sección" />

  <UserLayout>
    <div class="relative h-screen">
      <div class="bg-image h-3/4 bg-cover bg-center" style="background-image: url('https://vw-huasteca.com.mx/Assets/ModelosNuevos/PortaHome/web_1920x720.jpg');">
        <!-- Contenido superpuesto en la imagen -->
        <div class="absolute inset-0 flex items-center justify-center">
          <h1 :class="[
            'text-6xl font-bold text-white shadow-lg transition-all duration-1000 ease-out',
            {'opacity-0 translate-y-[-20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded}
          ]">
            Nueva Sección
          </h1>
        </div>
      </div>

      <!-- Contenido adicional -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 font-vwtext">
        <h2 :class="[
          'text-3xl font-bold mb-4 transition-all duration-1000 ease-out font-vwheadbold',
          {'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded}
        ]">
          Bienvenido a la Nueva Sección
        </h2>
        <p :class="[
          'text-lg transition-all duration-1000 ease-out delay-200 font-vwheadlight',
          {'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded}
        ]">
          Esta es una nueva sección con una imagen de fondo similar a la página de bienvenida. Puedes personalizar este contenido según tus necesidades.
        </p>
      </div>
      <div class="h-screen font-vwtext flex items-center justify-center bg-gray-100">
        <h1 class="text-4xl font-bold">Contenido Adicional</h1>
      </div>
    </div>
  </UserLayout>
</template>

<style scoped>
/* Puedes agregar estilos adicionales aquí si es necesario */
</style>
