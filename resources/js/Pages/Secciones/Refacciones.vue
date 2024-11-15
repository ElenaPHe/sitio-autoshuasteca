<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';

const props = defineProps({
    refacciones: Object,
});

const isContentLoaded = ref(false);
const selectTipo = ref(''); // Estado para el filtro tipoKit

onMounted(() => {
    setTimeout(() => {
        isContentLoaded.value = true;
    }, 300);
});

// Computed property para filtrar y ordenar los autos
const filteredRefaccion = computed(() => {
    let filtered = props.refacciones;

    // Filtrado por marca
    if (selectTipo.value !== '') {
        filtered = filtered.filter(refa => refa.tipoRefaccion === selectTipo.value);
    }

    return filtered;
});

function formatKm(value) {
    if (value == null) return '';
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function formatPrice(value) {
    if (value == null) return '';
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


console.log(props.refacciones);
</script>

<template>
  <Head title="Refacciones" />

  <UserLayout>
    <div class="relative min-h-screen bg-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2
          :class="[
            'text-4xl sm:text-5xl font-bold mb-12 text-center transition-all duration-1000 ease-out font-vwheadbold text-gray-800',
            { 'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded }
          ]"
        >
          Refacciones
        </h2>

        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
          <h3 class="text-2xl font-vwheadbold text-gray-800 mb-6">Filtros</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="space-y-2">
              <label for="marca" class="block text-sm font-medium text-gray-700">Tipo Refacción:</label>
              <select
                v-model="selectTipo"
                id="marca"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
              >
                <option value="">Todas las refacciones</option>
                <option value="Unico">Único</option>
                <option value="Kit">Kit</option>
              </select>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <Link
            v-for="infoSemi in filteredRefaccion"
            :key="infoSemi.id"
            :href="route('refacciones.show', infoSemi.id)"
            class="block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300"
          >
            <div class="flex flex-col h-full">
              <div class="w-full aspect-[4/3] overflow-hidden relative">
                <img
                  :src="`/storage/${infoSemi.imagen}`"
                  :alt="infoSemi.imagen"
                  class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                />
              </div>
              <div class="flex-1 p-6">
                <h3 class="text-2xl font-vwheadbold text-gray-800 mb-2">
                  {{ infoSemi.infoGeneral.marca }} {{ infoSemi.infoGeneral.modelo }}
                  <span class="text-xl font-vwheadlight">{{ infoSemi.infoGeneral.year }}</span>
                </h3>
                <p class="text-lg font-vwheadlight text-gray-600 mb-4">{{ infoSemi.nombre }}</p>
                <div class="mt-auto">
                  <p class="text-sm font-vwheadlight text-gray-500">Precio</p>
                  <p class="text-2xl font-vwheadbold text-indigo-600">
                    ${{ formatPrice(infoSemi.infoGeneral.precio) }}
                  </p>
                </div>
              </div>
            </div>
          </Link>
        </div>
      </div>
    </div>
  </UserLayout>
</template>

<style scoped></style>
