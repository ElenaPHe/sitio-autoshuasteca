<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    inicios: Object,
});

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
    autoPlayInterval.value = setInterval(() => {
        nextSlide();
    }, 3000); // Cambia cada 3 segundos
};

const stopAutoPlay = () => {
    clearInterval(autoPlayInterval.value);
};

const nextSlide = () => {
    transitionEnabled.value = true;

    // Si es la última imagen, vuelve a la primera
    if (currentIndex.value === props.inicios[0].carrusel.length - 1) {
        setTimeout(() => {
            transitionEnabled.value = false;
            currentIndex.value = 0; // Vuelve a la primera sin transiciones
        }, 500); // El tiempo para evitar el salto visual
    } else {
        currentIndex.value++;
    }
};

const prevSlide = () => {
    transitionEnabled.value = true;

    // Si es la primera imagen, vuelve a la última
    if (currentIndex.value === 0) {
        setTimeout(() => {
            transitionEnabled.value = false;
            currentIndex.value = props.inicios[0].carrusel.length - 1;
        }, 500);
    } else {
        currentIndex.value--;
    }
};

const goToSlide = (index) => {
    currentIndex.value = index;
    transitionEnabled.value = true;
};
</script>

<template>

    <Head title="Bienvenido" />

    <UserLayout>
        <div class="relative h-screen" v-for="info in inicios" :key="info.id">
            <!-- <div class="bg-image h-3/4  bg-cover bg-center" style=" background-image: url('https://vw-huasteca.com.mx/Assets/ModelosNuevos/PortaHome/web_1920x720.jpg');"> -->
            <div class="bg-image h-3/4  bg-cover bg-center"
                :style="` background-image: url('/storage/${info.imagen}'); `">
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

            <!-- Nombre de la empresa -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 md:py-12 text-center">
                <h2 :class="[
                    'text-3xl sm:text-4xl md:text-5xl mb-4 transition-all duration-1000 ease-out font-vwheadbold',
                    { 'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded }
                ]">
                    Autos de la Huasteca
                </h2>
            </div>

            <!-- Carrusel de imágenes -->
            <div class="container mx-auto py-6 sm:py-8 md:py-0">
                <div class="relative overflow-hidden">
                    <!-- Contenedor del carrusel (ajustado a todas las pantallas) -->
                    <div class="flex transition-transform duration-500 ease-in-out"
                        :class="{ 'transition-none': !transitionEnabled }"
                        :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
                        <!-- Imágenes del carrusel -->
                        <div class="w-full flex-shrink-0" v-for="(image, index) in info.carrusel" :key="index">
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
                        <button v-for="(_, index) in info.carrusel" :key="index" @click="goToSlide(index)"
                            :class="['w-3 h-3 rounded-full transition-all', currentIndex === index ? 'bg-white' : 'bg-gray-400 hover:bg-gray-300']"></button>
                    </div>
                </div>
            </div>

            <!-- Contenido de promociones -->
            <div class="container mx-auto py-12">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-vwheadlight text-center mb-16">
                    Descubre todas las <span class="font-vwheadbold">promociones</span>
                </h2>
                <div v-for="(promocion, index) in info.promociones" :key="promocion.id"
                     class="flex flex-col md:flex-row items-center mb-12 md:mb-24">
                    <div :class="[
                        'w-full md:w-1/2 mb-6 md:mb-0',
                        index % 2 === 0 ? 'md:order-1' : 'md:order-2'
                    ]">
                        <img :src="`/storage/${promocion.imagen}`" :alt="promocion.titulo"
                             class="w-full h-auto shadow-lg">
                    </div>
                    <div :class="[
                        'w-full md:w-1/2 px-4 mt-6',
                        index % 2 === 0 ? 'md:order-2' : 'md:order-1'
                    ]">
                        <h3 class="text-center -my-10 text-xl sm:text-2xl md:text-3xl font-vwheadbold mb-4">{{ promocion.titulo }}</h3>
                        <p class="text-base sm:text-lg font-vwheadlight text-gray-700">{{ promocion.descripcion }}</p>
                    </div>
                </div>
            </div>


        </div>
    </UserLayout>
</template>

<style scoped>
@media (max-width: 640px) {
    .aspect-w-16.aspect-h-9 {
        aspect-ratio: 4 / 3;
    }
}

.transition-none {
    transition: none;
}

</style>
