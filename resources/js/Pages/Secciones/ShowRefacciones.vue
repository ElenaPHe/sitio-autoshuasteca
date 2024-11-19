<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps({
    refaccion: Object,
});

const isContentLoaded = ref(false);
const currentIndex = ref(0);
const transitionEnabled = ref(true);

const nextSlide = () => {
    currentIndex.value = (currentIndex.value + 1) % props.refaccion.carruselKit.length;
};

const prevSlide = () => {
    currentIndex.value =
        (currentIndex.value - 1 + props.refaccion.carruselKit.length) % props.refaccion.carruselKit.length;
};

const goToSlide = (index) => {
    currentIndex.value = index;
};

onMounted(() => {
    setTimeout(() => {
        isContentLoaded.value = true;
    }, 300);
});
</script>

<template>

    <Head title="Detalles de la refacción" />

    <UserLayout>
        <div class="relative min-h-screen bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <!-- Breadcrumb -->
                <nav class="mb-8">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500">
                        <li>
                            <Link :href="route('refacciones')" class="hover:text-[#001E50]">Refacciones</Link>
                        </li>
                        <li class="flex items-center">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </li>
                        <li class="font-medium text-[#001E50]">{{ props.refaccion.nombre }} </li>
                    </ol>
                </nav>

                <!-- Main Content -->
                <div class="flex flex-col lg:flex-row gap-8 ">
                    <!-- Carrusel de Imágenes -->
                    <div class="w-full lg:w-1/2 bg-white rounded-lg shadow-sm p-4">
                        <div class="container mx-auto py-6 sm:py-8 md:py-0">
                            <template v-if="props.refaccion.tipoRefaccion == 'Unico'">
                                <h1>Es Unico</h1>
                                <div class="w-full flex-shrink-0">
                                    <img :src="`/storage/${props.refaccion.imagen}`" alt="Carrusel Image"
                                        class="w-full h-auto object-cover" />
                                </div>
                            </template>
                            <template v-else>
                                <div class="relative overflow-hidden">
                                    <div class="flex transition-transform duration-500 ease-in-out"
                                        :class="{ 'transition-none': !transitionEnabled }"
                                        :style="{ transform: `translateX(-${currentIndex * 100}%)` }">

                                        <div class="w-full flex-shrink-0"
                                            v-for="(imagenes, index) in refaccion.carruselKit" :key="index">
                                            <img :src="`/storage/${imagenes}`" alt="Carrusel Image"
                                                class="w-full h-auto object-cover" />
                                        </div>
                                    </div>


                                    <button @click="prevSlide"
                                        class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-2 rounded-r-md hover:bg-opacity-75 transition-all">
                                        &#10094;
                                    </button>
                                    <button @click="nextSlide"
                                        class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-2 rounded-l-md hover:bg-opacity-75 transition-all">
                                        &#10095;
                                    </button>


                                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                        <button v-for="(_, index) in refaccion.imagenes" :key="index"
                                            @click="goToSlide(index)"
                                            :class="['w-3 h-3 rounded-full transition-all', currentIndex === index ? 'bg-white' : 'bg-gray-400 hover:bg-gray-300']"></button>
                                    </div>
                                </div>
                            </template>


                        </div>
                    </div>

                    <!-- Ficha tecnica -->
                    <div class="w-full lg:w-1/2 space-y-6">
                        <!-- Title and Price -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h1 class="text-3xl font-vwheadbold text-gray-900 mb-4">
                                {{ refaccion.nombre }}
                            </h1>
                            <div class="flex items-baseline mt-4">
                                <span class="text-3xl font-vwheadbold text-[#001E50]">${{ refaccion.infoGeneral.precio
                                    }}</span>
                            </div>

                        </div>

                        <!-- Technical Specifications -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <!-- <h2 class="text-xl font-vwheadbold text-gray-900 mb-4">Ficha Técnica</h2> -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-500">No. de parte</p>
                                        <p class="font-vwheadlight">{{ refaccion.infoGeneral.numParte}}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Aplicacion</p>
                                        <p class="font-vwheadlight">{{ refaccion.aplicacion}}</p>
                                    </div>
                                </div>
                                <!-- <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-500">Número de Puertas</p>
                                        <p class="font-vwheadlight">{{ seminuevo.infoGeneral.numpuertas }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Carrocería</p>
                                        <p class="font-vwheadlight">{{ seminuevo.infoGeneral.tipoAuto }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Marca</p>
                                        <p class="font-vwheadlight">{{ seminuevo.infoGeneral.marca }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Modelo</p>
                                        <p class="font-vwheadlight">{{ seminuevo.infoGeneral.modelo }}</p>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="flex justify-center mt-8">
                    <Link :href="route('refacciones')"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#001E50] hover:bg-[#002a6e] transition-colors duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Regresar
                    </Link>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<style scoped></style>
