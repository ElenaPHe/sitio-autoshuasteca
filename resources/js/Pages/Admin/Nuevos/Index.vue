<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    nuevos: Object,
});

function formatPrice(value) {
    if (value == null) return '';
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

console.log(props.nuevos);
</script>

<template>

    <Head title="Inicio" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-vwheadbold text-xl text-gray-800 leading-tight">Contenido de Nuevos</h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-end mb-6">
                            <Link :href="route('nuevos.create')"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 ease-in-out">
                            Crear
                            </Link>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 ">
                            <div v-for="infoNuevo in props.nuevos" :key="infoNuevo.id"
                                class="bg-gray-50 rounded-lg p-5 shadow-md ">
                                <h1 class="font-vwheadbold text-gray-800 text-lg  mb-2">{{ infoNuevo.modelo }}</h1>
                                <p class="font-vwtext text-gray-600 text-base mb-4 ">$ {{ formatPrice(infoNuevo.infoGeneral.precio) }}</p>
                                <img :src="`/storage/${infoNuevo.fotoAuto}`" alt="Imagen de {{ infoNuevo.modelo }}"
                                    class="w-full h-40 object-cover mb-4 rounded-md">
                                <Link :href="`/seccion-nuevos/${infoNuevo.id}/edit`"
                                    class="inline-block text-center bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 ease-in-out">
                                Editar
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
