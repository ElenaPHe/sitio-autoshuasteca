<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { info } from 'autoprefixer';

const props = defineProps({
    seminuevos: Object,
});


console.log(props.seminuevos);

</script>

<template>

    <Head title="Seminuevos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contendo de Seminuevos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-end mb-4">
                            <Link :href="route('seminuevos.create')"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Crear
                            </Link>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-gray-100 p-4 rounded shadow" v-for="infoSemi in props.seminuevos" :key="infoSemi.id">
                                <h1 class="text-lg font-semibold mb-2">{{ infoSemi.infoGeneral.marca }}</h1>
                                <img :src="`/storage/${infoSemi.fotoAuto}`" alt="" class="w-40 h-auto rounded">

                                <Link :href="`/seccion-seminuevos/${infoSemi.id}/edit`" class="text-blue-500 hover:underline">Editar</Link>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
