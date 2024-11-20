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

    <Head title="Autos Seminuevos" />

    <UserLayout>



        <div class="relative min-h-screen pt-8 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <h2 :class="[
                    'text-4xl sm:text-5xl font-bold mb-12 text-center transition-all duration-1000 ease-out font-vwheadbold text-gray-800',
                    { 'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded }
                ]">
                    Autos Seminuevos
                </h2>

                <div class="bg-white shadow-lg p-6 mb-8">
                    <h3 class="text-2xl font-vwheadbold text-gray-800 mb-6">Filtros</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label for="marca" class="block text-sm font-medium text-gray-700">Marca:</label>
                            <select v-model="selectedMarca" id="marca" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Todas las marcas</option>
                                <option v-for="marca in marcasAuto" :key="marca" :value="marca">{{ marca }}</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="year" class="block text-sm font-medium text-gray-700">Año:</label>
                            <select v-model="selectedYear" id="year" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Todos los años</option>
                                <option v-for="year in yearsAutos" :key="year" :value="year">{{ year }}</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="transmision" class="block text-sm font-medium text-gray-700">Transmisión:</label>
                            <select v-model="selectedTransmicion" id="transmision" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Todas</option>
                                <option value="Automatica">Automática</option>
                                <option value="Standard">Estándar</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="sortOrder" class="block text-sm font-medium text-gray-700">Ordenar por:</label>
                            <select v-model="sortOrder" id="sortOrder" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
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
                        :href="route('seminuevos.show', { id: infoSemi.id, marca: infoSemi.infoGeneral.marca.toUpperCase(), modelo: infoSemi.infoGeneral.modelo.replace(/\s+/g, '-').toUpperCase(), year: infoSemi.infoGeneral.year })"
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
                            <!-- Grid de especificaciones -->
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                                <!-- Kilometraje -->
                                <div class="flex items-center space-x-2">
                                    <svg class="h-10" fill="#001E50" version="1.1" id="Layer_1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        viewBox="0 0 512.00 512.00" xml:space="preserve" stroke="#001E50"
                                        stroke-width="0.00512">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g>
                                                <g>
                                                    <path
                                                        d="M256,51.2c-141.38,0-256,114.611-256,256c0,57.711,19.328,110.78,51.55,153.6h408.9C492.672,417.98,512,364.911,512,307.2 C512,165.811,397.38,51.2,256,51.2z M447.266,435.2H64.734C39.091,397.107,25.6,353.118,25.6,307.2 C25.6,180.156,128.956,76.8,256,76.8s230.4,103.356,230.4,230.4C486.4,353.118,472.909,397.107,447.266,435.2z">
                                                    </path>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path
                                                        d="M256,89.6c-7.074,0-12.8,5.726-12.8,12.8V128c0,7.074,5.726,12.8,12.8,12.8c7.074,0,12.8-5.726,12.8-12.8v-25.6 C268.8,95.326,263.074,89.6,256,89.6z">
                                                    </path>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path
                                                        d="M409.873,153.327c-5.001-5.001-13.107-5.001-18.108,0l-18.099,18.099c-5,5.001-5,13.099,0,18.099 c2.5,2.5,5.777,3.746,9.054,3.746c3.277,0,6.554-1.246,9.054-3.746l18.099-18.099 C414.874,166.426,414.874,158.327,409.873,153.327z">
                                                    </path>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path
                                                        d="M460.8,294.4h-25.6c-7.074,0-12.8,5.726-12.8,12.8s5.726,12.8,12.8,12.8h25.6c7.074,0,12.8-5.726,12.8-12.8 S467.874,294.4,460.8,294.4z">
                                                    </path>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path
                                                        d="M138.342,171.426l-18.099-18.099c-5.001-5.001-13.099-5.001-18.099,0c-5.001,5-5.001,13.099,0,18.099l18.099,18.099 c2.492,2.5,5.768,3.746,9.045,3.746c3.277,0,6.554-1.246,9.054-3.746C143.343,184.525,143.343,176.427,138.342,171.426z">
                                                    </path>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path
                                                        d="M76.8,294.4H51.2c-7.074,0-12.8,5.726-12.8,12.8S44.126,320,51.2,320h25.6c7.074,0,12.8-5.726,12.8-12.8 S83.874,294.4,76.8,294.4z">
                                                    </path>
                                                </g>
                                            </g>
                                            <g>
                                                <g>
                                                    <path
                                                        d="M289.894,271.974c-10.778-9.361-24.755-15.147-38.272-20.745c-24.738-10.249-134.733-32.282-156.536-36.591 c-5.103-1.007-10.214-0.427-14.754,1.459c-6.101,2.526-11.187,7.39-13.858,13.858c-4.668,11.273-0.734,24.277,9.404,31.07 c18.466,12.365,111.821,74.564,136.559,84.813c20.275,8.397,43.247,17.911,64.87,8.96c8.013-3.319,18.97-10.675,25.677-26.871 C311.62,307.072,306.85,286.677,289.894,271.974z M279.33,318.123c-2.867,6.929-6.929,10.982-11.827,13.013 c-11.827,4.898-28.552-2.031-45.278-8.96c-23.654-9.796-132.113-82.432-132.113-82.432s128.051,25.335,151.706,35.132 C265.481,284.681,289.126,294.477,279.33,318.123z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-vwheadlight text-gray-500">Kilometraje</p>
                                        <p class="text-base font-vwheadlight">{{
                                            formatKm(infoSemi.infoGeneral.kilometraje) }} km</p>
                                    </div>
                                </div>

                                <!-- Transmisión -->
                                <div class="flex items-center space-x-2">
                                    <svg class="h-10 w-10" viewBox="0 0 24.00 24.00" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" stroke="#001E50"
                                        stroke-width="0.00024000000000000003">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4 2.75C3.30964 2.75 2.75 3.30964 2.75 4C2.75 4.69036 3.30964 5.25 4 5.25C4.69036 5.25 5.25 4.69036 5.25 4C5.25 3.30964 4.69036 2.75 4 2.75ZM1.25 4C1.25 2.48122 2.48122 1.25 4 1.25C5.51878 1.25 6.75 2.48122 6.75 4C6.75 5.25878 5.90425 6.32002 4.75 6.64648V11.25H11.25V6.64648C10.0957 6.32002 9.25 5.25878 9.25 4C9.25 2.48122 10.4812 1.25 12 1.25C13.5188 1.25 14.75 2.48122 14.75 4C14.75 5.25878 13.9043 6.32002 12.75 6.64648V11.25H16C16.964 11.25 17.6116 11.2484 18.0946 11.1835C18.5561 11.1214 18.7536 11.0142 18.8839 10.8839C19.0142 10.7536 19.1214 10.5561 19.1835 10.0946C19.2484 9.61157 19.25 8.96401 19.25 8V6.64648C18.0957 6.32002 17.25 5.25878 17.25 4C17.25 2.48122 18.4812 1.25 20 1.25C21.5188 1.25 22.75 2.48122 22.75 4C22.75 5.25878 21.9043 6.32002 20.75 6.64648V8.05199C20.75 8.95048 20.7501 9.6997 20.6701 10.2945C20.5857 10.9223 20.4 11.4891 19.9445 11.9445C19.4891 12.4 18.9223 12.5857 18.2945 12.6701C17.6997 12.7501 16.9505 12.75 16.052 12.75L12.75 12.75V17.3535C13.9043 17.68 14.75 18.7412 14.75 20C14.75 21.5188 13.5188 22.75 12 22.75C10.4812 22.75 9.25 21.5188 9.25 20C9.25 18.7412 10.0957 17.68 11.25 17.3535V12.75H4.75V17.3535C5.90425 17.68 6.75 18.7412 6.75 20C6.75 21.5188 5.51878 22.75 4 22.75C2.48122 22.75 1.25 21.5188 1.25 20C1.25 18.7412 2.09575 17.68 3.25 17.3535V6.64648C2.09575 6.32002 1.25 5.25878 1.25 4ZM12 2.75C11.3096 2.75 10.75 3.30964 10.75 4C10.75 4.69036 11.3096 5.25 12 5.25C12.6904 5.25 13.25 4.69036 13.25 4C13.25 3.30964 12.6904 2.75 12 2.75ZM20 2.75C19.3096 2.75 18.75 3.30964 18.75 4C18.75 4.69036 19.3096 5.25 20 5.25C20.6904 5.25 21.25 4.69036 21.25 4C21.25 3.30964 20.6904 2.75 20 2.75ZM17.25 15C17.25 14.5858 17.5858 14.25 18 14.25H20.2857C21.6612 14.25 22.75 15.3839 22.75 16.75C22.75 17.8285 22.0713 18.7624 21.1086 19.1077L22.6396 21.6084C22.8559 21.9616 22.7449 22.4234 22.3916 22.6396C22.0384 22.8559 21.5766 22.7449 21.3604 22.3916L19.4369 19.25H18.75V22C18.75 22.4142 18.4142 22.75 18 22.75C17.5858 22.75 17.25 22.4142 17.25 22V15ZM18.75 17.75H20.2857C20.8038 17.75 21.25 17.3169 21.25 16.75C21.25 16.1831 20.8038 15.75 20.2857 15.75H18.75V17.75ZM4 18.75C3.30964 18.75 2.75 19.3096 2.75 20C2.75 20.6904 3.30964 21.25 4 21.25C4.69036 21.25 5.25 20.6904 5.25 20C5.25 19.3096 4.69036 18.75 4 18.75ZM12 18.75C11.3096 18.75 10.75 19.3096 10.75 20C10.75 20.6904 11.3096 21.25 12 21.25C12.6904 21.25 13.25 20.6904 13.25 20C13.25 19.3096 12.6904 18.75 12 18.75Z"
                                                fill="#001E50"></path>
                                        </g>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-vwheadlight text-gray-500">Transmisión</p>
                                        <p class="text-base font-vwheadlight">{{ infoSemi.infoGeneral.transmision === 'manual' ? 'Manual' : infoSemi.infoGeneral.transmision === 'automatica' ? 'Automática' : infoSemi.infoGeneral.transmision }}</p>
                                    </div>
                                </div>

                                <!-- Color Exterior -->
                                <div class="flex items-center space-x-2">
                                    <svg class="h-10" fill="#001E50" viewBox="0 0 24.00 24.00"
                                        xmlns="http://www.w3.org/2000/svg" stroke="#001E50"
                                        stroke-width="0.00024000000000000003">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path
                                                d="M20 14c-.092.064-2 2.083-2 3.5 0 1.494.949 2.448 2 2.5.906.044 2-.891 2-2.5 0-1.5-1.908-3.436-2-3.5zM9.586 20c.378.378.88.586 1.414.586s1.036-.208 1.414-.586l7-7-.707-.707L11 4.586 8.707 2.293 7.293 3.707 9.586 6 4 11.586c-.378.378-.586.88-.586 1.414s.208 1.036.586 1.414L9.586 20zM11 7.414 16.586 13H5.414L11 7.414z">
                                            </path>
                                        </g>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-vwheadlight text-gray-500">Color Exterior</p>
                                        <p class="text-base font-vwheadlight">{{ infoSemi.infoGeneral.color }}</p>
                                    </div>
                                </div>

                                <!-- Color Interior -->
                                <div class="flex items-center space-x-2">
                                    <svg class="h-10" fill="#001E50" version="1.1" id="Layer_1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        viewBox="0 0 512.00 512.00" xml:space="preserve" stroke="#001E50"
                                        stroke-width="0.00512">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g>
                                                <g>
                                                    <path
                                                        d="M432.613,348.736c-3.872-1.706-7.722-3.008-11.492-3.981c1.68-7.537,3.097-15.447,4.276-23.675 c2.091-14.558,1.532-29.479-1.576-44.059l-26.646-124.91c-4.613-16.407-13.781-29.182-26.559-38.998 c7.581-9.664,10.672-22.816,6.732-35.738l-8.005-47.968l-1.042-3.912C362.625,10.203,348.073,0,331.767,0H180.258 c-16.29,0-30.824,10.181-36.535,25.44l-13.86,51.58c-5.074,13.54-1.075,28.288,8.384,38.424 c-11.093,9.27-19.061,20.91-23.129,35.322L88.12,277.014c-3.109,14.586-3.668,29.508-1.576,44.073 c1.179,8.232,2.597,16.146,4.278,23.686c-3.744,0.971-7.566,2.267-11.41,3.96c-22.543,9.934-36.731,30.48-36.731,60.325 c0.683,14.501,5.085,33.088,16.639,51.945c19.423,31.701,52.814,50.92,100.452,50.985c0.077,0.001,0.152,0.012,0.23,0.012h192 c0.056,0,0.109-0.008,0.165-0.008c47.675-0.042,81.092-19.266,100.529-50.985c11.555-18.856,15.961-37.441,16.622-50.9 C469.344,379.216,455.157,358.67,432.613,348.736z M183.174,42.667h145.125l7.12,42.667h-67.644c-2.425-0.032-4.808-0.032-7.136,0 h-88.924L183.174,42.667z M129.848,285.915l26.665-124.9c3.386-11.834,18.426-21.817,43.274-27.72 c10.376-2.465,21.666-4.008,33.2-4.769c4.929-0.325,9.502-0.485,13.577-0.526h3.889c1.062,0.01,2.095,0.025,3.064,0.051 c1.298,0.041,1.298,0.041,1.399,0.047c2.208-0.006,2.208-0.006,3.506-0.047c0.969-0.026,2.003-0.041,3.064-0.051h3.886 c4.077,0.041,8.653,0.201,13.584,0.526c11.537,0.761,22.83,2.305,33.208,4.771c24.848,5.905,39.893,15.889,43.617,29.066 l26.311,123.556c2.07,9.712,2.439,19.571,1.07,29.103c-5.363,37.44-17.238,63.667-32.217,68.25 c-0.151,0.041-0.299,0.092-0.451,0.129c-0.039,0.011-0.079,0.018-0.118,0.029c-0.394,0.092-0.795,0.164-1.197,0.228 c-6.045-2.153-14.371-4.742-24.541-7.304c-22.151-5.581-45.354-8.935-68.668-8.935c-23.304,0-46.505,3.354-68.659,8.934 c-10.029,2.526-18.255,5.076-24.28,7.211c-0.089,0.031-0.187,0.065-0.275,0.096c-0.38-0.062-0.759-0.129-1.132-0.216 c-0.054-0.014-0.109-0.025-0.164-0.04c-0.163-0.04-0.322-0.094-0.484-0.139c-14.971-4.599-26.838-30.818-32.199-68.237 C127.408,305.488,127.778,295.628,129.848,285.915z M95.702,438.713c-4.196-6.849-7.092-14.33-8.867-21.821 c-1.036-4.373-1.448-7.558-1.512-8.876c0.025-11.431,3.838-16.953,11.295-20.239c1.817-0.801,3.734-1.405,5.62-1.84 c3.782,5.992,8.006,11.337,12.687,15.987c6.633,8.433,14.486,14.948,23.744,19.173v46.323 C118.265,463.433,104.671,453.353,95.702,438.713z M181.348,469.333v-46.897c0.018-0.006,0.036-0.012,0.054-0.018 c1.149-0.374,2.332-0.748,3.544-1.121c0.107-0.033,0.213-0.066,0.32-0.099c1.215-0.372,2.46-0.743,3.735-1.111 c0.091-0.026,0.184-0.053,0.275-0.079c2.691-0.774,5.509-1.536,8.447-2.276c18.976-4.779,38.786-7.642,58.256-7.642 c19.461,0,39.264,2.862,58.237,7.642c4.497,1.133,8.718,2.318,12.621,3.516c0.021,0.006,0.042,0.013,0.062,0.019 c1.29,0.396,2.545,0.794,3.764,1.191c0.001,0,0.003,0.001,0.004,0.001v46.873H181.348z M425.189,416.89 c-1.776,7.492-4.674,14.974-8.871,21.824c-8.973,14.642-22.569,24.724-42.973,28.71v-46.36 c9.028-4.135,16.716-10.453,23.24-18.602c4.89-4.767,9.285-10.289,13.21-16.52c1.884,0.435,3.798,1.039,5.614,1.839 c7.457,3.286,11.269,8.808,11.269,21.281C426.638,409.33,426.225,412.517,425.189,416.89z">
                                                    </path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-vwheadlight text-gray-500">Color Interior</p>
                                        <p class="text-base font-vwheadlight">{{ infoSemi.infoGeneral.colorInterno }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Número de Puertas -->
                                <div class="flex items-center space-x-2">
                                    <svg class="h-10" viewBox="0 0 512.00 512.00" xmlns="http://www.w3.org/2000/svg"
                                        fill="#001E50" stroke="#001E50" stroke-width="0.00512">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                            stroke="#CCCCCC" stroke-width="8.192"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path fill="#001e50"
                                                d="M149.6 41L42.88 254.4c23.8 24.3 53.54 58.8 78.42 97.4 24.5 38.1 44.1 79.7 47.1 119.2h270.3L423.3 41H149.6zM164 64h230l8 192H74l90-192zm86.8 17.99l-141 154.81L339.3 81.99h-88.5zM336 279h64v18h-64v-18z">
                                            </path>
                                        </g>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-vwheadlight text-gray-500">No. de Puertas</p>
                                        <p class="text-base font-vwheadlight">{{ infoSemi.infoGeneral.numpuertas }}</p>
                                    </div>
                                </div>

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
