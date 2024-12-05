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

const mostrarTerminos = ref(false);

const toggleTerminos = () => {
  mostrarTerminos.value = !mostrarTerminos.value;
};

const scrollToButton = (event) => {
  event.preventDefault();
  const button = document.getElementById('terminos');
  button.scrollIntoView({ behavior: 'smooth' });
};

</script>

<template>

    <Head title="Bienvenido" />

    <UserLayout>

        <div v-for="item in inicios" :key="item.id" class="h-3/4">
            <div class=" relative bg-image  bg-cover bg-center"
            :style="` background-image: url('/storage/${item.imagen}'); `" style="height: 80vh;">


        </div>

        </div>

        <div class="relative" v-for="info in inicios" :key="info.id">

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
                        <h3 class="text-center -my-10 text-xl sm:text-2xl md:text-3xl font-vwheadbold mb-4">{{
                            promocion.titulo }}</h3>
                        <p class="text-base sm:text-lg font-vwheadlight text-gray-700">{{ promocion.descripcion }}</p>
                        <a @click="scrollToButton" href="#terminos">Terminos y condiciones</a>
                    </div>
                </div>
            </div>

            <div class="container ">
                <button  id="terminos" @click="toggleTerminos" :class="{ 'cerrar': mostrarTerminos }" class="button">
                  {{ mostrarTerminos ? 'Cerrar' : 'Términos y Condiciones' }}
                </button>
                <transition name="fade">
                  <div v-if="mostrarTerminos" class="terminos">
                    <p>
                      {{ info.terminos }}

                    </p>
                  </div>
                </transition>
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

html {
    scroll-behavior: smooth;
  }



.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    margin-bottom: 20px;
  }

  .button {
    background-color: rgb(0,30,80);
    border: none;
    color: white;
    padding: 12px 24px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    transition: all 0.3s ease;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  .button:hover {
    background-color: rgb(0,40,100);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  }

  .cerrar {
    background-color: rgb(180,0,0);
  }

  .cerrar:hover {
    background-color: rgb(220,0,0);
  }

  .terminos {
    max-width: 800px;
    margin-top: 20px;
    text-align: justify;
    font-size: 12px;
    line-height: 1.6;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }

  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.6s ease, transform 0.6s ease-out;
  }

  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
  }

</style>
