<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { info } from 'autoprefixer';
import { ref, onMounted, onUnmounted, nextTick } from 'vue';

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

const loadedImages = ref(0);

const onImageLoad = () => {
    loadedImages.value++;
    if (loadedImages.value === props.nuevo.galeria.value.length) {
        console.log('Todas las imágenes han sido cargadas');
    }
};



</script>

<template>

    <Head title="Detalles del Auto" />

    <UserLayout>
        <div class="relative min-h-screen bg-white">
            <!-- Hero Section -->
            <div class="relative h-screen">
                <div class="relative h-[80vh] bg-gray-900">
                    <img :src="`/storage/${props.nuevo.fotoAuto}`" :alt="props.nuevo.modelo"
                        class="object-cover w-full h-full" />
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-8">
                        <div class="max-w-7xl mx-auto">
                            <h1 class="text-5xl font-vwheadbold text-white mb-2">{{ props.nuevo.modelo.replace(/\s\d{4}$/, '') }}</h1>
                            <p class="text-xl text-white/90">{{ props.nuevo.infoGeneral.eslogan }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div style="position: relative; bottom: 100px;">


                <!-- Info general -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-wrap gap-x-12 gap-y-6" style="width: 100%;">
                        <!-- Precio -->
                        <div class="flex-1 min-w-[200px]">
                            <h2 class="font-vwheadlight text-gray-800" style="font-size: 16px; font-weight: 400; line-height: 19px; ">Precio de contado desde</h2>
                            <p class="font-vwheadbold text-gray-900" style="font-size: 30px; font-weight: 400px; line-height: 36px;">${{
                                formatPrice(props.nuevo.infoGeneral.precio) }}</p>
                        </div>

                        <!-- Motor -->
                        <div class="flex-1 min-w-[200px]">
                            <h2 class="font-vwheadlight text-gray-800" style="font-size: 16px; font-weight: 400; line-height: 19px;">Motor</h2>
                            <p class=" font-vwheadbold text-gray-900" style="font-size: 30px; font-weight: 400px; line-height: 36px;">{{ props.nuevo.infoGeneral.motor }}</p>
                        </div>

                        <!-- Transmisión -->
                        <div class="flex-1 min-w-[200px]">
                            <h2 class="font-vwheadlight text-gray-800" style="font-size: 16px; font-weight: 400; line-height: 19px; ">Transmisión</h2>
                            <p class=" font-vwheadbold text-gray-900" style="font-size: 30px; font-weight: 400px; line-height: 36px;">{{ props.nuevo.infoGeneral.transmision }}
                            </p>
                        </div>

                        <!-- Potencia -->
                        <div class="flex-1 min-w-[200px]">
                            <h2 class=" font-vwheadlight text-gray-800 " style="font-size: 16px; font-weight: 400; line-height: 19px; ">Potencia</h2>
                            <p class="font-vwheadbold text-gray-900" style="font-size: 30px; font-weight: 400px; line-height: 36px;">{{ props.nuevo.infoGeneral.potencia }}</p>
                        </div>

                        <!-- Torque -->
                        <div class="flex-1 min-w-[200px]">
                            <h2 class=" font-vwheadlight text-gray-800 " style="font-size: 16px; font-weight: 400; line-height: 19px; ">Torque</h2>
                            <p class="font-vwheadbold text-gray-900" style="font-size: 30px; font-weight: 400px; line-height: 36px;">{{ props.nuevo.infoGeneral.torque }}</p>
                        </div>

                        <!-- Versiones -->
                        <div class="flex-1 min-w-[200px]">
                            <h2 class="font-vwheadlight text-gray-800" style="font-size: 16px; font-weight: 400; line-height: 19px; ">Versiones</h2>
                            <p class="font-vwheadbold text-gray-900" style="font-size: 30px; font-weight: 400px; line-height: 36px;">{{ props.nuevo.infoGeneral.versiones }}</p>
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <h2 class=" font-vwheadlight text-gray-800" style="font-size: 16px; font-weight: 400; line-height: 19px; ">Stock</h2>
                            <p class="font-vwheadbold text-gray-900" style="font-size: 30px; font-weight: 400px; line-height: 36px;">{{ props.nuevo.infoGeneral.stock }} disponibles</p>
                        </div>
                    </div>
                </div>
                <!-- Diseño -->
                <div>
                    <div class="max-w-3xl mx-auto py-14 px-4">
                        <div>
                            <h2 class="font-vwheadbold text-gray-900 mb-4"
                                style="font-size: 24px; color: #212729; line-height: 36px;">Diseño</h2>
                            <h1 class="font-vwheadlight text-gray-900 mb-4"
                                style="font-size: 45px; font-weight: 500; line-height: 63px;"> {{
                                    props.nuevo.disenio.encabezado
                                }}
                            </h1>
                        </div>
                        <p class="font-vwtext" style="font-size: 16px; font-weight: 400; color: rgb(33, 37, 41);"> {{
                            props.nuevo.disenio.descripcion
                        }}
                        </p>
                    </div>
                    <!-- Diseño contenido -->
                    <div class="container mx-auto py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div v-for="(disenio, index) in props.nuevo.disenioContenido" :key="index"
                                class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                                <div class="relative h-64">
                                    <img :src="`/storage/${disenio.imagen}`" :alt="disenio.titulo"
                                        class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black opacity-60">
                                    </div>
                                    <h3
                                        class="text-center absolute bottom-4 left-4 right-4 text-2xl font-vwheadlight text-white ">
                                        {{ disenio.titulo }}
                                    </h3>
                                </div>

                                <div class="p-6 space-y-4">
                                    <h4 class="font-vwheadbold text-center pb-2"
                                        style="color: #212529; font-size: 20px; font-weight: 500; line-height: 24px; margin: 15px 0px 0px;">
                                        {{ disenio.subtitulo }}</h4>
                                    <p class="font-vwheadlight text-left"
                                        style="color: #212529; font-size: 16px; font-weight: 400; line-height: 24px; margin: 0px 0px 16px;">
                                        {{
                                            disenio.descripcion
                                        }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carrusel de imágenes con la informacion de colores-->
                <div class="container mx-auto py-6 sm:py-8 md:py-0">
                    <div class="relative overflow-hidden">
                        <h2 Colores class="font-vwheadbold text-center"
                            style="font-size: 45px; font-weight: 500; line-height: 63px; margin: 30px 0px;"> Colores
                        </h2>
                        <!-- Contenedor del carrusel (ajustado a todas las pantallas) -->
                        <div class="flex transition-transform duration-500 ease-in-out"
                            :class="{ 'transition-none': !transitionEnabled }"
                            :style="{ transform: `translateX(-${currentIndex * 100}%)` }">

                            <!-- Imágenes del carrusel -->
                            <div class="w-full flex-shrink-0" v-for="(image, index) in props.nuevo.colores"
                                :key="index">
                                <!-- <img :src="`/storage/${image}`" alt="Carrusel Image" class="w-full h-64 sm:h-80 md:h-96 lg:h-auto object-cover" /> -->
                                <img :src="`/storage/${image}`" alt="Carrusel Image"
                                    class="w-full h-auto object-cover" />


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
                                :class="['w-3 h-3 rounded-full transition-all', currentIndex === index ? 'bg-slate-400' : 'bg-gray-700 hover:bg-gray-500']"></button>
                        </div>
                    </div>
                </div>

                <!-- Tecno-Seguridad -->
                <div>
                    <div class="max-w-3xl mx-auto py-20 px-4">
                        <div>
                            <h2 class="font-vwheadbold text-gray-900 mb-4"
                                style="font-size: 24px; color: #212729; line-height: 36px;"> {{
                                    props.nuevo.tecnologia.titulo }}
                            </h2>
                            <h1 class="font-vwheadlight text-gray-900 mb-4"
                                style="font-size: 45px; font-weight: 500; line-height: 63px;"> {{
                                    props.nuevo.tecnologia.encabezado
                                }}
                            </h1>
                        </div>
                        <p class="font-vwtext leading-relaxed"
                            style="font-size: 16px; font-weight: 400; color: rgb(33, 37, 41);">{{
                                props.nuevo.tecnologia.descripcion
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
                                    <h4 class="font-vwheadbold"
                                        style="color: #212529; font-size: 20px; font-weight: 500; line-height: 24px; margin: 15px 0px 0px;">
                                        {{ tecnologia.subtitulo }}</h4>
                                    <p class="font-vwheadlight"
                                        style="color: #212529; font-size: 16px; font-weight: 400; line-height: 24px; margin: 0px 0px 16px;">
                                        {{
                                            tecnologia.descripcion
                                        }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Galeria -->
                <!-- <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 bg-white">
                    <h2 class="font-vwheadbold text-center"
                        style="font-size: 45px; font-weight: 500; line-height: 63px; margin: 30px 0px;">Galería</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="(imagen, index) in props.nuevo.galeria" :key="index"
                            class="relative aspect-[4/3] bg-[#ffffff] rounded-lg overflow-hidden">
                            <img :src="`/storage/${imagen}`" :alt="props.nuevo.modelo"
                                class="w-full h-full object-cover p-4">
                        </div>
                    </div>
                </div> -->

                <!-- <div class="p-5 sm:p-8">
                    <div
                        class="columns-1 gap-5 sm:columns-2 sm:gap-8 md:columns-3 lg:columns-4 [&>img:not(:first-child)]:mt-3">
                        <div v-for="(imagen, index) in props.nuevo.galeria" :key="index">
                            <img :src="`/storage/${imagen}`" :alt="props.nuevo.modelo">
                        </div>
                    </div>
                </div> -->
                <h2 Colores class="font-vwheadbold text-center"
                    style="font-size: 45px; font-weight: 500; line-height: 63px; margin: 30px 0px;"> Galeria
                </h2>
                <div class="masonry-gallery p-5 sm:p-8">

                    <div v-for="(imagen, index) in props.nuevo.galeria" :key="index" class="masonry-item">
                        <img :src="`/storage/${imagen}`" :alt="imagen.alt" @load="onImageLoad" />
                    </div>
                </div>


                <!-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                    <div class="group cursor-pointer relative" v-for="(imagen, index) in props.nuevo.galeria"
                        :key="index">
                        <img :src="`/storage/${imagen}`" :alt="props.nuevo.modelo" alt="Image 1"
                            class="w-full h-48 object-cover rounded-lg transition-transform transform scale-100 group-hover:scale-105">
                    </div>
                </div> -->

                <!-- Versiones -->
                <section class="py-4 px-4 sm:px-6 lg:px-8 bg-white">
                    <div class="max-w-7xl mx-auto">
                        <h2 class="font-vwheadbold text-center"
                            style="font-size: 45px; font-weight: 500; line-height: 63px; margin: 10px 0px;">Versiones
                        </h2>

                        <!-- Tabs de versiones -->
                        <div class="flex flex-wrap justify-center gap-2 sm:gap-8 mb-4 border-b-2 border-slate-200 ">
                            <button v-for="(version, index) in props.nuevo.versiones" :key="index"
                                @click="selectedVersion = index"
                                class="relative font-vwheadbold transition-colors duration-200  "
                                :class="[selectedVersion === index ? 'text-blue-600 border-b-2 border-blue-600' : 'text-[#001E50]']"
                                style=" display: inline; font-size: 20px; font-weight: 400; line-height: 30px; padding: 12px; ">
                                {{ version.nomVersion }}
                            </button>
                        </div>
                        <!-- Contenido de la versión -->
                        <TransitionGroup name="fade" mode="out-in" class="relative">
                            <div v-for="(version, index) in props.nuevo.versiones" :key="version.nomVersion"
                                v-show="selectedVersion === index"
                                class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                                <div>
                                    <div class="relative aspect-[4/3] bg-[#ffffff] rounded-lg overflow-hidden">
                                        <img :src="`/storage/${version.imagen}`" :alt="version.nomVersion"
                                            class="w-full h-full object-contain p-1">
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 text-center"
                                        v-for="infoGen in version.infoGen" :key="infoGen">
                                        <div class="space-y-2">
                                            <p class="font-vwheadlight text-gray-600"
                                                style="display: grid; line-height: 16px; margin: 0px;">
                                                Desde</p>
                                            <p class="font-vwheadbold text-gray-900"
                                                style="display: inline; font-size: 22px; line-height: 22px;">
                                                ${{ formatPrice(infoGen.precioVersion) }}
                                            </p>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="font-vwheadlight text-gray-600"
                                                style="display: grid; line-height: 16px; margin: 0px;">
                                                Rendimiento</p>
                                            <p class="font-vwheadbold text-gray-900"
                                                style="display: inline; font-size: 22px; line-height: 22px;">
                                                {{ infoGen.rendimiento }}
                                            </p>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="font-vwheadlight text-gray-600"
                                                style="display: grid; line-height: 16px; margin: 0px;">
                                                Potencia</p>
                                            <p class="font-vwheadbold text-gray-900"
                                                style="display: inline; font-size: 22px; line-height: 22px;">
                                                {{ infoGen.potencia }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-8">
                                    <div>
                                        <h3 class="font-vwheadbold" style="color: #001e50; font-size: 24px; font-weight: 500; line-height: 28px;
                                        margin: 15px 0px;">Características</h3>
                                        <ul class=" gap-x-6 gap-y-3">
                                            <li v-for="caracteristica in version.caracteristicas" :key="caracteristica"
                                                class="flex items-start gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                                <p class="font-vwheadlight"
                                                    style="display: list-item; font-size: 13 px; font-weight: 400; line-height: 23px;">
                                                    {{ caracteristica
                                                    }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </TransitionGroup>
                    </div>
                </section>

            </div>

        </div>
    </UserLayout>
</template>

<style scoped>
.contFoto {

    backgroundImage: url('/storage/${props.nuevo.fotoAuto}');

    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
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

.transition-none {
    transition: none;
}




.masonry-gallery {
    columns: 4 200px;
    column-gap: 16px;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.masonry-item {
    break-inside: avoid;
    margin-bottom: 16px;
    display: inline-block;
    width: 100%;
    transition: all 0.3s ease;
    border-radius: 8px;
    overflow: hidden;
    opacity: 0;
    animation: fadeIn 0.5s ease-out forwards;
}

.masonry-item img {
    display: block;
    width: 100%;
    height: auto;
    transition: transform 0.3s ease;
}

.masonry-item:hover img {
    transform: scale(1.05);
}

.masonry-item.horizontal {
    grid-column-end: span 2;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 1000px) {
    .masonry-gallery {
        columns: 3 200px;
    }
}

@media (max-width: 768px) {
    .masonry-gallery {
        columns: 2 150px;
    }
}

@media (max-width: 480px) {
    .masonry-gallery {
        columns: 1 100%;
    }
}
</style>
