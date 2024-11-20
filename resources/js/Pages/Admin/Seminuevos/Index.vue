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
        <!-- <template #header>
            <h2 class="font-vwheadbold text-xl text-gray-800 leading-tight">Contendo de Seminuevos</h2>
        </template> -->

        <!-- <div class="py-8">
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
        </div> -->

        <div class="py-0 bg-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white sm:rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <div class="p-8 bg-gray-100">
                        <div class="flex justify-end mb-8">
                            <Link :href="route('seminuevos.create')"
                                class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-full font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-300 ease-in-out">
                            Crear Nuevo
                            </Link>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div v-for="infoSemi in seminuevos" :key="infoSemi.id"
                                class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                                <h1 class="font-bold text-gray-800 text-xl mb-3">{{ infoSemi.infoGeneral.marca }}
                                    {{ infoSemi.infoGeneral.modelo }} {{ infoSemi.infoGeneral.year }}</h1>
                                <div class="relative overflow-hidden rounded-lg mb-4 group">
                                    <img :src="`/storage/${infoSemi.fotoAuto}`" :alt="`Imagen de ${infoSemi.modelo}`"
                                        class="w-full h-52 object-cover transition-transform duration-300 group-hover:scale-110">

                                </div>
                                <div class="flex flex-wrap gap-2 justify-between">
                                    <Link :href="`/seccion-seminuevos/${infoSemi.id}/edit`"
                                        class="flex-grow bg-blue-500 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-600 transition duration-300 ease-in-out transform hover:-translate-y-1 text-center">
                                    Editar
                                    </Link>

                                    <button @click="eliminarSeminuevo(infoSemi.id)"
                                        class="flex-grow bg-red-500 text-white px-4 py-2 rounded-md font-medium hover:bg-red-600 transition duration-300 ease-in-out transform hover:-translate-y-1">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
