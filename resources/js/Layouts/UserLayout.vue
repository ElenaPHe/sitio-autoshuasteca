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
    return ['Welcome', 'Secciones/Garantia', 'Secciones/Mantenimiento', 'Secciones/ShowNuevos'].includes(page.component);
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

    isScrolledPastImage.value = scrollTop > imageHeight * 1;

    if (hasHeroImage.value) {
        if (scrollTop > imageHeight) {
            headerOpacity.value = Math.min((scrollTop - imageHeight) / 100, 0.6);
        } else {
            headerOpacity.value = 0;
        }
    } else {
        headerOpacity.value = 0.6;
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
    <div class="flex flex-col min-h-screen">
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
            ]">
                <div class="max-w-full  relative">
                    <div class=" max-w-full flex items-center justify-center h-6">
                        <div class="h-0.5 bg-current flex-grow sm:w-1/3 lg:w-1/3 md:w-1/3"></div>
                        <Link :href="route('welcome')" class=" flex-shrink-0"
                            style="margin-left: 14px; margin-right: 14px;">
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
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
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

        <main class="flex-grow">
            <slot />
        </main>
        
        <footer class="w-full font-vwtex" style="background-color: white; border-top: 2px solid; ">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!--Grid-->
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-6 gap-3 md:gap-8 py-10 max-sm:max-w-sm max-sm:mx-auto gap-y-8" style="border-bottom: 3px solid rgb(0, 30, 80);">
                    <div class="col-span-2 mb-10 lg:col-span-2 lg:mb-0">
                        <h1 class="text-center font-vwheadbold" style="font-size: 16px;">Matriz</h1>
                        <p class="py-8 text-gray-500 text-center lg:text-center font-vwheadlight" style="font-size: 10pt;">Carretera a Laredo S/N,<br> CP. 79090 <br>
                            Col. Las Lomas, Valles, San Luis Potosí</p>
                        <!-- <a href="javascript:;"  class="py-2.5 px-5 h-9 block w-fit bg-indigo-600 rounded-full shadow-sm text-xs text-white mx-auto transition-all  duration-500 hover:bg-indigo-700 lg:mx-0">
                            Contact us
                        </a> -->
                        <div class="flex justify-center items-center">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3699.9349131789236!2d-99.00498402566542!3d21.975460954593103!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d66d5b258e82a1%3A0x201d6854c4c661da!2sAutos%20De%20La%20Huasteca%2C%20S.A.%20De%20C.V.!5e0!3m2!1ses-419!2smx!4v1731187136228!5m2!1ses-419!2smx" width="300" height="150" style="border-radius: 10px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-auto h-auto justify-center"></iframe>
                        </div>

                    </div>
                    <!--End Col-->
                    <div class="lg:mx-auto text-center">
                        <h3 class=" text-gray-900 mb-7 font-vwheadbold" style="font-size: 16px;">Teléfonos y Horarios de Autos Nuevos</h3>

                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relative justify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" fill="#001E50" height="24px" width="24px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#001E50"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M400.716,274.634h41.717c19.101,0,34.641-15.54,34.641-34.641V171.74c0-16.355-11.397-30.09-26.665-33.703 c-13.248-37.843-37.764-71.676-69.849-96.092C344.5,14.505,301.427,0,256.001,0s-88.498,14.505-124.559,41.945 c-32.086,24.416-56.602,58.248-69.851,96.092c-15.267,3.614-26.665,17.348-26.665,33.703v68.252 c0,19.101,15.54,34.641,34.641,34.641h41.717c8.929,18.717,21.384,35.439,36.502,49.305 c-60.017,0.265-108.762,49.166-108.762,109.244V512h433.952v-78.817c0-60.078-48.746-108.98-108.762-109.244 C379.331,310.072,391.786,293.349,400.716,274.634z M446.658,171.739v68.253c0,2.329-1.895,4.224-4.224,4.224h-26.192v-38.349 c0-0.013,0-0.025,0-0.039c0-1.328-0.017-2.652-0.05-3.992c0-0.01-0.001-0.02-0.001-0.03c-0.004-0.152-0.011-0.304-0.015-0.456 c-0.006-0.156-0.01-0.312-0.016-0.468l-0.026-0.722c-0.025-0.766-0.053-1.53-0.089-2.276c0-0.005-0.001-0.01-0.001-0.014 c-0.018-0.37-0.044-0.739-0.065-1.109c-0.003-0.046-0.005-0.091-0.008-0.137l-0.053-0.85c-0.037-0.622-0.075-1.242-0.122-1.882 c0-0.003,0-0.005-0.001-0.008c-0.041-0.546-0.091-1.091-0.137-1.636l-0.042-0.48c-0.048-0.561-0.096-1.121-0.151-1.68 c-0.065-0.666-0.14-1.329-0.214-1.993l-0.041-0.362c-0.043-0.385-0.088-0.771-0.134-1.157c-0.102-0.849-0.213-1.694-0.328-2.538 l-0.042-0.306c-0.069-0.502-0.138-1.004-0.211-1.492c-0.109-0.73-0.225-1.456-0.344-2.183c-0.08-0.496-0.16-0.984-0.24-1.449 c-0.635-3.688-1.398-7.332-2.28-10.929c-0.013-0.054-0.026-0.109-0.04-0.163h30.842 C444.763,167.515,446.658,169.41,446.658,171.739z M100.362,167.71c-0.924,3.766-1.712,7.582-2.364,11.445 c-0.043,0.259-0.087,0.516-0.129,0.775l-0.027,0.167c-0.39,2.402-0.725,4.822-1.007,7.26c-0.019,0.17-0.041,0.341-0.059,0.512 l-0.014,0.124c-0.074,0.66-0.15,1.32-0.215,1.982c0,0.002,0,0.004-0.001,0.007c-0.059,0.593-0.109,1.189-0.16,1.786l-0.04,0.464 c-0.05,0.593-0.103,1.185-0.147,1.779c-0.043,0.585-0.078,1.172-0.115,1.759l-0.053,0.86c0,0.008-0.001,0.016-0.001,0.023 c-0.024,0.428-0.053,0.856-0.074,1.285c-0.039,0.788-0.066,1.579-0.092,2.37l-0.018,0.489c-0.003,0.085-0.005,0.164-0.008,0.248 c-0.047,1.605-0.078,3.209-0.078,4.821v38.349H69.568c-2.329,0-4.224-1.895-4.224-4.224v-68.252c0-2.329,1.895-4.224,4.224-4.224 h30.842C100.394,167.58,100.379,167.646,100.362,167.71z M94.562,137.1c11.91-27.801,31.076-52.516,55.299-70.949 c30.72-23.378,67.423-35.734,106.14-35.734s75.419,12.356,106.141,35.734c24.223,18.433,43.388,43.148,55.298,70.949h-16.723 c-25.783-54.041-80.957-91.475-144.716-91.475S137.068,83.059,111.285,137.1H94.562z M365.942,136.902 c-18.028,12.356-39.456,19.077-61.526,19.077c-29.098,0-56.45-11.335-77.018-31.919l-10.013-10.021l-10.706,9.278 c-15.003,13.002-34.214,20.164-54.096,20.164c-3.379,0-6.737-0.207-10.06-0.61c22.196-39.825,64.74-66.827,113.478-66.827 C302.264,76.043,342.945,100.372,365.942,136.902z M442.56,433.183v48.4H69.442v-48.4c0-43.469,35.364-78.833,78.833-78.833 h35.241v3.828c0,39.968,32.516,72.484,72.484,72.484c39.968,0,72.484-32.516,72.484-72.484v-3.828h35.241 C407.196,354.35,442.56,389.714,442.56,433.183z M214,360.547c0.038,0.01,0.075,0.018,0.113,0.028 c1.48,0.401,2.968,0.774,4.459,1.132c0.442,0.106,0.886,0.208,1.329,0.31c1.192,0.275,2.388,0.536,3.587,0.784 c0.388,0.08,0.775,0.164,1.163,0.241c1.54,0.306,3.084,0.591,4.635,0.851c0.293,0.05,0.587,0.091,0.881,0.139 c1.285,0.208,2.572,0.401,3.864,0.577c0.461,0.063,0.924,0.125,1.386,0.183c1.306,0.167,2.616,0.318,3.928,0.454 c0.282,0.029,0.563,0.064,0.845,0.091c1.086,0.105,2.175,0.196,3.264,0.28c0.1,0.008,0.2,0.017,0.3,0.025 c0.386,0.029,0.774,0.057,1.161,0.083c0.407,0.027,0.813,0.049,1.221,0.073c0.369,0.022,0.738,0.047,1.108,0.066 c0.208,0.011,0.414,0.026,0.622,0.038c0.654,0.032,1.31,0.054,1.966,0.078c0.453,0.017,0.907,0.035,1.362,0.049 c0.253,0.007,0.505,0.02,0.758,0.026c1.347,0.033,2.698,0.052,4.052,0.052c1.354,0,2.704-0.018,4.052-0.052 c0.253-0.006,0.505-0.019,0.758-0.026c0.454-0.013,0.907-0.031,1.362-0.049c0.655-0.024,1.312-0.046,1.966-0.078 c0.208-0.01,0.414-0.026,0.622-0.038c0.37-0.02,0.739-0.044,1.108-0.066c0.407-0.024,0.814-0.045,1.221-0.073 c0.387-0.026,0.775-0.054,1.161-0.083c0.1-0.008,0.2-0.017,0.3-0.025c1.09-0.084,2.178-0.174,3.264-0.28 c0.282-0.027,0.563-0.063,0.845-0.091c1.312-0.135,2.622-0.287,3.928-0.454c0.462-0.059,0.925-0.121,1.386-0.183 c1.291-0.176,2.579-0.369,3.864-0.577c0.293-0.048,0.588-0.089,0.881-0.139c1.55-0.261,3.094-0.545,4.635-0.851 c0.388-0.077,0.776-0.161,1.163-0.241c1.198-0.247,2.395-0.508,3.587-0.784c0.443-0.102,0.887-0.204,1.329-0.31 c1.491-0.358,2.979-0.73,4.459-1.132c0.034-0.01,0.073-0.018,0.111-0.028c-1.231,22.099-19.599,39.698-42.001,39.698 S215.231,382.646,214,360.547z M295.658,275.305c-5.582-10.919-16.937-18.416-30.018-18.416h-19.28 c-18.581,0-33.697,15.117-33.697,33.698c0,18.582,15.116,33.698,33.697,33.698h19.28c13.14,0,24.54-7.565,30.094-18.564 l43.462-0.277c-22.546,18.868-51.565,30.244-83.195,30.244c-71.586,0.001-129.823-58.238-129.823-129.823 c0-1.087,0.014-2.17,0.043-3.28l0.047-1.279c0.021-0.647,0.042-1.293,0.073-1.924c0.014-0.275,0.031-0.549,0.049-0.822 l0.032-0.528c0.037-0.614,0.072-1.23,0.118-1.842c0-0.006,0.001-0.012,0.001-0.017c0.025-0.35,0.057-0.698,0.087-1.046 l0.056-0.641c0.045-0.513,0.086-1.028,0.137-1.54c0.042-0.409,0.087-0.815,0.133-1.223l0.04-0.356 c0.039-0.348,0.078-0.696,0.12-1.042c0.019-0.169,0.036-0.335,0.059-0.507c0.06-0.481,0.125-0.959,0.191-1.438l0.028-0.207 c0.01-0.078,0.022-0.157,0.032-0.235c0.059-0.427,0.117-0.855,0.18-1.281c0.079-0.525,0.163-1.047,0.243-1.545 c0.084-0.518,0.168-1.036,0.259-1.553c0.095-0.554,0.198-1.106,0.303-1.665c0.086-0.458,0.173-0.916,0.264-1.372 c0.112-0.568,0.23-1.136,0.354-1.718c0.093-0.438,0.189-0.875,0.286-1.312c0.132-0.593,0.269-1.185,0.409-1.769 c0.104-0.438,0.212-0.875,0.32-1.311c0.142-0.569,0.287-1.135,0.432-1.687c0.085-0.322,0.174-0.643,0.262-0.964 c7.166,1.406,14.47,2.135,21.85,2.135c22.63,0,44.63-6.784,63.208-19.313c24.895,20.604,55.898,31.812,88.625,31.812 c26.607,0,52.499-7.617,74.701-21.727c0.127,0.38,0.253,0.767,0.384,1.172l0.109,0.336c0.057,0.176,0.117,0.352,0.172,0.529 c0.192,0.602,0.375,1.208,0.557,1.812c0.114,0.378,0.228,0.757,0.339,1.137c0.177,0.61,0.35,1.225,0.52,1.847 c0.108,0.393,0.216,0.788,0.321,1.183c0.154,0.581,0.303,1.166,0.453,1.769c0.108,0.434,0.215,0.868,0.319,1.304 c0.136,0.572,0.27,1.147,0.404,1.749c0.098,0.44,0.195,0.881,0.289,1.323c0.119,0.558,0.234,1.116,0.348,1.686 c0.097,0.489,0.191,0.978,0.282,1.468c0.099,0.532,0.199,1.067,0.297,1.643c0.008,0.048,0.016,0.096,0.024,0.144 c0.075,0.434,0.147,0.87,0.217,1.306c0.085,0.527,0.17,1.055,0.251,1.595c0.084,0.563,0.161,1.128,0.237,1.693l0.005,0.039 c0.064,0.47,0.128,0.94,0.186,1.408c0.065,0.523,0.122,1.049,0.18,1.575l0.049,0.439c0.044,0.38,0.086,0.76,0.124,1.144 c0.016,0.159,0.028,0.32,0.043,0.48c0.034,0.358,0.065,0.716,0.095,1.074l0.053,0.602c0.03,0.344,0.061,0.686,0.085,1.012 c0.049,0.657,0.086,1.317,0.126,1.976l0.028,0.455c0.016,0.258,0.034,0.515,0.047,0.791c0.042,0.843,0.071,1.688,0.096,2.536 l0.024,0.669c0.027,1.089,0.042,2.181,0.042,3.277c0,0.008,0,0.015,0,0.023c0,25.333-7.301,48.991-19.9,68.992L295.658,275.305z M268.921,290.589c0,1.81-1.471,3.281-3.28,3.281h-19.28c-1.809,0-3.28-1.472-3.28-3.281c0-1.809,1.471-3.281,3.28-3.281h19.28 C267.45,287.308,268.921,288.78,268.921,290.589z"></path> </g> </g> </g></svg>
                            </div>
                            <div class="relative inline-block text-start" style="width: 80%;">
                                <p class="font-vwheadbold " style="font-size: 13px;">Conmutador:</p>
                                <p class="font-vwheadlight" style="font-size: 14px;">481 381 1550</p>
                            </div>
                        </div>

                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relativejustify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" width="30px" height="30px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 31C23.732 31 30 24.732 30 17C30 9.26801 23.732 3 16 3C8.26801 3 2 9.26801 2 17C2 19.5109 2.661 21.8674 3.81847 23.905L2 31L9.31486 29.3038C11.3014 30.3854 13.5789 31 16 31ZM16 28.8462C22.5425 28.8462 27.8462 23.5425 27.8462 17C27.8462 10.4576 22.5425 5.15385 16 5.15385C9.45755 5.15385 4.15385 10.4576 4.15385 17C4.15385 19.5261 4.9445 21.8675 6.29184 23.7902L5.23077 27.7692L9.27993 26.7569C11.1894 28.0746 13.5046 28.8462 16 28.8462Z" fill="#BFC8D0"></path> <path d="M28 16C28 22.6274 22.6274 28 16 28C13.4722 28 11.1269 27.2184 9.19266 25.8837L5.09091 26.9091L6.16576 22.8784C4.80092 20.9307 4 18.5589 4 16C4 9.37258 9.37258 4 16 4C22.6274 4 28 9.37258 28 16Z" fill="url(#paint0_linear_87_7264)"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 18.5109 2.661 20.8674 3.81847 22.905L2 30L9.31486 28.3038C11.3014 29.3854 13.5789 30 16 30ZM16 27.8462C22.5425 27.8462 27.8462 22.5425 27.8462 16C27.8462 9.45755 22.5425 4.15385 16 4.15385C9.45755 4.15385 4.15385 9.45755 4.15385 16C4.15385 18.5261 4.9445 20.8675 6.29184 22.7902L5.23077 26.7692L9.27993 25.7569C11.1894 27.0746 13.5046 27.8462 16 27.8462Z" fill="white"></path> <path d="M12.5 9.49989C12.1672 8.83131 11.6565 8.8905 11.1407 8.8905C10.2188 8.8905 8.78125 9.99478 8.78125 12.05C8.78125 13.7343 9.52345 15.578 12.0244 18.3361C14.438 20.9979 17.6094 22.3748 20.2422 22.3279C22.875 22.2811 23.4167 20.0154 23.4167 19.2503C23.4167 18.9112 23.2062 18.742 23.0613 18.696C22.1641 18.2654 20.5093 17.4631 20.1328 17.3124C19.7563 17.1617 19.5597 17.3656 19.4375 17.4765C19.0961 17.8018 18.4193 18.7608 18.1875 18.9765C17.9558 19.1922 17.6103 19.083 17.4665 19.0015C16.9374 18.7892 15.5029 18.1511 14.3595 17.0426C12.9453 15.6718 12.8623 15.2001 12.5959 14.7803C12.3828 14.4444 12.5392 14.2384 12.6172 14.1483C12.9219 13.7968 13.3426 13.254 13.5313 12.9843C13.7199 12.7145 13.5702 12.305 13.4803 12.05C13.0938 10.953 12.7663 10.0347 12.5 9.49989Z" fill="white"></path> <defs> <linearGradient id="paint0_linear_87_7264" x1="26.5" y1="7" x2="4" y2="28" gradientUnits="userSpaceOnUse"> <stop stop-color="#5BD066"></stop> <stop offset="1" stop-color="#27B43E"></stop> </linearGradient> </defs> </g></svg>
                            </div>
                            <div class="relative inline-block  text-start" style="width: 80%;">
                                <p class="font-vwheadbold"  style="font-size: 13px;">WhatsApp:</p>
                                <a href="#" class="font-vwheadlight" style="font-size: 14px;">481 103 7976</a>
                            </div>
                        </div>

                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relative justify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#001e50"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 7V12L9.5 10.5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#001E50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </div>
                            <div class="relative inline-block text-start" style="width: 80%;">
                                <p class="font-vwheadbold" style="font-size: 13px;">Lunes - Viernes:</p>
                                <p class="font-vwheadlight" style="font-size: 14px;">08:30 am - 7:00 pm</p>
                            </div>
                        </div>

                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relative justify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#001e50"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 7V12L9.5 10.5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#001E50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </div>
                            <div class="relative inline-block text-start" style="width: 80%;">
                                <p class="font-vwheadbold" style="font-size: 13px;">Sábado:</p>
                                <p class="font-vwheadlight" style="font-size: 14px;">08:30 am - 2:30 pm</p>
                            </div>
                        </div>
                    </div>

                    <div class="lg:mx-auto text-center">
                        <h3 class=" text-gray-900 mb-7 font-vwheadbold" style="font-size: 16px;">Teléfonos y Horarios de Servicio</h3>

                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relativejustify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" width="30px" height="30px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 31C23.732 31 30 24.732 30 17C30 9.26801 23.732 3 16 3C8.26801 3 2 9.26801 2 17C2 19.5109 2.661 21.8674 3.81847 23.905L2 31L9.31486 29.3038C11.3014 30.3854 13.5789 31 16 31ZM16 28.8462C22.5425 28.8462 27.8462 23.5425 27.8462 17C27.8462 10.4576 22.5425 5.15385 16 5.15385C9.45755 5.15385 4.15385 10.4576 4.15385 17C4.15385 19.5261 4.9445 21.8675 6.29184 23.7902L5.23077 27.7692L9.27993 26.7569C11.1894 28.0746 13.5046 28.8462 16 28.8462Z" fill="#BFC8D0"></path> <path d="M28 16C28 22.6274 22.6274 28 16 28C13.4722 28 11.1269 27.2184 9.19266 25.8837L5.09091 26.9091L6.16576 22.8784C4.80092 20.9307 4 18.5589 4 16C4 9.37258 9.37258 4 16 4C22.6274 4 28 9.37258 28 16Z" fill="url(#paint0_linear_87_7264)"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 18.5109 2.661 20.8674 3.81847 22.905L2 30L9.31486 28.3038C11.3014 29.3854 13.5789 30 16 30ZM16 27.8462C22.5425 27.8462 27.8462 22.5425 27.8462 16C27.8462 9.45755 22.5425 4.15385 16 4.15385C9.45755 4.15385 4.15385 9.45755 4.15385 16C4.15385 18.5261 4.9445 20.8675 6.29184 22.7902L5.23077 26.7692L9.27993 25.7569C11.1894 27.0746 13.5046 27.8462 16 27.8462Z" fill="white"></path> <path d="M12.5 9.49989C12.1672 8.83131 11.6565 8.8905 11.1407 8.8905C10.2188 8.8905 8.78125 9.99478 8.78125 12.05C8.78125 13.7343 9.52345 15.578 12.0244 18.3361C14.438 20.9979 17.6094 22.3748 20.2422 22.3279C22.875 22.2811 23.4167 20.0154 23.4167 19.2503C23.4167 18.9112 23.2062 18.742 23.0613 18.696C22.1641 18.2654 20.5093 17.4631 20.1328 17.3124C19.7563 17.1617 19.5597 17.3656 19.4375 17.4765C19.0961 17.8018 18.4193 18.7608 18.1875 18.9765C17.9558 19.1922 17.6103 19.083 17.4665 19.0015C16.9374 18.7892 15.5029 18.1511 14.3595 17.0426C12.9453 15.6718 12.8623 15.2001 12.5959 14.7803C12.3828 14.4444 12.5392 14.2384 12.6172 14.1483C12.9219 13.7968 13.3426 13.254 13.5313 12.9843C13.7199 12.7145 13.5702 12.305 13.4803 12.05C13.0938 10.953 12.7663 10.0347 12.5 9.49989Z" fill="white"></path> <defs> <linearGradient id="paint0_linear_87_7264" x1="26.5" y1="7" x2="4" y2="28" gradientUnits="userSpaceOnUse"> <stop stop-color="#5BD066"></stop> <stop offset="1" stop-color="#27B43E"></stop> </linearGradient> </defs> </g></svg>
                            </div>
                            <div class="relative inline-block  text-start" style="width: 80%;">
                                <p class="font-vwheadbold"  style="font-size: 13px;">WhatsApp:</p>
                                <a href="https://wa.me/524811037927?text=Me%20pudiera%20atender%20v%C3%ADa%20WhatsApp?" target="_blank" class="font-vwheadlight" style="font-size: 14px;">481 103 7927</a>
                            </div>
                        </div>

                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relative justify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#001e50"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 7V12L9.5 10.5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#001E50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </div>
                            <div class="relative inline-block text-start" style="width: 80%;">
                                <p class="font-vwheadbold" style="font-size: 13px;">Lunes - Viernes:</p>
                                <p class="font-vwheadlight" style="font-size: 14px;">08:30 am - 7:00 pm</p>
                            </div>
                        </div>

                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relative justify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#001e50"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 7V12L9.5 10.5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#001E50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </div>
                            <div class="relative inline-block text-start" style="width: 80%;">
                                <p class="font-vwheadbold" style="font-size: 13px;">Sábado:</p>
                                <p class="font-vwheadlight" style="font-size: 14px;">08:30 am - 2:30 pm</p>
                            </div>
                        </div>
                    </div>

                    <!--End Col-->
                    <div class="lg:mx-auto text-center">
                        <h3 class=" text-gray-900 mb-7 font-vwheadbold" style="font-size: 16px;">Teléfonos y Horarios de Refacciones</h3>



                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relativejustify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" width="30px" height="30px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 31C23.732 31 30 24.732 30 17C30 9.26801 23.732 3 16 3C8.26801 3 2 9.26801 2 17C2 19.5109 2.661 21.8674 3.81847 23.905L2 31L9.31486 29.3038C11.3014 30.3854 13.5789 31 16 31ZM16 28.8462C22.5425 28.8462 27.8462 23.5425 27.8462 17C27.8462 10.4576 22.5425 5.15385 16 5.15385C9.45755 5.15385 4.15385 10.4576 4.15385 17C4.15385 19.5261 4.9445 21.8675 6.29184 23.7902L5.23077 27.7692L9.27993 26.7569C11.1894 28.0746 13.5046 28.8462 16 28.8462Z" fill="#BFC8D0"></path> <path d="M28 16C28 22.6274 22.6274 28 16 28C13.4722 28 11.1269 27.2184 9.19266 25.8837L5.09091 26.9091L6.16576 22.8784C4.80092 20.9307 4 18.5589 4 16C4 9.37258 9.37258 4 16 4C22.6274 4 28 9.37258 28 16Z" fill="url(#paint0_linear_87_7264)"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 18.5109 2.661 20.8674 3.81847 22.905L2 30L9.31486 28.3038C11.3014 29.3854 13.5789 30 16 30ZM16 27.8462C22.5425 27.8462 27.8462 22.5425 27.8462 16C27.8462 9.45755 22.5425 4.15385 16 4.15385C9.45755 4.15385 4.15385 9.45755 4.15385 16C4.15385 18.5261 4.9445 20.8675 6.29184 22.7902L5.23077 26.7692L9.27993 25.7569C11.1894 27.0746 13.5046 27.8462 16 27.8462Z" fill="white"></path> <path d="M12.5 9.49989C12.1672 8.83131 11.6565 8.8905 11.1407 8.8905C10.2188 8.8905 8.78125 9.99478 8.78125 12.05C8.78125 13.7343 9.52345 15.578 12.0244 18.3361C14.438 20.9979 17.6094 22.3748 20.2422 22.3279C22.875 22.2811 23.4167 20.0154 23.4167 19.2503C23.4167 18.9112 23.2062 18.742 23.0613 18.696C22.1641 18.2654 20.5093 17.4631 20.1328 17.3124C19.7563 17.1617 19.5597 17.3656 19.4375 17.4765C19.0961 17.8018 18.4193 18.7608 18.1875 18.9765C17.9558 19.1922 17.6103 19.083 17.4665 19.0015C16.9374 18.7892 15.5029 18.1511 14.3595 17.0426C12.9453 15.6718 12.8623 15.2001 12.5959 14.7803C12.3828 14.4444 12.5392 14.2384 12.6172 14.1483C12.9219 13.7968 13.3426 13.254 13.5313 12.9843C13.7199 12.7145 13.5702 12.305 13.4803 12.05C13.0938 10.953 12.7663 10.0347 12.5 9.49989Z" fill="white"></path> <defs> <linearGradient id="paint0_linear_87_7264" x1="26.5" y1="7" x2="4" y2="28" gradientUnits="userSpaceOnUse"> <stop stop-color="#5BD066"></stop> <stop offset="1" stop-color="#27B43E"></stop> </linearGradient> </defs> </g></svg>
                            </div>
                            <div class="relative inline-block  text-start" style="width: 80%;">
                                <p class="font-vwheadbold"  style="font-size: 13px;">WhatsApp:</p>
                                <a href="https://wa.me/524811037970?text=Me%20pudiera%20atender%20v%C3%ADa%20WhatsApp?" target="_blank" class="font-vwheadlight" style="font-size: 14px;">481 103 7970</a>

                            </div>
                        </div>

                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relative justify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#001e50"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 7V12L9.5 10.5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#001E50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </div>
                            <div class="relative inline-block text-start" style="width: 80%;">
                                <p class="font-vwheadbold" style="font-size: 13px;">Lunes - Viernes:</p>
                                <p class="font-vwheadlight" style="font-size: 14px;">08:30 am - 7:00 pm</p>
                            </div>
                        </div>

                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relative justify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#001e50"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 7V12L9.5 10.5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#001E50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </div>
                            <div class="relative inline-block text-start" style="width: 80%;">
                                <p class="font-vwheadbold" style="font-size: 13px;">Sábado:</p>
                                <p class="font-vwheadlight" style="font-size: 14px;">08:30 am - 2:30 pm</p>
                            </div>
                        </div>
                    </div>

                    <div class="lg:mx-auto text-center">
                        <h3 class=" text-gray-900 mb-7 font-vwheadbold" style="font-size: 16px;">Teléfonos y Horarios de Seminuevos</h3>

                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relativejustify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" width="30px" height="30px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 31C23.732 31 30 24.732 30 17C30 9.26801 23.732 3 16 3C8.26801 3 2 9.26801 2 17C2 19.5109 2.661 21.8674 3.81847 23.905L2 31L9.31486 29.3038C11.3014 30.3854 13.5789 31 16 31ZM16 28.8462C22.5425 28.8462 27.8462 23.5425 27.8462 17C27.8462 10.4576 22.5425 5.15385 16 5.15385C9.45755 5.15385 4.15385 10.4576 4.15385 17C4.15385 19.5261 4.9445 21.8675 6.29184 23.7902L5.23077 27.7692L9.27993 26.7569C11.1894 28.0746 13.5046 28.8462 16 28.8462Z" fill="#BFC8D0"></path> <path d="M28 16C28 22.6274 22.6274 28 16 28C13.4722 28 11.1269 27.2184 9.19266 25.8837L5.09091 26.9091L6.16576 22.8784C4.80092 20.9307 4 18.5589 4 16C4 9.37258 9.37258 4 16 4C22.6274 4 28 9.37258 28 16Z" fill="url(#paint0_linear_87_7264)"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 30C23.732 30 30 23.732 30 16C30 8.26801 23.732 2 16 2C8.26801 2 2 8.26801 2 16C2 18.5109 2.661 20.8674 3.81847 22.905L2 30L9.31486 28.3038C11.3014 29.3854 13.5789 30 16 30ZM16 27.8462C22.5425 27.8462 27.8462 22.5425 27.8462 16C27.8462 9.45755 22.5425 4.15385 16 4.15385C9.45755 4.15385 4.15385 9.45755 4.15385 16C4.15385 18.5261 4.9445 20.8675 6.29184 22.7902L5.23077 26.7692L9.27993 25.7569C11.1894 27.0746 13.5046 27.8462 16 27.8462Z" fill="white"></path> <path d="M12.5 9.49989C12.1672 8.83131 11.6565 8.8905 11.1407 8.8905C10.2188 8.8905 8.78125 9.99478 8.78125 12.05C8.78125 13.7343 9.52345 15.578 12.0244 18.3361C14.438 20.9979 17.6094 22.3748 20.2422 22.3279C22.875 22.2811 23.4167 20.0154 23.4167 19.2503C23.4167 18.9112 23.2062 18.742 23.0613 18.696C22.1641 18.2654 20.5093 17.4631 20.1328 17.3124C19.7563 17.1617 19.5597 17.3656 19.4375 17.4765C19.0961 17.8018 18.4193 18.7608 18.1875 18.9765C17.9558 19.1922 17.6103 19.083 17.4665 19.0015C16.9374 18.7892 15.5029 18.1511 14.3595 17.0426C12.9453 15.6718 12.8623 15.2001 12.5959 14.7803C12.3828 14.4444 12.5392 14.2384 12.6172 14.1483C12.9219 13.7968 13.3426 13.254 13.5313 12.9843C13.7199 12.7145 13.5702 12.305 13.4803 12.05C13.0938 10.953 12.7663 10.0347 12.5 9.49989Z" fill="white"></path> <defs> <linearGradient id="paint0_linear_87_7264" x1="26.5" y1="7" x2="4" y2="28" gradientUnits="userSpaceOnUse"> <stop stop-color="#5BD066"></stop> <stop offset="1" stop-color="#27B43E"></stop> </linearGradient> </defs> </g></svg>
                            </div>
                            <div class="relative inline-block  text-start" style="width: 80%;">
                                <p class="font-vwheadbold"  style="font-size: 13px;">WhatsApp:</p>
                                <a href="https://wa.me/524811037880?text=Me%20pudiera%20atender%20v%C3%ADa%20WhatsApp?" target="_blank" class="font-vwheadlight" style="font-size: 14px;">481 103 7880</a>
                            </div>
                        </div>

                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relative justify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#001e50"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 7V12L9.5 10.5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#001E50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </div>
                            <div class="relative inline-block text-start" style="width: 80%;">
                                <p class="font-vwheadbold" style="font-size: 13px;">Lunes - Viernes:</p>
                                <p class="font-vwheadlight" style="font-size: 14px;">08:30 am - 7:00 pm</p>
                            </div>
                        </div>

                        <div class="flex relative" style="margin-bottom: 13px;">
                            <div class="relative justify-center items-center" style="width: 20%; display: flex; display: inline-block;">
                                <svg style="position: relative; margin: auto; top: 10px;" width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#001e50"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 7V12L9.5 10.5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="#001E50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            </div>
                            <div class="relative inline-block text-start" style="width: 80%;">
                                <p class="font-vwheadbold" style="font-size: 13px;">Sábado:</p>
                                <p class="font-vwheadlight" style="font-size: 14px;">08:30 am - 2:30 pm</p>
                            </div>
                        </div>
                    </div>

                </div>
                <!--Grid-->
                <div class="py-7 border-t border-gray-200">
                    <div class="flex items-center justify-center flex-col lg:justify-between lg:flex-row text-center">
                        <span class="text-sm text-gray-500 ">Autos de la Huasteca 2024 | Volkwagen | Asociación Nacional de Concesionarios del Grupo Volkswagen, A.C 2024.</span>
                        <div class="flex mt-4 space-x-4 sm:justify-center lg:mt-0 ">

                            <a href="https://www.facebook.com/distribuidorautosdelahuasteca/" target="_blank" class="w-9 h-9 rounded-full  flex justify-center items-center">
                                <svg width="64px" height="64px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill="#1877F2" d="M15 8a7 7 0 00-7-7 7 7 0 00-1.094 13.915v-4.892H5.13V8h1.777V6.458c0-1.754 1.045-2.724 2.644-2.724.766 0 1.567.137 1.567.137v1.723h-.883c-.87 0-1.14.54-1.14 1.093V8h1.941l-.31 2.023H9.094v4.892A7.001 7.001 0 0015 8z"></path><path fill="#ffffff" d="M10.725 10.023L11.035 8H9.094V6.687c0-.553.27-1.093 1.14-1.093h.883V3.87s-.801-.137-1.567-.137c-1.6 0-2.644.97-2.644 2.724V8H5.13v2.023h1.777v4.892a7.037 7.037 0 002.188 0v-4.892h1.63z"></path></g></svg>

                            </a>

                            <a href="https://www.instagram.com/volkswagen_huasteca/" target="_blank" class="w-9 h-9 rounded-full  flex justify-center items-center">
                                <svg width="64px" height="64px" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <rect x="2" y="2" width="28" height="28" rx="6" fill="url(#paint0_radial_87_7153)"></rect> <rect x="2" y="2" width="28" height="28" rx="6" fill="url(#paint1_radial_87_7153)"></rect> <rect x="2" y="2" width="28" height="28" rx="6" fill="url(#paint2_radial_87_7153)"></rect> <path d="M23 10.5C23 11.3284 22.3284 12 21.5 12C20.6716 12 20 11.3284 20 10.5C20 9.67157 20.6716 9 21.5 9C22.3284 9 23 9.67157 23 10.5Z" fill="white"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M16 21C18.7614 21 21 18.7614 21 16C21 13.2386 18.7614 11 16 11C13.2386 11 11 13.2386 11 16C11 18.7614 13.2386 21 16 21ZM16 19C17.6569 19 19 17.6569 19 16C19 14.3431 17.6569 13 16 13C14.3431 13 13 14.3431 13 16C13 17.6569 14.3431 19 16 19Z" fill="white"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6 15.6C6 12.2397 6 10.5595 6.65396 9.27606C7.2292 8.14708 8.14708 7.2292 9.27606 6.65396C10.5595 6 12.2397 6 15.6 6H16.4C19.7603 6 21.4405 6 22.7239 6.65396C23.8529 7.2292 24.7708 8.14708 25.346 9.27606C26 10.5595 26 12.2397 26 15.6V16.4C26 19.7603 26 21.4405 25.346 22.7239C24.7708 23.8529 23.8529 24.7708 22.7239 25.346C21.4405 26 19.7603 26 16.4 26H15.6C12.2397 26 10.5595 26 9.27606 25.346C8.14708 24.7708 7.2292 23.8529 6.65396 22.7239C6 21.4405 6 19.7603 6 16.4V15.6ZM15.6 8H16.4C18.1132 8 19.2777 8.00156 20.1779 8.0751C21.0548 8.14674 21.5032 8.27659 21.816 8.43597C22.5686 8.81947 23.1805 9.43139 23.564 10.184C23.7234 10.4968 23.8533 10.9452 23.9249 11.8221C23.9984 12.7223 24 13.8868 24 15.6V16.4C24 18.1132 23.9984 19.2777 23.9249 20.1779C23.8533 21.0548 23.7234 21.5032 23.564 21.816C23.1805 22.5686 22.5686 23.1805 21.816 23.564C21.5032 23.7234 21.0548 23.8533 20.1779 23.9249C19.2777 23.9984 18.1132 24 16.4 24H15.6C13.8868 24 12.7223 23.9984 11.8221 23.9249C10.9452 23.8533 10.4968 23.7234 10.184 23.564C9.43139 23.1805 8.81947 22.5686 8.43597 21.816C8.27659 21.5032 8.14674 21.0548 8.0751 20.1779C8.00156 19.2777 8 18.1132 8 16.4V15.6C8 13.8868 8.00156 12.7223 8.0751 11.8221C8.14674 10.9452 8.27659 10.4968 8.43597 10.184C8.81947 9.43139 9.43139 8.81947 10.184 8.43597C10.4968 8.27659 10.9452 8.14674 11.8221 8.0751C12.7223 8.00156 13.8868 8 15.6 8Z" fill="white"></path> <defs> <radialGradient id="paint0_radial_87_7153" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(12 23) rotate(-55.3758) scale(25.5196)"> <stop stop-color="#B13589"></stop> <stop offset="0.79309" stop-color="#C62F94"></stop> <stop offset="1" stop-color="#8A3AC8"></stop> </radialGradient> <radialGradient id="paint1_radial_87_7153" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(11 31) rotate(-65.1363) scale(22.5942)"> <stop stop-color="#E0E8B7"></stop> <stop offset="0.444662" stop-color="#FB8A2E"></stop> <stop offset="0.71474" stop-color="#E2425C"></stop> <stop offset="1" stop-color="#E2425C" stop-opacity="0"></stop> </radialGradient> <radialGradient id="paint2_radial_87_7153" cx="0" cy="0" r="1" gradientUnits="userSpaceOnUse" gradientTransform="translate(0.500002 3) rotate(-8.1301) scale(38.8909 8.31836)"> <stop offset="0.156701" stop-color="#406ADC"></stop> <stop offset="0.467799" stop-color="#6A45BE"></stop> <stop offset="1" stop-color="#6A45BE" stop-opacity="0"></stop> </radialGradient> </defs> </g></svg>

                            </a>
                            <a href="https://twitter.com/2302VWHUASTECA?lang=es" target="_blank"  class="w-9 h-9 rounded-full flex justify-center items-center bg-black">
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>

                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </footer>



    </div>



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
