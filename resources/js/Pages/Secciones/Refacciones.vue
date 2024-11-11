<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';

const props = defineProps({
    seminuevos: Array,
    marcasAuto: Array,
    yearsAutos: Array,
});

const isContentLoaded = ref(false);
const selectedMarca = ref(''); // Estado para la marca seleccionada
const selectedYear = ref(''); // Estado para el año seleccionado
const selectedTransmicion = ref('');
const sortOrder = ref(''); // Estado para el ordenamiento de precio
// const sortYear = ref(''); // Estado para el ordenamiento de año

onMounted(() => {
    setTimeout(() => {
        isContentLoaded.value = true;
    }, 300);
});

// Computed property para filtrar y ordenar los autos
const filteredSeminuevos = computed(() => {
    let filtered = props.seminuevos;

    // Filtrado por marca
    if (selectedMarca.value !== '') {
        filtered = filtered.filter(auto => auto.infoGeneral.marca === selectedMarca.value);
    }

    if (selectedYear.value !== '') {
        filtered = filtered.filter(auto => auto.infoGeneral.year === selectedYear.value);
    }

    if (selectedTransmicion.value !== '') {
        filtered = filtered.filter(auto => auto.infoGeneral.transmision === selectedTransmicion.value);
    }

    // Ordenamiento por precio
    if (sortOrder.value === 'asc') {
        filtered = filtered.slice().sort((a, b) => parseFloat(a.infoGeneral.precio) - parseFloat(b.infoGeneral.precio));
    } else if (sortOrder.value === 'desc') {
        filtered = filtered.slice().sort((a, b) => parseFloat(b.infoGeneral.precio) - parseFloat(a.infoGeneral.precio));
    } else if (sortOrder.value === "yearAsc") {
        filtered = filtered.slice().sort((a, b) => parseFloat(a.infoGeneral.year) - parseFloat(b.infoGeneral.year));
    } else if (sortOrder.value === "yearDesc") {
        filtered = filtered.slice().sort((a, b) => parseFloat(b.infoGeneral.year) - parseFloat(a.infoGeneral.year));
    } else if (sortOrder.value === "kiloAsc") {
        filtered = filtered.slice().sort((a, b) => parseFloat(a.infoGeneral.kilometraje) - parseFloat(b.infoGeneral.kilometraje));
    } else if (sortOrder.value === "kiloDesc") {
        filtered = filtered.slice().sort((a, b) => parseFloat(b.infoGeneral.kilometraje) - parseFloat(a.infoGeneral.kilometraje));
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

</script>

<template>

    <Head title="Refacciones" />

    <UserLayout>



        <div class="relative min-h-screen pt-8 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <h2 :class="[
                    'text-4xl sm:text-5xl font-bold mb-12 text-center transition-all duration-1000 ease-out font-vwheadbold text-gray-800',
                    { 'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded }
                ]">
                    Refacciones
                </h2>

                <div class="bg-white shadow-lg p-6 mb-8">
                    <h3 class="text-2xl font-vwheadbold text-gray-800 mb-6">Filtros</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label for="marca" class="block text-sm font-medium text-gray-700">Marca:</label>
                            <select v-model="selectedMarca" id="marca" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-sm">
                                <option value="">Todas las marcas</option>
                                <option v-for="marca in marcasAuto" :key="marca" :value="marca">{{ marca }}</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="year" class="block text-sm font-medium text-gray-700">Año:</label>
                            <select v-model="selectedYear" id="year" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-sm">
                                <option value="">Todos los años</option>
                                <option v-for="year in yearsAutos" :key="year" :value="year">{{ year }}</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="transmision" class="block text-sm font-medium text-gray-700">Transmisión:</label>
                            <select v-model="selectedTransmicion" id="transmision" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-sm">
                                <option value="">Todas</option>
                                <option value="Automatica">Automática</option>
                                <option value="Standard">Estándar</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="sortOrder" class="block text-sm font-medium text-gray-700">Ordenar por:</label>
                            <select v-model="sortOrder" id="sortOrder" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-sm">
                                <option value="">Seleccionar</option>
                                <option value="asc">Menor precio</option>
                                <option value="desc">Mayor precio</option>
                                <option value="yearAsc">Año (ascendente)</option>
                                <option value="yearDesc">Año (descendente)</option>
                                <option value="kiloAsc">Menor kilometraje</option>
                                <option value="kiloDesc">Mayor kilometraje</option>
                            </select>
                        </div>
                    </div>
                </div>



                <div class="space-y-6">
                    <Link v-for="infoSemi in filteredSeminuevos" :key="infoSemi.id"
                        :href="route('seminuevos.show', infoSemi.id)"
                        class="block bg-white rounded-sm overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                    <div class="flex flex-col md:flex-row">
                        <!-- Imagen del auto -->
                        <div class="w-full md:w-2/5 aspect-[4/3] overflow-hidden relative">
                            <img :src="`/storage/${infoSemi.fotoAuto}`" :alt="infoSemi.infoGeneral.title"
                                class="w-full h-full object-cover">
                        </div>

                        <!-- Información del auto -->
                        <div class="flex-1 p-6">
                            <div class="flex flex-col md:flex-row justify-between mb-4">
                                <h3 class="text-2xl font-vwheadbold text-gray-800">
                                    {{ infoSemi.infoGeneral.marca }} {{ infoSemi.infoGeneral.modelo }}
                                    <span class="text-xl font-vwheadlight">{{ infoSemi.infoGeneral.year }}</span>
                                </h3>
                            </div>
                            <div class="flex justify-items-end space-x-2">
                                <div>
                                    <p class="text-sm font-vwheadlight text-gray-500">Precio</p>
                                    <p class="text-lg font-vwheadlight">${{ formatPrice(infoSemi.infoGeneral.precio) }}
                                    </p>
                                    <p class="text-lg font-vwheadlight line-through">${{
                                        formatPrice(infoSemi.infoGeneral.precioAnterior) }}</p>
                                </div>
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
