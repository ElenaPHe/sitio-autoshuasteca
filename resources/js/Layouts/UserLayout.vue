<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const isMenuOpen = ref(false);
const isScrolledPastImage = ref(false);
const isPageLoaded = ref(false);
const headerOpacity = ref(0);
const page = usePage();
const isSubMenuOpen = ref(false);
const isLineVisible = ref(true);
const lastScrollTop = ref(0);

const hasHeroImage = computed(() => {
    return ['Welcome', 'Secciones/Garantia', 'Secciones/Refacciones', 'Secciones/Mantenimiento', 'Secciones/ShowNuevos'].includes(page.component);
});

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const toggleSubMenu = () => {
    isSubMenuOpen.value = !isSubMenuOpen.value;
};

const checkScroll = () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const imageHeight = document.querySelector('.bg-image')?.offsetHeight || 0;

    if (scrollTop > lastScrollTop.value && scrollTop > 0) {
        isLineVisible.value = false;
    } else {
        isLineVisible.value = true;
    }

    lastScrollTop.value = scrollTop <= 0 ? 0 : scrollTop;

    isScrolledPastImage.value = scrollTop > imageHeight * 0.75;

    if (hasHeroImage.value) {
        if (scrollTop > imageHeight) {
            headerOpacity.value = Math.min((scrollTop - imageHeight) / 100, 0.75);
        } else {
            headerOpacity.value = 0;
        }
    } else {
        headerOpacity.value = 0.75;
    }
};

onMounted(() => {
    window.addEventListener('scroll', checkScroll);
    checkScroll();
    setTimeout(() => {
        isPageLoaded.value = true;
    }, 100);
});

onUnmounted(() => {
    window.removeEventListener('scroll', checkScroll);
});
</script>

