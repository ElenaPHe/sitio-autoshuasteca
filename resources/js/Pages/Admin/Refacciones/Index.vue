<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { info } from 'autoprefixer';

const props = defineProps({
    refacciones: Object,
});


console.log(props.refacciones);

const form = useForm({

});

function eliminarRefaccion(id) {
    if (confirm('¿Estás seguro de eliminar esta refacción?')) {
        form.delete(route('refacciones.destroy', id),
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
                                


                            <div class="flex flex-wrap gap-2 justify-between">
                                <Link :href="`/seccion-refacciones/${refaccion.id}/edit`"
                                    class="flex-grow bg-blue-500 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-600 transition duration-300 ease-in-out transform hover:-translate-y-1 text-center">
                                Editar
                                </Link>

                                <button @click="eliminarRefaccion(refaccion.id)"
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
