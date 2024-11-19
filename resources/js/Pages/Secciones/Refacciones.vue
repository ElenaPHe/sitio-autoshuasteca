<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';

const props = defineProps({
    refacciones: Object,
});

const isContentLoaded = ref(false);
const selectTipo = ref(''); // Estado para el filtro tipoKit

onMounted(() => {
    setTimeout(() => {
        isContentLoaded.value = true;
    }, 300);
});

// Computed property para filtrar y ordenar los autos
const filteredRefaccion = computed(() => {
    let filtered = props.refacciones;

    // Filtrado por marca
    if (selectTipo.value !== '') {
        filtered = filtered.filter(refa => refa.tipoRefaccion === selectTipo.value);
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


console.log(props.refacciones);
</script>

<template>

    <Head title="Refacciones" />

    <UserLayout>
        <div class="relative min-h-screen bg-white pt-20 pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 :class="[
                    'text-4xl sm:text-5xl font-bold mb-12 text-center transition-all duration-1000 ease-out',
                    { 'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded }
                ]">
                    <span class="font-vwheadbold">Refacciones</span>
                </h2>


                <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
                    <h3 class="text-2xl font-vwheadbold text-gray-800 mb-6">Filtros</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="space-y-2">
                            <label for="marca" class="block text-sm font-medium text-gray-700">Tipo Refacción:</label>
                            <select v-model="selectTipo" id="marca"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Todas las refacciones</option>
                                <option value="Unico">Único</option>
                                <option value="Kit">Kit</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                    <Link v-for="infoSemi in filteredRefaccion" :key="infoSemi.id"
                        :href="route('refacciones.show', infoSemi.id)"
                        class="block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                    <div class="flex flex-col h-full">
                        <div class="w-full aspect-[4/3] overflow-hidden relative">
                            <img :src="`/storage/${infoSemi.imagen}`" :alt="infoSemi.imagen"
                                class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" />
                        </div>
                        <div class="flex-1 p-6">
                            <h3 class="text-2xl font-vwheadbold text-gray-800 mb-2">
                                {{ infoSemi.infoGeneral.marca }} {{ infoSemi.infoGeneral.modelo }}
                                <span class="text-xl font-vwheadlight">{{ infoSemi.infoGeneral.year }}</span>
                            </h3>
                            <p class="text-lg font-vwheadlight text-gray-600 mb-4">{{ infoSemi.nombre }}</p>
                            <div class="mt-auto">
                                <p class="text-sm font-vwheadlight text-gray-500">Precio</p>
                                <p class="text-2xl font-vwheadbold text-indigo-600">
                                    ${{ formatPrice(infoSemi.infoGeneral.precio) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    </Link>

                </div> -->

                <div :class="filteredRefaccion.length === 1 ? 'single-card-container font-vwtext' : filteredRefaccion.length === 2 ? 'two-card-container font-vwtext' : 'card-container font-vwtext'">
                    <div v-for="(refaccion, index) in filteredRefaccion" :key="index" class="card">
                        <!-- <div style="display: flex; width: 100%;"> -->
                        <Link class="card-image-wrapper" :href="route('refacciones.show', refaccion.id)">
                        <div class="status-badge" v-if="refaccion.infoGeneral.stock">
                            <span class="status-dot"></span>
                            {{ refaccion.infoGeneral.stock > 0 ? 'Disponible' : 'No disponible' }}
                        </div>
                        <img :src="`/storage/${refaccion.imagen}`" :alt="refaccion.nombre" class="card-image" />
                        <div class="hover-overlay">
                            <button class="discover-btn">Descubrir</button>
                        </div>
                        </Link>

                        <div class="card-content">

                            <div style="display: flex;">


                                <div style="position: relative; width: 55%;">
                                    <h3 class="model-name font-vwheadbold">{{ refaccion.nombre }}</h3>
                                    <p class="model-specs">{{ refaccion.infoGeneral.descripcion }}</p>
                                </div>

                                <div style="position: relative; width: 45%;">
                                    <div class="price-tag">Desde: ${{ formatPrice(refaccion.infoGeneral.precio) }}</div>
                                </div>

                            </div>

                            <!-- <div class="specs-grid">
                                <div class="spec-item">
                                    <span class="spec-icon">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg" stroke="">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                    d="M6 4C6 5.10457 5.10457 6 4 6C2.89543 6 2 5.10457 2 4C2 2.89543 2.89543 2 4 2C5.10457 2 6 2.89543 6 4Z"
                                                    stroke="#001e50" stroke-width="1.5"></path>
                                                <path
                                                    d="M6 20C6 21.1046 5.10457 22 4 22C2.89543 22 2 21.1046 2 20C2 18.8954 2.89543 18 4 18C5.10457 18 6 18.8954 6 20Z"
                                                    stroke="#001e50" stroke-width="1.5"></path>
                                                <path
                                                    d="M14 20C14 21.1046 13.1046 22 12 22C10.8954 22 10 21.1046 10 20C10 18.8954 10.8954 18 12 18C13.1046 18 14 18.8954 14 20Z"
                                                    stroke="#001e50" stroke-width="1.5"></path>
                                                <path
                                                    d="M14 4C14 5.10457 13.1046 6 12 6C10.8954 6 10 5.10457 10 4C10 2.89543 10.8954 2 12 2C13.1046 2 14 2.89543 14 4Z"
                                                    stroke="#001e50" stroke-width="1.5"></path>
                                                <path
                                                    d="M22 4C22 5.10457 21.1046 6 20 6C18.8954 6 18 5.10457 18 4C18 2.89543 18.8954 2 20 2C21.1046 2 22 2.89543 22 4Z"
                                                    stroke="#001e50" stroke-width="1.5"></path>
                                                <path d="M4 6V18" stroke="#001e50" stroke-width="1.5"
                                                    stroke-linecap="round"></path>
                                                <path d="M12 6V18" stroke="#001e50" stroke-width="1.5"
                                                    stroke-linecap="round"></path>
                                                <path
                                                    d="M20 6V8C20 9.88562 20 10.8284 19.4142 11.4142C18.8284 12 17.8856 12 16 12H4"
                                                    stroke="#001e50" stroke-width="1.5" stroke-linecap="round"></path>
                                                <path
                                                    d="M18 15V14.25C17.5858 14.25 17.25 14.5858 17.25 15H18ZM17.25 22C17.25 22.4142 17.5858 22.75 18 22.75C18.4142 22.75 18.75 22.4142 18.75 22H17.25ZM21.3604 22.3916C21.5766 22.7449 22.0384 22.8559 22.3916 22.6396C22.7449 22.4234 22.8559 21.9616 22.6396 21.6084L21.3604 22.3916ZM18 15.75H20.2857V14.25H18V15.75ZM18.75 18.5V15H17.25V18.5H18.75ZM21.25 16.75C21.25 17.3169 20.8038 17.75 20.2857 17.75V19.25C21.6612 19.25 22.75 18.1161 22.75 16.75H21.25ZM20.2857 15.75C20.8038 15.75 21.25 16.1831 21.25 16.75H22.75C22.75 15.3839 21.6612 14.25 20.2857 14.25V15.75ZM20.2857 17.75H19.8571V19.25H20.2857V17.75ZM19.8571 17.75H18V19.25H19.8571V17.75ZM19.2175 18.8916L21.3604 22.3916L22.6396 21.6084L20.4968 18.1084L19.2175 18.8916ZM17.25 18.5V22H18.75V18.5H17.25Z"
                                                    fill="#001e50"></path>
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="spec-value">{{ refaccion.infoGeneral.numParte }}</span>
                                </div>
                                <div class="spec-item">
                                    <svg width="20px" height="20px" class="" fill="#001E50" version="1.1" id="Layer_1"
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
                                    <span class="spec-value">{{ refaccion.infoGeneral.numParte }}</span>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </UserLayout>
</template>

<style scoped>
.card-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.single-card-container {
    display: grid;
    grid-template-columns: repeat(3, minmax(300px, 1fr));
    gap: 24px;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.two-card-container{
    display: grid;
    grid-template-columns: repeat(3, minmax(300px, 1fr));
    gap: 24px;
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}







.card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.card-image-wrapper {
    position: relative;
    /* padding-top: 66.67%; */
    /* aspect-ratio: 3 / 2; */
    background: #f5f5f5;
    overflow: hidden;
}

.card-image {
    /* position: absolute; */
    top: 0;
    left: 0;
    width: 100%;
    /* height: 100%; */
    object-fit: cover;
    transition: transform 0.3s ease;
}

.card:hover .card-image {
    transform: scale(1.05);
}

/* .card:hover .status-badge {
    display: none;
  } */

.status-badge {
    position: absolute;
    /* width: 20px;; */
    height: 35px;
    top: 12px;
    left: 12px;
    background: rgba(255, 255, 255, 0.81);
    padding: 6px 15px;
    /* padding-left: 1%; */
    /* padding-right: 50%; */
    border-radius: 20px;
    /* font-size: 0.875rem; */
    font-size: 10px;
    color: #001e50;
    /* VW Green */
    display: flex;
    align-items: center;
    gap: 6px;
    z-index: 2;
}

@keyframes blink {

    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: 0;
    }
}

.status-dot {
    width: 9px;
    height: 9px;
    background: #001e50;
    border-radius: 50%;
    display: inline-block;
    animation: blink 2s infinite;
}

.hover-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.card:hover .hover-overlay {
    opacity: 1;
}

.discover-btn {
    position: relative;
    background: #001e50;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 25px;
    font-size: 1rem;
    font-weight: 500;
    /* cursor: pointer; */
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.card:hover .discover-btn {
    transform: translateY(0);
}

.discover-btn:hover {
    background: #3d5784;
}

.card-content {
    padding: 20px 10px 20px 10px;
    width: 100%;
}

.model-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #222222;
    margin: 0 0 4px 0;
}

.model-specs {
    font-size: 0.875rem;
    color: #666666;
    margin: 0 0 12px 0;
}

.price-tag {

    text-align: end;
    font-size: 1.25rem;
    font-weight: 600;
    color: #001e50;
    margin-bottom: 16px;
}

/*.price-period {
    font-size: 0.875rem;
    font-weight: normal;
    color: #666666;
  }*/

.specs-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    padding-top: 16px;
    border-top: 1px solid #eee;
}

.spec-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
}

.spec-icon {
    font-size: 1.25rem;
}

.spec-value {
    font-size: 0.75rem;
    color: #666666;
    text-align: center;
}



@media (max-width: 768px) {
    .card-container {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 16px;
        padding: 16px;
    }

    .single-card-container {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 16px;
        padding: 16px;
    }

    .two-card-container{
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }

    .status-badge {
        position: absolute;
        /* width: 20px;; */
        height: 35px;
        top: 12px;
        left: 12px;
        background: white;
        padding: 6px 15px;
        /* padding-left: 1%; */
        /* padding-right: 50%; */
        border-radius: 20px;
        /* font-size: 0.875rem; */
        font-size: 10px;
        color: #001e50;
        /* VW Green */
        display: flex;
        align-items: center;
        gap: 6px;
        z-index: 2;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }
    }

    .status-dot {
        width: 9px;
        height: 9px;
        background: #001e50;
        border-radius: 50%;
        display: inline-block;
        animation: blink 2s infinite;
    }

    .discover-btn {
        position: relative;
        background: #001e50;
        color: white;
        border: none;
        padding: 12px 32px;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 600;
        /* cursor: pointer; */
        transform: translateY(20px);
        transition: all 0.3s ease;
    }







}

@media (max-width: 480px) {
    .specs-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .single-card-container {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }

    .two-card-container{
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }

    .status-badge {
        position: absolute;
        height: 30px;
        top: 10px;
        left: 10px;
        background: white;
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 8px;
        color: #001e50;
        display: flex;
        align-items: center;
        gap: 4px;
        z-index: 2;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }
    }

    .status-dot {
        width: 7px;
        height: 7px;
        background: #001e50;
        border-radius: 50%;
        display: inline-block;
        animation: blink 2s infinite;
    }

    .discover-btn {
        position: relative;
        background: #001e50;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 500;
        /* cursor: pointer; */
        transform: translateY(20px);
        transition: all 0.3s ease;
    }
}
</style>
