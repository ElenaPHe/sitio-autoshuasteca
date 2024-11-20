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
      <div class="py-6 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6 sm:p-8">
              <div class="flex justify-end mb-6">
                <Link
                  :href="route('mantenimiento.create')"
                  class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-full font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-300 ease-in-out"
                >
                  Crear
                </Link>
              </div>

              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Titulo
                      </th>
                      <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Imagen
                      </th>
                      <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Paquete 1
                      </th>
                      <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Paquete 2
                      </th>
                      <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Paquete 3
                      </th>
                      <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Acciones
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="info in mantenimientos" :key="info.id" class="hover:bg-gray-50 transition-colors duration-200">
                      <td class="px-3 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ info.titulo }}</div>
                      </td>
                      <td class="px-3 py-4 whitespace-nowrap">
                        <img :src="`/storage/${info.imagen}`" alt="Imagen" class="w-16 object-cover rounded-md">
                      </td>
                      <td class="px-3 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ info.paqueteOne }}</div>
                      </td>
                      <td class="px-3 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ info.paqueteTwo }}</div>
                      </td>
                      <td class="px-3 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ info.paqueteThree }}</div>
                      </td>
                      <td class="px-3 py-4 whitespace-nowrap text-sm font-medium">
                        <Link
                          :href="`/seccion-mantenimiento/${info.id}/edit`"
                          class="text-indigo-600 hover:text-indigo-900 mr-4"
                        >
                          Editar
                        </Link>
                        <button
                          @click="deleteMantenimiento(info.id)"
                          class="text-red-600 hover:text-red-900"
                        >
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
      </div>
    </AuthenticatedLayout>
  </template>
