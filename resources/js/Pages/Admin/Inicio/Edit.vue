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
    imagen: props.inicio.imagen || null,
    carrusel: props.inicio.carrusel || [], // Lista de imágenes para el carrusel
    promociones: props.inicio.promociones || [
        {
            titulo: '',
            // imagen: null,
            descripcion: '',
        }
    ],
    // imagen: props.inicio.imagen || null,
    // carrusel: props.inicio.carrusel || [], // Lista de imágenes para el carrusel
    // promociones: [
    //     {

    //         titulo: '',
    //         imagen: null,
    //         descripcion: '',
    //     }
    // ] || props.inicio.promociones,
});

// Manejar el cambio de imágenes y reemplazarlas
function handleFileUpload(event, index = null, field = 'carrusel') {
    const files = Array.from(event.target.files);
    if (field === 'carrusel') {
        form.carrusel = files;  // Reemplazar todo el carrusel si cambian
    }
}

const handleImageUpload = (event, field, index = null) => {
    const file = event.target.files[0];

    if (field === 'imagen') {
        form.imagen = file; // Reemplazar la imagen principal
    }
    // else if (field === 'promociones') {
    //     form.promociones[index].imagen = file; // Reemplazar la imagen de una promoción
    // }
};

function addPromocion() {
    form.promociones.push({
        titulo: '',
        imagen: null,
        descripcion: '',
    });
}

function removePromocion(index) {
    form.promociones.splice(index, 1);
}



const imagenPromoForm = useForm({
    // imagen: null,
    promociones: [
        {
            // titulo: '',
            imagen: null,
            // descripcion: '',
        }
    ],
});

function onFileChangePromo(event, index) {
    const file = event.target.files[0];
    imagenPromoForm.promociones[index].imagen = file;
}

function subirImagenPromo(index) {
    imagenPromoForm.post(route('inicio.subirImagenPromo', { id: props.inicio.id, index }), {
        onSuccess: () => {
            console.log('Imagen de promo subida');
            // form.promociones[index].imagen = imagenPromoForm.imagen;
            imagenPromoForm.reset();
        },
        onError: (errors) => {
            console.log('Error al subir imagen', errors);
        },
    });
}

function eliminarImagenPromo(index) {
    imagenPromoForm.delete(route('inicio.eliminarImagenPromo', { id: props.inicio.id, index }), {
        onSuccess: () => {
            console.log('Imagen de promo eliminada');
            form.promociones[index].imagen = null;
            imagenPromoForm.reset();
        },
        onError: (errors) => {
            console.log('Error al eliminar imagen', errors);
        },
    });
}

function submit() {
    form.put(route('inicio.actualizar', props.inicio.id), {
        onSuccess: () => {
            console.log('Formulario actualizado');
            form.reset();
        },
        onError: (errors) => {
            console.log('Error al actualizar formulario', errors);

            //mostrar el contenido de el input
            console.log(form.imagen);
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
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <label for="imagen" class="block text-sm font-medium text-gray-700">
                                    Imagen de inicio
                                </label>
                                <input type="file" id="imagen" name="imagen"
                                    @change="event => handleImageUpload(event, 'imagen')"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <img v-if="props.inicio.imagen" :src="`/storage/${props.inicio.imagen}`" alt="Imagen de inicio" class="mt-4 h-40">
                            </div>

                            <div>
                                <label for="carrusel" class="block text-sm font-medium text-gray-700">
                                    Carrusel
                                </label>
                                <input type="file" id="carrusel" name="carrusel"
                                    @change="event => handleFileUpload(event)" multiple
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <div v-for="(image, index) in props.inicio.carrusel" :key="index" class="mt-2">
                                    <img :src="`/storage/${image}`" alt="Imagen carrusel" class="h-20">
                                </div>
                            </div>

                            <div>
                                <label for="promociones" class="block text-sm font-medium text-gray-700">
                                    Promocionesd
                                </label>
                                <div v-for="(promo, index) in form.promociones" :key="index" class="mb-4">
                                    <input type="text" v-model="promo.titulo" placeholder="Titulo de la promoción"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                    <input type="file" @change="event => handleImageUpload(event, 'promociones', index)" id="promociones-imagen"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                    <img v-if="promo.imagen" :src="`/storage/${promo.imagen}`" alt="Imagen de promoción" class="mt-2 h-20">
                                    <input type="text" v-model="promo.descripcion" placeholder="Descripción de la promoción"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                    <button @click.prevent="removePromocion(index)" class="bg-red-500 text-white px-4 py-2 rounded">Eliminar</button>
                                </div>
                                <button @click.prevent="addPromocion" class="bg-green-500 text-white px-4 py-2 rounded">Agregar promoción</button>
                            </div>

                            <div class="flex justify-end">
                                <Link href="/seccionbienvenida" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 mr-4">Cancelar</Link>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
                            </div>
                        </form>

                        <div v-for="(imagenpromo, index) in props.inicio.promociones " :key="index">
                            <template v-if="imagenpromo.imagen">
                                <img :src="`/storage/${imagenpromo.imagen}`" alt="Imagen de promoción" class="mt-2 h-20">
                                <div>{{ imagenpromo.titulo }}</div>
                                <button @click.prevent="eliminarImagenPromo(index)" class="bg-red-500 text-white px-4 py-2 rounded">Eliminar Imagen</button>
                            </template>
                            <template v-else>
                                <form @submit.prevent="subirImagenPromo(index)" class="space-y-6" enctype="multipart/form-data">
                                    <label for="">{{imagenpromo.titulo}}</label>
                                    <label for="">{{imagenpromo.imagen}}</label>
                                    <input type="file" @change="event => onFileChangePromo(event, index)" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Subir Imagen</button>
                                </form>
                            </template>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
