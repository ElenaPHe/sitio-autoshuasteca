<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Contador para generar IDs temporales para las promociones
let tempIdCounter = 1;

const form = useForm({
    imagen: null,
    carrusel: [], // Lista de imágenes para el carrusel
    promociones: [
        {
            id: tempIdCounter++, // ID temporal
            titulo: '',
            imagen: null,
            descripcion: '',
        }
    ],
    terminos: '',
});

// Función para manejar la subida de imágenes
function handleFileUpload(event, index = null, field = 'carrusel') {
    const files = Array.from(event.target.files);
    if (field === 'carrusel') {
        form.carrusel = files;
    }
}

// Función para manejar la subida de imágenes individuales
const handleImageUpload = (event, field, index = null) => {
    const file = event.target.files[0];
    if (field === 'imagen') {
        form.imagen = file; // Imagen principal
    } else if (field === 'promociones') {
        form.promociones[index].imagen = file; // Imagen específica de la promoción
    }
};

// Función para agregar una nueva promoción
function addPromocion() {
    form.promociones.push({
        id: tempIdCounter++, // Generar un nuevo ID temporal
        titulo: '',
        imagen: null,
        descripcion: '',
    });
}

// Función para eliminar una promoción
function removePromocion(index) {
    form.promociones.splice(index, 1);
}

// Función para manejar el envío del formulario
function submit() {
    form.post(route('inicio.store'), {
        onSuccess: () => {
            console.log('Formulario enviado correctamente');
        },
        onError: (errors) => {
            console.log('Error al enviar el formulario', errors);
        },
        onFinish: () => {
            // Redirigir a index
            form.reset();
            window.location.href = route('inicio.index');

        },
    });
}
</script>

<template>
    <Head title="Formulario de inicio" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Formulario de inicio</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" class="space-y-6">

                            <!-- Imagen principal -->
                            <div>
                                <label for="imagen" class="block text-sm font-medium text-gray-700">
                                    Imagen de inicio
                                </label>
                                <input type="file" id="imagen" name="imagen" @change="event => handleImageUpload(event, 'imagen')"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <!-- Carrusel de imágenes -->
                            <div>
                                <label for="carrusel" class="block text-sm font-medium text-gray-700">
                                    Carrusel de imágenes
                                </label>
                                <input type="file" id="carrusel" name="carrusel" @change="event => handleFileUpload(event)" multiple
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <!-- Promociones dinámicas -->
                            <div>
                                <label for="promociones" class="block text-sm font-medium text-gray-700">
                                    Promociones
                                </label>
                                <div v-for="(promo, index) in form.promociones" :key="promo.id" class="mb-4">
                                    <div class="flex space-x-4">
                                        <!-- Campo de Título -->
                                        <input type="text" v-model="promo.titulo" placeholder="Título de la promoción"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                        <!-- Campo de Imagen -->
                                        <input type="file" @change="event => handleImageUpload(event, 'promociones', index)"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                        <!-- Campo de Descripción -->
                                        <input type="text" v-model="promo.descripcion" placeholder="Descripción de la promoción"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                        <!-- Botón para eliminar promoción -->
                                        <button @click.prevent="removePromocion(index)" class="bg-red-500 text-white px-4 py-2 rounded">Eliminar</button>
                                    </div>
                                </div>
                                <!-- Botón para agregar promoción -->
                                <button @click.prevent="addPromocion" class="bg-green-500 text-white px-4 py-2 rounded">Agregar promoción</button>
                            </div>


                            <!-- Términos y condiciones -->
                            <div>
                                <label for="terminos" class="block text-sm font-medium text-gray-700">
                                    Términos y condiciones
                                </label>
                                <textarea v-model="form.terminos" id="terminos" name="terminos" rows="3"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex justify-end">
                                <Link :href="route('inicio.index')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 mr-4">Cancelar</Link>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
