<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head,Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps({
    nuevos: Object,
});

const isContentLoaded = ref(false);

onMounted(() => {
    // Add a small delay to trigger the load animation
    setTimeout(() => {
        isContentLoaded.value = true;
    }, 300);
});

console.log(props.nuevos);
</script>

<template>
    <Head title="Autos Nuevos" />
    <UserLayout>
      <div class="relative min-h-screen bg-gray-100 pt-16 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2
            :class="[
              'text-5xl font-bold mb-12 text-center transition-all duration-1000 ease-out',
              { 'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded }
            ]"
          >
            <span class="font-vwheadlight">Autos </span>
            <span class="font-vwheadbold">Nuevos</span>
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div
              v-for="infoNuevo in nuevos"
              :key="infoNuevo.id"
              class="bg-white rounded-lg overflow-hidden shadow-lg transition-all duration-300 hover:shadow-xl group"
            >
              <Link :href="route('autosnuevos.show', infoNuevo.id)" class="block">
                <div class="relative aspect-[16/9] overflow-hidden">
                  <img
                    :src="`/storage/${infoNuevo.fotoAuto}`"
                    :alt="infoNuevo.infoGeneral.modelo"
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                  >
                  <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                  <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                    <h3 class="text-2xl font-bold mb-2">{{ infoNuevo.infoGeneral.eslogan }}</h3>
                    <p class="text-sm">{{ infoNuevo.infoGeneral.descripcionCorta }}</p>
                  </div>
                </div>
              </Link>
              <div class="p-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-xl font-semibold text-gray-800">{{ infoNuevo.modelo}} <br>
                        <span class="text-xl font-semibold text-gray-800">${{ infoNuevo.infoGeneral.precio}}</span>
                    </h1>

                  <Link
                    :href="route('autosnuevos.show', infoNuevo.id)"
                    class="bg-blue-600 text-white px-6 py-2 rounded-full font-medium hover:bg-blue-700 transition-colors duration-300"
                  >
                    Descúbrelo
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </UserLayout>
  </template>

<style scoped>
/* Puedes agregar estilos adicionales aquí si es necesario */
</style>
