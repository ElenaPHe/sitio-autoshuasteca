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
  return ['Welcome', 'Secciones/Servicios'].includes(page.component);
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

  // Invertir la lógica de visibilidad
  if (scrollTop > lastScrollTop.value || scrollTop <= 0) {
    isLineVisible.value = false;
  } else {
    isLineVisible.value = true;
  }

  lastScrollTop.value = scrollTop <= 0 ? 0 : scrollTop;

  isScrolledPastImage.value = scrollTop > imageHeight * 0.95;

  if (hasHeroImage.value) {
    if (scrollTop > imageHeight) {
      headerOpacity.value = Math.min((scrollTop - imageHeight) / 100, 0.95);
    } else {
      headerOpacity.value = 0;
    }
  } else {
    headerOpacity.value = 0.95;
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
      'fixed top-0 left-0 right-0 z-50 transition-all duration-300',
      {'opacity-0 translate-y-[-20px]': !isPageLoaded, 'opacity-100 translate-y-0': isPageLoaded}
    ]"
    :style="{ backgroundColor: `rgba(255, 255, 255, ${headerOpacity})` }">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <button @click="toggleMenu" class="mr-2 rounded-md focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white group">
            <span class="sr-only">Abrir menú principal</span>
            <svg class="h-6 w-6" :stroke="isScrolledPastImage || !hasHeroImage ? 'currentColor' : 'white'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" class="group-hover:stroke-blue-600 transition-colors duration-200" />
            </svg>
          </button>

          <a href="https://maps.app.goo.gl/WbUcf9nLRv3Pitut6" target="_blank" rel="noopener noreferrer" class="flex items-center group">
            <svg class="h-5 w-5 mr-1 sm:mr-2" :class="[isScrolledPastImage || !hasHeroImage ? 'text-blue-900' : 'text-white', 'group-hover:text-blue-600 transition-colors duration-200']" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" class="group-hover:text-blue-600 transition-colors duration-200" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" class="group-hover:text-blue-600 transition-colors duration-200" />
            </svg>
            <span :class="[isScrolledPastImage || !hasHeroImage ? 'text-blue-900' : 'text-white', 'hidden sm:inline-block group-hover:text-blue-600 transition-colors duration-200']">Autos de la Huasteca</span>
          </a>
        </div>
      </div>

      <div :class="[
        'relative transition-all duration-300 mt-2',
        {'opacity-0': !isLineVisible},
        isScrolledPastImage || !hasHeroImage ? 'text-blue-900' : 'text-white'
      ]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
          <div class="flex items-center justify-center h-6">
            <div class="h-px bg-current flex-grow"></div>
            <Link :href="route('welcome')" class="mx-6 flex-shrink-0">
              <svg role="img" aria-label="Volkswagen" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" :fill="isScrolledPastImage || !hasHeroImage ? 'currentColor' : 'white'" stroke="none">
                <title>Volkswagen</title>
                <path
                  d="M12 22.586c-5.786 0-10.543-4.8-10.543-10.586 0-1.2.214-2.357.6-3.471l6.172 12c.085.171.171.3.385.3.215 0 .3-.129.386-.3l2.871-6.386q.064-.129.129-.129c.086 0 .086.086.129.129l2.914 6.386c.086.171.171.3.386.3.214 0 .3-.129.385-.3l6.172-12c.385 1.071.6 2.228.6 3.471-.043 5.786-4.8 10.586-10.586 10.586m0-13.329c-.086 0-.086-.086-.129-.128l-3.3-7.115a10.12 10.12 0 0 1 6.858 0l-3.3 7.115c-.043.042-.043.128-.129.128m-3.471 7.714c-.086 0-.086-.085-.129-.128L3 6.47c.943-1.542 2.314-2.828 3.9-3.728l3.814 8.228c.086.172.172.215.3.215h1.972c.128 0 .214-.043.3-.215l3.771-8.228c1.586.9 2.957 2.186 3.9 3.728L15.6 16.843q-.065.128-.129.128c-.085 0-.085-.085-.128-.128L13.286 12.3c-.086-.171-.172-.214-.3-.214h-1.972c-.128 0-.214.043-.3.214l-2.057 4.543c-.043.043-.043.128-.128.128M12 24c6.643 0 12-5.357 12-12S18.643 0 12 0 0 5.357 0 12s5.357 12 12 12">
                </path>
              </svg>
            </Link>
            <div class="h-px bg-current flex-grow"></div>
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
            <svg
              class="h-6 w-6"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <nav class="flex-grow py-8 px-4">
          <Link :href="route('welcome')" class="block py-2 text-lg text-white hover:bg-blue-700 rounded px-2 mb-2">
            Home
          </Link>
          <Link :href="route('autosnuevos')" class="block py-2 text-lg text-white hover:bg-blue-700 rounded px-2 mb-2">
            Autos Nuevos
          </Link>
          <div class="relative">
            <button @click="toggleSubMenu" class="flex items-center justify-between w-full py-2 text-lg text-white hover:bg-blue-700 rounded px-2 mb-2">
              <span>Servicios</span>
              <svg class="h-4 w-4 ml-2" :class="{ 'transform rotate-180': isSubMenuOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-if="isSubMenuOpen" class="pl-4 mt-2 space-y-2">
              <Link :href="route('servicios')" class="block py-2 text-base text-white hover:bg-blue-700 rounded px-2">
                Servicio 1
              </Link>
              <Link :href="route('servicios')" class="block py-2 text-base text-white hover:bg-blue-700 rounded px-2">
                Servicio 2
              </Link>
            </div>
          </div>
          <Link :href="route('servicios')" class="block py-2 text-lg text-white hover:bg-blue-700 rounded px-2 mb-2">
            Nueva Sección
          </Link>
        </nav>
      </div>
    </div>

    <main>
      <slot />
    </main>
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
  background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
}

@media (max-width: 640px) {
  .sm\:mx-0.mx-auto {
    margin-left: auto;
    margin-right: auto;
  }
}
</style>
