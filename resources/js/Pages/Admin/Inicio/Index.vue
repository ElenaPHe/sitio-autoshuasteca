<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    inicios: Object,
});

</script>

<template>

    <Head title="Inicio" />
    <AuthenticatedLayout>


        <div class="py-12 bg-gray-100 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-8">
                            <h1 class="text-3xl font-bold text-gray-800">Sección de inicio</h1>
                            <!-- <Link :href="route('inicio.create')"
                                class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out transform hover:scale-105">
                            Crear Nuevo
                            </Link> -->
                        </div>

                        <div v-for="info in inicios" :key="info.id" class="mb-12 last:mb-0">
                            <div class="space-y-8">
                                <section>
                                    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Imagen principal</h2>
                                    <div class="overflow-hidden rounded-lg shadow-md">
                                        <img :src="`/storage/${info.imagen}`" alt="Imagen principal"
                                            class="w-full object-cover object-center">
                                    </div>
                                </section>

                                <section>
                                    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Carrusel</h2>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                        <div v-for="(image, index) in info.carrusel" :key="index"
                                            class="overflow-hidden rounded-lg shadow-md">
                                            <img :src="`/storage/${image}`" alt="Imagen carrousel"
                                                class="w-full h-48 object-cover object-center">
                                        </div>
                                    </div>
                                </section>

                                <section>
                                    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Promociones</h2>
                                    <div class="space-y-6">
                                        <div v-for="(promo, index) in info.promociones" :key="index"
                                            class="flex flex-col sm:flex-row bg-gray-50 rounded-lg overflow-hidden">
                                            <img :src="`/storage/${promo.imagen}`" alt="Imagen promocion"
                                                class="w-full sm:w-1/3 h-48 object-cover object-center">
                                            <div class="p-4 flex-1">
                                                <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ promo.titulo }}
                                                </h3>
                                                <p class="text-gray-600">{{ promo.descripcion }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!-- Terminos y condiciones -->
                                <!-- <section>
                                    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Términos y condiciones</h2>
                                    <div class="space-y-6">
                                        <p class="text-gray-600 text-xs">{{ info.terminos }}</p>
                                    </div>
                                </section> -->

                                <div class="flex justify-end mt-8">
                                    <Link :href="`/seccionbienvenida/${info.id}/edit`"
                                        class="bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition duration-300 ease-in-out transform hover:scale-105">
                                    Editar
                                    </Link>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
