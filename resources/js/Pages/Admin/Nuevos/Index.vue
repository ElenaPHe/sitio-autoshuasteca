<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    nuevos: Object,
});


console.log(props.nuevos);
</script>

<template>

    <Head title="Inicio" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contendo de Nuevos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-end mb-4">
                            <Link :href="route('nuevos.create')"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Crear
                            </Link>
                        </div>
                        <div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div class="bg-gray-100 p-4  shadow" v-for="infoNuevo in props.nuevos" :key="infoNuevo.id">
                                    <h1 class="text-lg font-semibold mb-2">{{ infoNuevo.modelo }}</h1>
                                    <p class="text-sm text-gray-600 mb-2">$ {{ infoNuevo.infoGeneral.precio }}</p>
                                    <img :src="`/storage/${infoNuevo.fotoAuto}`" alt="" class="w-40 h-auto ">

                                  <Link :href="`/seccion-nuevos/${infoNuevo.id}/edit`" class="text-blue-500 hover:underline">Editar</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