<template>
    <div class="min-h-screen">
    <header :class="[
        'fixed top-0 left-0 right-0 z-50 transition-all duration-300 h-20',
        { 'opacity-0 translate-y-[-20px]': !isPageLoaded, 'opacity-100 translate-y-0': isPageLoaded }
    ]" :style="{ backgroundColor: `rgba(255, 255, 255, ${headerOpacity})` }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-14">
                <button @click="toggleMenu"
                    class="mr-2 rounded-md focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white group">
                    <span class="sr-only">Abrir menú principal</span>
                    <svg class="h-7 w-7" :stroke="isScrolledPastImage || !hasHeroImage ? '#002873' : 'white'"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"
                            class="group-hover:stroke-[rgb(0,176,240)] transition-colors duration-200" />
                    </svg>
                </button>

                <a href="https://goo.gl/maps/your-dealership-location" target="_blank" rel="noopener noreferrer"
                    class="flex items-center group">
                    <svg class="h-5 w-5 mr-4 sm:mr-2"
                        :class="[isScrolledPastImage || !hasHeroImage ? 'text-[#002873]' : 'text-white', 'group-hover:text-[rgb(0,176,240)] transition-colors duration-200']"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                            class="group-hover:text-[rgb(0,176,240)] transition-colors duration-200" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                            class="group-hover:text-[rgb(0,176,240)] transition-colors duration-200" />
                    </svg>
                    <span
                        :class="[isScrolledPastImage || !hasHeroImage ? 'text-[#002873]' : 'text-white', 'hidden sm:inline-block group-hover:text-[rgb(0,176,240)] transition-colors duration-200']">Autos
                        de la Huasteca</span>
                </a>
            </div>
        </div>

        <div :class="[
            'relative transition-all duration-300 -mt-4',
            { 'opacity-0': !isLineVisible },
            isScrolledPastImage || !hasHeroImage ? 'text-[#002873]' : 'text-white'
        ]" >
            <div class="max-w-full  relative">
                <div class=" max-w-full flex items-center justify-center h-6" >
                    <div class="h-0.5 bg-current flex-grow sm:w-1/3 lg:w-1/3 md:w-1/3"></div>
                    <Link :href="route('welcome')" class=" flex-shrink-0" style="margin-left: 14px; margin-right: 14px;">
                    <svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" class="w-9 h-9"
                        :fill="isScrolledPastImage || !hasHeroImage ? 'currentColor' : 'white'">
                        <g
                            transform="matrix(10.188387870788574, 0, 0, 10.188387870788574, -251.519936680809, -252.79260253906244)">
                            <path
                                d="M75,120.4c-24.9,0-45.3-20.5-45.3-45.4c0-5.6,1-10.9,2.9-15.9l26.5,53.3c0.3,0.7,0.8,1.3,1.6,1.3 c0.8,0,1.3-0.6,1.6-1.3l12.2-27.3c0.1-0.3,0.3-0.6,0.6-0.6s0.4,0.3,0.6,0.6l12.2,27.3c0.3,0.7,0.8,1.3,1.6,1.3 c0.8,0,1.3-0.6,1.6-1.3l26.5-53.3c1.9,5,2.9,10.3,2.9,15.9C120.3,99.9,99.9,120.4,75,120.4z M75,64.7c-0.3,0-0.4-0.3-0.6-0.6 l-14.2-32c4.6-1.7,9.6-2.6,14.8-2.6c5.2,0,10.2,0.9,14.8,2.6l-14.2,32C75.4,64.5,75.3,64.7,75,64.7z M60.5,97.6 c-0.3,0-0.4-0.3-0.6-0.6l-23-46.4c4.1-6.3,9.6-11.6,16.3-15.3l16.6,36.9C70,72.8,70.5,73,71,73h8c0.6,0,1-0.1,1.3-0.8l16.6-36.9 c6.6,3.7,12.2,9,16.3,15.3L90,97c-0.1,0.3-0.3,0.6-0.6,0.6c-0.3,0-0.4-0.3-0.6-0.6l-8.7-19.8c-0.3-0.7-0.7-0.8-1.3-0.8h-8 c-0.6,0-1,0.1-1.3,0.8L61.1,97C61,97.3,60.8,97.6,60.5,97.6z M75,125c27.7,0,50-22.3,50-50c0-27.7-22.3-50-50-50 c-27.7,0-50,22.3-50,50C25,102.7,47.3,125,75,125z" />
                        </g>
                    </svg>
                    </Link>
                    <div class="h-0.5 bg-current flex-grow"></div>
                </div>
            </div>
        </div>
    </header>

    <!-- Menú móvil -->
    <div :class="[
        'fixed inset-y-0 left-0 w-1/4 max-sm:w-1/2 bg-blue-900 shadow-md transform transition-all duration-300 ease-in-out z-50',
        isMenuOpen ? 'translate-x-0' : '-translate-x-full'
    ]">
        <div class="flex flex-col h-full">
            <div class="flex justify-end p-4">
                <button @click="toggleMenu" class="text-white hover:text-blue-200 focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="flex-grow py-8 px-4">
                <Link :href="route('welcome')"
                    class="block py-2 text-lg text-white hover:bg-blue-700 rounded px-2 mb-2">
                Inicio
                </Link>
                <Link :href="route('autosnuevos')"
                    class="block py-2 text-lg text-white hover:bg-blue-700 rounded px-2 mb-2">
                Autos Nuevos
                </Link>
                <Link :href="route('seminuevos')"
                    class="block py-2 text-lg text-white hover:bg-blue-700 rounded px-2 mb-2">
                Seminuevos
                </Link>
                <Link :href="route('refacciones')"
                    class="block py-2 text-lg text-white hover:bg-blue-700 rounded px-2 mb-2">
                Refacciones
                </Link>
                <div class="relative">
                    <button @click="toggleSubMenu"
                        class="flex items-center justify-between w-full py-2 text-lg text-white hover:bg-blue-700 rounded px-2 mb-2">
                        <span>Servicios</span>
                        <svg class="h-4 w-4 ml-2" :class="{ 'transform rotate-180': isSubMenuOpen }"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div v-if="isSubMenuOpen" class="pl-4 mt-2 space-y-2">
                        <Link :href="route('mantenimiento')"
                            class="block py-2 text-base text-white hover:bg-blue-700 rounded px-2">
                         Precios de Mantenimiento
                        </Link>
                        <Link :href="route('garantia')"
                            class="block py-2 text-base text-white hover:bg-blue-700 rounded px-2">
                            Garantia
                        </Link>
                    </div>
                </div>

            </nav>
        </div>
    </div>

    <main class="">
        <slot />
    </main>
    </div>

    <!-- <footer >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <p class="text-center text-sm text-gray-500">
                &copy; 2024 Autos de la Huasteca. Todos los derechos reservados.
            </p>
        </div>
    </footer> -->

</template>

<style scoped>
.bg-image {
    position: relative;
}

.bg-image::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100px;
    background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 1) 100%);
}

@media (max-width: 640px) {
    .sm\:mx-0.mx-auto {
        margin-left: auto;
        margin-right: auto;
    }
}
</style>
