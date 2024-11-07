<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { info } from 'autoprefixer';
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    nuevo: Object,
});

function formatPrice(value) {
    if (value == null) return '';
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

const isContentLoaded = ref(false);
const currentIndex = ref(0);
const autoPlayInterval = ref(null);
const transitionEnabled = ref(true);

onMounted(() => {
    setTimeout(() => {
        isContentLoaded.value = true;
    }, 300);

    startAutoPlay();
});

onUnmounted(() => {
    stopAutoPlay();
});

const startAutoPlay = () => {
    // console.log('Starting autoplay');
    autoPlayInterval.value = setInterval(() => {
        // console.log('Next slide');
        nextSlide();
    }, 3000); // Cambia cada 3 segundos
};

const stopAutoPlay = () => {
    // console.log('Stopping autoplay');
    clearInterval(autoPlayInterval.value);
};

const nextSlide = () => {
    transitionEnabled.value = true;
    // console.log('Current index before next slide:', currentIndex.value);

    // Si es la última imagen, vuelve a la primera
    if (currentIndex.value === props.nuevo.colores.length - 1) {
        setTimeout(() => {
            transitionEnabled.value = false;
            currentIndex.value = 0; // Vuelve a la primera sin transiciones
            // console.log('Reset to first slide');
        }, 500); // El tiempo para evitar el salto visual
    } else {
        currentIndex.value++;
        // console.log('Current index after next slide:', currentIndex.value);
    }
};

const prevSlide = () => {
    transitionEnabled.value = true;

    // Si es la primera imagen, vuelve a la última
    if (currentIndex.value === 0) {
        setTimeout(() => {
            transitionEnabled.value = false;
            currentIndex.value = props.nuevo.colores.length - 1;
        }, 500);
    } else {
        currentIndex.value--;
    }
};

const goToSlide = (index) => {
    currentIndex.value = index;
    transitionEnabled.value = true;
};

console.log(props.nuevo);
console.log(props.nuevo.colores);

const selectedVersion = ref(0);
</script>

<template>

    <Head title="Detalles del Auto" />

    <UserLayout>
        <div class="relative min-h-screen bg-white">
            <!-- Hero Section -->
            <div class="relative h-screen">
                <div class="relative h-[80vh] bg-gray-900">
                    <img :src="`/storage/${props.nuevo.fotoAuto}`" :alt="props.nuevo.modelo"
                        class="object-cover w-full h-full"/>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-8">
                        <div class="max-w-7xl mx-auto">
                            <h1 class="text-5xl font-vwheadbold text-white mb-2">{{ props.nuevo.modelo }}</h1>
                            <p class="text-xl text-white/90">{{ props.nuevo.infoGeneral.eslogan }}</p>
                        </div>
                    </div>
                </div>

                <!-- Info general -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="flex flex-wrap gap-x-12 gap-y-6">
                        <!-- Precio -->
                        <div class="flex-1 min-w-[200px]">
                            <h2 class="text-sm font-vwheadlight text-gray-800 mb-1">Precio de contado desde</h2>
                            <p class="text-2xl font-vwheadbold text-gray-900">${{
                                formatPrice(props.nuevo.infoGeneral.precio) }}</p>
                        </div>

                        <!-- Motor -->
                        <div class="flex-1 min-w-[200px]">
                            <h2 class="text-sm font-vwheadlight text-gray-800 mb-1">Motor</h2>
                            <p class="text-lg font-vwheadbold text-gray-900">{{ props.nuevo.infoGeneral.motor }}</p>
                        </div>

                        <!-- Transmisión -->
                        <div class="flex-1 min-w-[200px]">
                            <h2 class="text-sm font-vwheadlight text-gray-800 mb-1">Transmisión</h2>
                            <p class="text-lg font-vwheadbold text-gray-900">{{ props.nuevo.infoGeneral.transmision }}
                            </p>
                        </div>

                        <!-- Potencia -->
                        <div class="flex-1 min-w-[200px]">
                            <h2 class="text-sm font-vwheadlight text-gray-800 mb-1">Potencia</h2>
                            <p class="text-lg font-vwheadbold text-gray-900">{{ props.nuevo.infoGeneral.potencia }}</p>
                        </div>

                        <!-- Torque -->
                        <div class="flex-1 min-w-[200px]">
                            <h2 class="text-sm font-vwheadlight text-gray-800 mb-1">Torque</h2>
                            <p class="text-lg font-vwheadbold text-gray-900">{{ props.nuevo.infoGeneral.torque }}</p>
                        </div>

                        <!-- Versiones -->
                        <div class="flex-1 min-w-[200px]">
                            <h2 class="text-sm font-vwheadlight text-gray-800 mb-1">Versiones</h2>
                            <p class="text-lg font-vwheadbold text-gray-900">{{ props.nuevo.infoGeneral.versiones }}</p>
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <h2 class="text-sm font-vwheadlight text-gray-800 mb-1">Stock</h2>
                            <p class="text-lg font-vwheadbold text-gray-900">{{ props.nuevo.infoGeneral.stock }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Diseño -->
            <div>
                <div class="max-w-3xl mx-auto py-20 px-4">
                    <div>
                        <h2 class="text-lg font-vwheadbold text-gray-900 mb-4">Diseño</h2>
                        <h1 class="text-4xl font-vwheadlight text-gray-900 mb-4"> {{ props.nuevo.disenio.encabezado }}
                        </h1>
                    </div>
                    <p class="text-sm font-vwtext text-gray-900 leading-relaxed"> {{ props.nuevo.disenio.descripcion }}
                    </p>
                </div>
                <!-- Diseño contenido -->
                <div class="container mx-auto py-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div v-for="(disenio, index) in props.nuevo.disenioContenido" :key="index"
                            class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                            <div class="relative h-64">
                                <img :src="`/storage/${disenio.imagen}`" :alt="disenio.titulo"
                                    class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-60">
                                </div>
                                <h3 class="absolute bottom-4 left-4 right-4 text-2xl font-vwheadlight text-white">
                                    {{ disenio.titulo }}
                                </h3>
                            </div>

                            <div class="p-6 space-y-4">
                                <h4 class="text-xl font-vwheadbold text-gray-800">{{ disenio.subtitulo }}</h4>
                                <p class="text-md font-vwheadlight text-gray-600 leading-relaxed">{{ disenio.descripcion
                                    }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carrusel de imágenes con la informacion de colores-->
            <div class="container mx-auto py-6 sm:py-8 md:py-0">
                <div class="relative overflow-hidden">
                    <!-- Contenedor del carrusel (ajustado a todas las pantallas) -->
                    <div class="flex transition-transform duration-500 ease-in-out"
                        :class="{ 'transition-none': !transitionEnabled }"
                        :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
                        <!-- Imágenes del carrusel -->
                        <div class="w-full flex-shrink-0" v-for="(image, index) in props.nuevo.colores" :key="index">
                            <!-- <img :src="`/storage/${image}`" alt="Carrusel Image" class="w-full h-64 sm:h-80 md:h-96 lg:h-auto object-cover" /> -->
                            <img :src="`/storage/${image}`" alt="Carrusel Image" class="w-full h-auto object-cover" />


                        </div>
                    </div>

                    <!-- Botones de navegación -->
                    <button @click="prevSlide"
                        class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-2 rounded-r-md hover:bg-opacity-75 transition-all">
                        &#10094;
                    </button>
                    <button @click="nextSlide"
                        class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-2 rounded-l-md hover:bg-opacity-75 transition-all">
                        &#10095;
                    </button>

                    <!-- Puntos de navegación -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        <button v-for="(_, index) in props.nuevo.colores" :key="index" @click="goToSlide(index)"
                            :class="['w-3 h-3 rounded-full transition-all', currentIndex === index ? 'bg-white' : 'bg-gray-400 hover:bg-gray-300']"></button>
                    </div>
                </div>
            </div>

            <!-- Tecno-Seguridad -->
            <div>
                <div class="max-w-3xl mx-auto py-20 px-4">
                    <div>
                        <h2 class="text-lg font-vwheadbold text-gray-900 mb-4"> {{ props.nuevo.tecnologia.titulo }}
                        </h2>
                        <h1 class="text-4xl font-vwheadlight text-gray-900 mb-4"> {{ props.nuevo.tecnologia.encabezado
                            }}
                        </h1>
                    </div>
                    <p class="text-sm font-vwtext text-gray-900 leading-relaxed"> {{ props.nuevo.tecnologia.descripcion
                        }}
                    </p>
                </div>
                <!-- Tecnologia contenido -->
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <div v-for="(tecnologia, index) in props.nuevo.tecnologiaContenido" :key="index"
                            class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                            <div class="relative h-64">
                                <img :src="`/storage/${tecnologia.imagen}`" :alt="tecnologia.titulo"
                                    class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-60">
                                </div>
                                <h3 class="absolute bottom-4 left-4 right-4 text-2xl font-vwheadlight text-white">
                                    {{ tecnologia.titulo }}
                                </h3>
                            </div>
                            <div class="p-6 space-y-4">
                                <h4 class="text-xl font-vwheadbold text-gray-800">{{ tecnologia.subtitulo }}</h4>
                                <p class="text-md font-vwheadlight text-gray-600 leading-relaxed">{{
                                    tecnologia.descripcion
                                    }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Versiones -->
            <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white">
                <div class="max-w-7xl mx-auto">
                    <h2 class="text-4xl font-vwheadbold text-center mb-12">Versiones</h2>

                    <!-- Tabs de versiones -->
                    <div class="flex flex-wrap justify-center gap-2 sm:gap-8 mb-12 border-b">
                        <button v-for="(version, index) in props.nuevo.versiones" :key="index"
                            @click="selectedVersion = index"
                            class="relative px-4 py-2 text-base font-vwheadbold transition-colors duration-200"
                            :class="[selectedVersion === index ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700']">
                            {{ version.nomVersion }}
                        </button>
                    </div>
                    <!-- Contenido de la versión -->
                    <TransitionGroup name="fade" mode="out-in" class="relative">
                        <div v-for="(version, index) in props.nuevo.versiones" :key="version.nomVersion"
                            v-show="selectedVersion === index"
                            class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                            <div style="border: 1px solid #ccc;">
                                <div class="relative aspect-[4/3] bg-[#ffffff] rounded-lg overflow-hidden">
                                    <img :src="`/storage/${version.imagen}`" :alt="version.nomVersion"
                                        class="w-full h-full object-contain p-4">

                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6" v-for="infoGen in version.infoGen"
                                    :key="infoGen">
                                    <div class="space-y-2">
                                        <p class="text-sm font-vwheadlight text-gray-600">Desde</p>
                                        <p class="text-lg font-vwheadbold text-gray-900">
                                            ${{ formatPrice(infoGen.precioVersion) }}
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm font-vwheadlight text-gray-600">Rendimiento</p>
                                        <p class="text-lg font-vwheadbold text-gray-900">
                                            {{ infoGen.rendimiento }}
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-sm font-vwheadlight text-gray-600">Potencia</p>
                                        <p class="text-lg font-vwheadbold text-gray-900">
                                            {{ infoGen.potencia }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-8" >
                                <div>
                                    <h3 class="text-xl font-vwheadbold text-gray-900 mb-4">Características</h3>
                                    <ul class=" gap-x-6 gap-y-3">
                                        <li v-for="caracteristica in version.caracteristicas" :key="caracteristica"
                                            class="flex items-start gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            <span class="font-vwheadlight text-sm text-gray-700">{{ caracteristica
                                                }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </TransitionGroup>
                </div>
            </section>



        </div>
    </UserLayout>
</template>

<style scoped>

.contFoto {

    backgroundImage: url('/storage/${props.nuevo.fotoAuto}');

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.fade-enter-to,
.fade-leave-from {
    opacity: 1;
}
</style>
