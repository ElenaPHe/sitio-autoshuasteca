<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { info } from 'autoprefixer';

const props = defineProps({
    refacciones: Object,
});


console.log(props.refacciones);

</script>

<template>

    <Head title="Seminuevos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-vwheadbold text-xl text-gray-800 leading-tight">Contendo de Refacciones</h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-end mb-6">
                            <Link :href="route('refacciones.create')"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 ease-in-out">
                            Crear
                            </Link>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-gray-50 rounded-lg p-5 shadow-md" v-for="refaccion in props.refacciones"
                                :key="refaccion.id">
                                <img :src="`/storage/${refaccion.imagen}`" alt=""
                                    class="w-full object-cover mb-4 rounded-md">
                                <h1 class="font-vwheadbold text-gray-800 text-lg  mb-2"> {{ refaccion.nombre }}</h1>
                                <p>$ {{ refaccion.infoGeneral.precio }} </p>
                                <p>{{ refaccion.infoGeneral.numParte }}</p>

                                <Link :href="`/seccion-refacciones/${refaccion.id}/edit`"
                                    class="inline-block text-center bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 ease-in-out">
                                Editar</Link>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
