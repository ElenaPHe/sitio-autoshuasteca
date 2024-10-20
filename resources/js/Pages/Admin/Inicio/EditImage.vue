<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Recibir el objeto 'inicio' que viene del controlador
const props = defineProps({
    inicio: Object,
});

// Inicializar el formulario con los valores que ya tenemos
const form = useForm({
    imagen: null, // Empezamos con null para manejar los archivos

});



// Manejar el cambio de imágenes y reemplazarlas
function handleFileUpload(event, field = 'image', index = null) {
    const file = event.target.files[0];

    form.imagen = file; // Asignar la nueva imagen de inicio

}


// Enviar el formulario
function submit() {

    form.put(route('inicio.actualizarImagenPrincipal', props.inicio.id), {
        onSuccess: () => {
            console.log('Formulario actualizado');
        },
        onError: (errors) => {
            console.log('Error al actualizar formulario', errors);
        },
    });
}
</script>

<template>

    <Head title="Editar sección de bienvenida" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar sección de bienvenida</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" class="space-y-6" enctype="multipart/form-data">
                            <!-- Imagen principal -->
                            <div>
                                <label for="imagen" class="block text-sm font-medium text-gray-700">
                                    Imagen de inicio
                                </label>
                                <input type="file" id="imagen" name="imagen"
                                    @change="event => handleFileUpload(event, 'imagen')"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <img v-if="props.inicio.imagen" :src="`/storage/${props.inicio.imagen}`"
                                    alt="Imagen de inicio" class="mt-4 h-40">
                            </div>

                            <!-- Botones -->
                            <div class="flex justify-end">
                                <Link href="/seccionbienvenida"
                                    class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 mr-4">Cancelar
                                </Link>
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
