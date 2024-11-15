<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { info } from 'autoprefixer';

const props = defineProps({
    seminuevos: Object,
});

const form= useForm({

});

function eliminarSeminuevo(id) {
    if (confirm('¿Estás seguro de eliminar este seminuevo?')) {
        form.delete(route('seminuevos.destroy', id),
            {
                preserveScroll: true,
                onSuccess: () => {
                    console.log('Eliminado');
                },
                onError: (error) => {
                    console.log(error);
                }
            });
    }
}

console.log(props.seminuevos);


</script>

<template>

    <Head title="Seminuevos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-vwheadbold text-xl text-gray-800 leading-tight">Contendo de Seminuevos</h2>
        </template>

        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-end mb-6">
                            <Link :href="route('seminuevos.create')"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 ease-in-out">
                            Crear
                            </Link>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-gray-50 rounded-lg p-5 shadow-md" v-for="infoSemi in props.seminuevos"
                                :key="infoSemi.id">
                                <h1 class="font-vwheadbold text-gray-800 text-lg  mb-2">{{ infoSemi.infoGeneral.marca }}
                                    {{ infoSemi.infoGeneral.modelo }} {{ infoSemi.infoGeneral.year }}</h1>
                                <img :src="`/storage/${infoSemi.fotoAuto}`" alt=""
                                    class="w-full object-cover mb-4 rounded-md">

                                <Link :href="`/seccion-seminuevos/${infoSemi.id}/edit`"
                                    class="inline-block text-center bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 ease-in-out">
                                Editar</Link>

                                <button @click="eliminarSeminuevo(infoSemi.id)"                                    class="inline-block text-center bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200 ease-in-out">
                                Eliminar</button>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
