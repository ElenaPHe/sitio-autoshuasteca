<script setup>
import { ref, onMounted } from 'vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    mantenimiento: Object,
});

const isContentLoaded = ref(false);

onMounted(() => {
    // Add a small delay to trigger the load animation
    setTimeout(() => {
        isContentLoaded.value = true;
    }, 300);
});
</script>

<template>

    <Head title="Mantenimiento" />

    <UserLayout>
        <div class="relative h-screen">
            <div class="bg-image h-3/4 bg-cover bg-center"
                style="background-image: url('https://vw-huasteca.com.mx/Assets/img/mantenimiento/vw-mantenimiento-main.jpg');">
                <!-- Contenido superpuesto en la imagen -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <h1 :class="[
                        'text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-vwheadbold text-white shadow-lg transition-all duration-1000 ease-out',
                        { 'opacity-0 translate-y-[-20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded }
                    ]">
                        Mantenimiento
                    </h1>
                </div>
            </div>

            <!-- Contenido adicional -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <h2 :class="[
                    'text-2xl sm:text-3xl md:text-4xl lg:text-5xl mb-4 transition-all duration-1000 ease-out font-vwheadbold text-center',
                    { 'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded }
                ]">
                    <span class="font-vwheadlight">Todos los precios </span>
                    incluyen:
                </h2>

                <!--Servicios -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6 mx-auto max-w-7xl p-2 m-14 font-vwtext">
                    <!-- cambio de aceite -->
                    <div class="flex flex-col items-center space-y-2">
                        <div>
                            <svg class="w-16 sm:w-20 lg:w-24" fill="#001E50"  version="1.1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 512 512" xml:space="preserve" stroke="#001E50">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                    stroke="#CCCCCC" stroke-width="8.192"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g>
                                            <path
                                                d="M434.821,35.321c-7.36,0-47.875,0-52.564,0V19.692C382.257,8.817,373.44,0,362.565,0s-19.692,8.817-19.692,19.692v15.629 c-11.109,0-256.639,0-265.694,0c-10.875,0-19.692,8.817-19.692,19.692c0,10.277,7.874,18.704,17.916,19.603v417.691 c0,10.875,8.817,19.692,19.692,19.692h321.809c10.875,0,19.692-8.817,19.692-19.692V74.615 c10.043-0.898,17.917-9.326,17.917-19.602C454.514,44.138,445.697,35.321,434.821,35.321z M397.213,472.615H114.788V200.478 h282.424V472.615z M397.213,161.094H114.788V74.706h282.424V161.094z">
                                            </path>
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M297.303,293.548c-13.162-18.141-26.174-32.519-26.72-33.121c-3.732-4.113-9.028-6.459-14.583-6.459 s-10.85,2.346-14.583,6.459c-0.547,0.603-13.557,14.981-26.722,33.121c-12.501,17.227-29.121,42.608-29.121,64.033 c0,38.833,31.592,70.426,70.425,70.426s70.425-31.593,70.425-70.426C326.424,336.156,309.804,310.775,297.303,293.548z M256.001,388.622c-17.115,0-31.04-13.925-31.04-31.042c0-9.303,14.479-32.396,31.047-53.399 c16.564,20.983,31.034,44.065,31.034,53.399C287.041,374.697,273.116,388.622,256.001,388.622z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                            <p class="text-center text-sm sm:text-base fo">Cambio de <br> aceite</p>
                    </div>

                    <div class="flex flex-col items-center space-y-2">
                        <div>
                            <svg class="w-16 sm:w-20 lg:w-24" version="1.1" id="Capa_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 22.335 22.335" xml:space="preserve" fill="#001E50" stroke="#001E50"
                                stroke-width="0.00022335000000000004">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g>
                                            <path style="fill:#001E50;"
                                                d="M16.248,0H6.087c-0.5,0-0.906,0.406-0.906,0.905v20.524c0,0.5,0.406,0.906,0.906,0.906h10.161 c0.5,0,0.905-0.406,0.905-0.906V0.905C17.153,0.407,16.748,0,16.248,0z M16.396,21.429c0,0.081-0.066,0.146-0.146,0.146H6.087 c-0.081,0-0.146-0.065-0.146-0.146V0.905c0-0.08,0.066-0.146,0.146-0.146h10.161c0.08,0,0.146,0.065,0.146,0.146L16.396,21.429 L16.396,21.429z">
                                            </path>
                                            <path style="fill:#001E50;"
                                                d="M15.399,3.659c0-0.22-0.179-0.399-0.398-0.399H7.298C7.078,3.26,6.9,3.439,6.9,3.659v7.787 c0,0.016,0.007,0.029,0.009,0.045C6.907,11.508,6.9,11.522,6.9,11.538v7.82c0,0.221,0.18,0.399,0.4,0.399h7.735 c0.221,0,0.399-0.179,0.399-0.399v-7.82c0-0.058-0.014-0.111-0.035-0.161V3.659z M7.656,3.837h6.986 c0.199,0,0.361,0.17,0.361,0.381v6.92H7.3c-0.002,0-0.003,0.001-0.005,0.001V4.218C7.295,4.007,7.458,3.837,7.656,3.837z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <p class="text-center text-sm sm:text-base">Relleno de <br> Niveles</p>
                    </div>

                    <div class="flex flex-col items-center space-y-2">
                        <div>
                            <svg class="w-16 sm:w-20 lg:w-24" fill="#001E50" version="1.1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 512 512" xml:space="preserve" stroke="#001E50">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g>
                                            <path
                                                d="M511.013,307.28l-22.064-125.117c-5.462-30.972-32.281-53.452-63.769-53.452H86.824c-31.488,0-58.307,22.48-63.769,53.452 L0.991,307.28c-3.336,18.912,1.837,38.192,14.189,52.897c12.336,14.688,30.43,23.112,49.639,23.112h382.369 c19.177,0,37.255-8.429,49.599-23.124C509.157,345.436,514.343,326.161,511.013,307.28z M471.028,338.529 c-5.936,7.068-14.626,11.121-23.841,11.121H285.104l103.759-56.172l55.21-8.682c9.177-1.443,15.446-10.051,14.003-19.228 c-1.442-9.177-10.052-15.445-19.228-14.003l-158.55,24.932c-9.177,1.443-15.446,10.051-14.003,19.228 c1.443,9.176,10.05,15.445,19.228,14.003l3.758-0.591l-74.834,40.513H64.817c-9.246,0-17.951-4.049-23.88-11.109 c-5.936-7.066-8.422-16.332-6.82-25.419l22.064-125.117c2.622-14.866,15.509-25.655,30.642-25.655h152.356v14.577h-19.351 c-9.289,0-16.819,7.531-16.819,16.819c0,9.289,7.531,16.819,16.819,16.819h74.006c9.289,0,16.819-7.531,16.819-16.819 c0-9.289-7.531-16.819-16.819-16.819h-21.015v-14.577h152.362c15.133,0,28.02,10.79,30.642,25.655l22.064,125.116 C479.482,322.178,476.983,331.439,471.028,338.529z">
                                            </path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <p class="text-center text-sm sm:text-base">Limpiado de <br> parabrisas</p>
                    </div>

                    <div class="flex flex-col items-center space-y-2">
                        <div>
                            <svg class="w-16 sm:w-20 lg:w-24" viewBox="0 0 24.00 24.00" fill="none"
                                xmlns="http://www.w3.org/2000/svg" stroke="#001E50">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z"
                                        stroke="#001E50" stroke-width="1.2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path
                                        d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H10M15 5H17C18.1046 5 19 5.89543 19 7V12"
                                        stroke="#001E50" stroke-width="1.2" stroke-linecap="round"
                                        stroke-linejoin="round"></path>
                                    <path d="M13 19L15 21L20 16" stroke="#001E50" stroke-width="1.2"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </div>
                        <p class="text-center text-sm sm:text-base">Inspección de puntos de <br> seguridad y funcionalidad</p>
                    </div>

                    <div class="flex flex-col items-center space-y-2">
                        <div>
                            <svg class="w-16 sm:w-20 lg:w-24" viewBox="0 0 8.4666669 8.4666669" id="svg8" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#"
                                xmlns:dc="http://purl.org/dc/elements/1.1/"
                                xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                                xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
                                xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                                xmlns:svg="http://www.w3.org/2000/svg" fill="#001E50" stroke="#001E50">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <defs id="defs2"></defs>
                                    <g id="layer1" transform="translate(0,-288.53332)">
                                        <path
                                            d="M 2 3 A 1.0000999 1.0000999 0 0 0 1 4 L 1 24 A 1.0000999 1.0000999 0 0 0 2 25 L 15 25 L 15 27.001953 L 12.003906 27.001953 A 1.0001001 1.0001001 0 0 0 11.900391 27.001953 A 1.0015858 1.0015858 0 0 0 12.003906 29.003906 L 19.998047 29.003906 A 1.000252 1.000252 0 1 0 19.998047 27.001953 L 17 27.001953 L 17 25 L 30 25 A 1.0000999 1.0000999 0 0 0 31 24 L 31 4 A 1.0000999 1.0000999 0 0 0 30 3 L 2 3 z M 3 5 L 29 5 L 29 23 L 3 23 L 3 5 z "
                                            id="rect959"
                                            style="color:#001E50;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:medium;line-height:normal;font-family:sans-serif;font-variant-ligatures:normal;font-variant-position:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-alternates:normal;font-feature-settings:normal;text-indent:0;text-align:start;text-decoration:none;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#001E50;letter-spacing:normal;word-spacing:normal;text-transform:none;writing-mode:lr-tb;direction:ltr;text-orientation:mixed;dominant-baseline:auto;baseline-shift:baseline;text-anchor:start;white-space:normal;shape-padding:0;clip-rule:nonzero;display:inline;overflow:visible;visibility:visible;opacity:1;isolation:auto;mix-blend-mode:normal;color-interpolation:sRGB;color-interpolation-filters:linearRGB;solid-color:#001E50;solid-opacity:1;vector-effect:none;fill:#001E50;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1.99999988;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke fill markers;color-rendering:auto;image-rendering:auto;shape-rendering:auto;text-rendering:auto;enable-background:accumulate"
                                            transform="matrix(0.26458333,0,0,0.26458333,0,288.53332)"></path>
                                        <path
                                            d="m 4.497917,294.08957 a 0.26458332,0.26458332 0 0 1 -0.2645833,0.26458 0.26458332,0.26458332 0 0 1 -0.2645833,-0.26458 0.26458332,0.26458332 0 0 1 0.2645833,-0.26459 0.26458332,0.26458332 0 0 1 0.2645833,0.26459 z"
                                            id="path971"
                                            style="opacity:1;fill:#001E50;fill-opacity:1;stroke:none;stroke-width:0.52916664;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:stroke fill markers">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <p class="text-center text-sm sm:text-base">Diagnostico por <br> computadora</p>
                    </div>

                    <div class="flex flex-col items-center space-y-2">
                        <div>
                            <svg class="w-16 sm:w-20 lg:w-24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" stroke="#001E50">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <circle cx="12" cy="12" r="2.5" stroke="#001E5001E50"></circle>
                                    <path d="M10 14L6.5 17.5" stroke="#001E50" stroke-linejoin="round"></path>
                                    <path d="M10.5 10.5L6 6" stroke="#001E50" stroke-linejoin="round"></path>
                                    <circle cx="17" cy="17" r="1.5" stroke="#001E5001E50"></circle>
                                    <circle cx="20" cy="12" r="1.5" stroke="#001E5001E50"></circle>
                                    <path d="M18.5 12H14.5" stroke="#001E50" stroke-linejoin="round"></path>
                                    <path d="M14 14L16 16" stroke="#001E50" stroke-linejoin="round"></path>
                                    <circle cx="19" cy="5" r="2.5" stroke="#001E5001E50"></circle>
                                    <path d="M17 7L14 10" stroke="#001E50" stroke-linejoin="round"></path>
                                    <circle cx="5" cy="5" r="1.5" stroke="#001E5001E50"></circle>
                                    <circle cx="5" cy="19" r="2.5" stroke="#001E5001E50"></circle>
                                </g>
                            </svg>
                        </div>
                        <p class="text-center text-sm sm:text-base">Nano-Protección de <br> pintura</p>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1">
                <h2 :class="[
                    'text-2xl sm:text-3xl md:text-4xl lg:text-5xl mb-4 transition-all duration-1000 ease-out font-vwheadlight text-center',
                    { 'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded }
                ]">
                Modelos
                </h2>



            </div>

        </div>
    </UserLayout>
</template>

<style scoped>
/* Puedes agregar estilos adicionales aquí si es necesario */
</style>
