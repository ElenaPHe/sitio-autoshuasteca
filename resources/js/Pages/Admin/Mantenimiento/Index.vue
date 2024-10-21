<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    mantenimientos: Object,
});

const form = useForm({
    titulo:'',
    imagen: null,
    paqueteOne: '',
    paqueteTwo: '',
    paqueteThree: '',
    paqueteFour: '',
    paqueteFive: '',
    paqueteSix: '',
    paqueteSeven: '',
    paqueteEight: '',
})

const deleteMantenimiento = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este contenido?')) {
        // Eliminar el contenido
        form.delete(route('mantenimiento.destroy', id), {
            onSuccess: () => {
                console.log('Contenido eliminado correctamente');
            },
            onError: (errors) => {
                console.log('Error al eliminar el contenido', errors);
            },
        });
    }
};

</script>

<template>

    <Head title="Inicio" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contendo de Mantenimiento</h2>
        </template>



        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-end mb-4">
                            <Link :href="route('mantenimiento.create')"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Crear
                            </Link>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Titulo
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Imagen
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Paquete 1
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Paquete 2
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Paquete 3
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="info in mantenimientos" :key="info.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ info.titulo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <img :src="`/storage/${info.imagen}`" alt="Imagen" class="w-16 object-cover">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ info.paqueteOne }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ info.paqueteTwo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ info.paqueteThree }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link :href="`/seccion-mantenimiento/${info.id}/edit`" class="text-indigo-600 hover:text-indigo-900">
                                            Editar
                                        </Link>
                                        <button @click="deleteMantenimiento(info.id)" class="text-red-600 hover:text-red-900 ml-4">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
