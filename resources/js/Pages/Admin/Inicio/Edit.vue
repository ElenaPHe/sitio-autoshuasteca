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
    // imagen: props.inicio.imagen || null,
    // carrusel: props.inicio.carrusel || [],
    promociones: props.inicio.promociones || [
        {
            titulo: '',
            // imagen: null,
            descripcion: '',
        }
    ],
});

//Manejar el cambio de imagen principal
const formImagen = useForm({
    imagen: null,
});
function onFileChange(event) {
    formImagen.imagen = event.target.files[0];
}
function subirImagen() {
    formImagen.post(route('inicio.subirImagen', props.inicio.id), {
        preserveScroll: true,
        onSuccess: () => {
            formFotoAuto.reset();
            console.log('La imagen se ha enviado correctamente');
            window.location.href = route('nuevos.index');
        }
    });

}
function eliminarImagen() {
    if (confirm('¿Estás seguro de eliminar la imagen?')) {
        formImagen.delete(route('inicio.eliminarImagen', props.inicio.id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Imagen eliminada');

                window.location.reload();
            },
            onError: (errors) => {
                console.log('Error al eliminar imagen', errors);
            },
        });
    }
}

//Manejar el cambio de imágenes de carrusel
const formCarrusel = useForm({
    carrusel: [],
});
function onFileChangeCarrusel(event) {
    formCarrusel.carrusel = Array.from(event.target.files);
}
function subirCarrusel() {
    formCarrusel.post(route('inicio.subirCarrusel', props.inicio.id), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Imagenes de l carrusel se han subido correctamente');
            formCarrusel.reset('carrusel');
            window.location.reload();
        },
        onError: (errors) => {
            console.log('Error al subir carrusel', errors);
        },
    });
}
function eliminarCarrusel() {
    if (confirm('¿Estás seguro de eliminar todas las imágenes del carrusel?')) {
        formCarrusel.delete(route('inicio.eliminarCarrusel', props.inicio.id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Carrusel eliminado');
                window.location.reload();
            },
            onError: (errors) => {
                console.log('Error al eliminar carrusel', errors);
            },
        });
    }
}


// Manejar el cambio de imágenes y reemplazarlas
// function handleFileUpload(event, index = null, field = 'carrusel') {
//     const files = Array.from(event.target.files);
//     if (field === 'carrusel') {
//         form.carrusel = files;  // Reemplazar todo el carrusel si cambian
//     }
// }

const handleImageUpload = (event, field, index = null) => {
    const file = event.target.files[0];

    if (field === 'imagen') {
        form.imagen = file; // Reemplazar la imagen principal
    }
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

//Manejar el cambio de imagen de promociones
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar sección de Inicio</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden">
                    <div class="p-6 bg-white ">



                        <div class="mb-4">

                            <!-- Foto del Auto -->
                            <template v-if="props.inicio.imagen">

                                <img :src="`/storage/${props.inicio.imagen}`" alt="Imagen"
                                    class="mb-2 w-48 h-auto">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Cambiar Foto del Auto</label>

                                <button @click="eliminarImagen" class="bg-red-500 text-white px-3 py-1 rounded-lg">Eliminar Imagen</button>

                            </template>

                            <template v-else>
                                <form @submit.prevent="subirImagen">
                                    <label for="">Subir Nueva Imagen</label>
                                    <input type="file" @change="onFileChange" class="block w-full" accept="image/*" />
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Subir
                                        Imagen</button>
                                </form>
                            </template>



                        </div>

                        <div class="mb-4">

                            <!-- Foto del Carrusel -->
                            <template v-if="props.inicio.carrusel && props.inicio.carrusel.length > 0">
                                <div class="flex flex-wrap gap-2">
                                    <img v-for="img in props.inicio.carrusel" :key="img" :src="`/storage/${img}`"
                                        class="w-32 h-auto mb-2" alt="Imagen Carrusel">
                                </div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Cambiar las imagenes del
                                    carrusel :</label>
                                <button @click="eliminarCarrusel"
                                    class="bg-green-500 text-white px-3 py-1 rounded-lg">Cambiar carrusel</button>
                            </template>

                            <template v-else>
                                <form @submit.prevent="subirCarrusel">
                                    <label for="">Subir Carrusel de Imagenes</label>
                                    <input type="file" multiple @change="onFileChangeCarrusel" class="block w-full"
                                        accept="image/*" />
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Subir
                                        Carrusel</button>
                                </form>
                            </template>
                        </div>

                        <form @submit.prevent="submit" class="space-y-8">
                            <!-- Promociones -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Promociones</h3>
                                <div v-for="(promo, index) in form.promociones" :key="index"
                                    class="mb-6 p-4 bg-white rounded-lg shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-md font-medium text-gray-700">Promoción {{ index + 1 }}</h4>
                                        <button @click.prevent="removePromocion(index)"
                                            class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="text" v-model="promo.titulo" placeholder="Titulo de la promoción"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 mb-2">
                                    <textarea v-model="promo.descripcion" placeholder="Descripción de la promoción"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 mb-2"
                                        rows="3"></textarea>
                                </div>
                                <button @click.prevent="addPromocion"
                                    class="mt-4 bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition duration-300 ease-in-out flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Agregar promoción
                                </button>
                            </div>

                            <div class="flex justify-end space-x-4">
                                <Link href="/seccionbienvenida"
                                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-full hover:bg-gray-400 transition duration-300 ease-in-out">
                                Cancelar</Link>
                                <button type="submit"
                                    class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition duration-300 ease-in-out">Guardar
                                    cambios</button>
                            </div>
                        </form>

                        <!-- Imágenes de promociones existentes -->
                        <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow-sm">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Imágenes de promociones existentes</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div v-for="(imagenpromo, index) in props.inicio.promociones" :key="index"
                                    class="bg-white p-4 rounded-lg shadow-sm">
                                    <template v-if="imagenpromo.imagen">
                                        <img :src="`/storage/${imagenpromo.imagen}`" alt="Imagen de promoción"
                                            class="w-full h-40 object-cover rounded-lg mb-2">
                                        <div class="font-medium text-gray-700 mb-2">{{ imagenpromo.titulo }}</div>
                                        <button @click.prevent="eliminarImagenPromo(index)"
                                            class="w-full bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 transition duration-300 ease-in-out">Eliminar
                                            Imagen</button>
                                    </template>
                                    <template v-else>
                                        <form @submit.prevent="subirImagenPromo(index)" class="space-y-4"
                                            enctype="multipart/form-data">
                                            <div class="font-medium text-gray-700 mb-2">{{ imagenpromo.titulo }}</div>
                                            <input type="file" @change="event => onFileChangePromo(event, index)" class="block w-full text-sm text-gray-500
                                                    file:mr-4 file:py-2 file:px-4
                                                    file:rounded-full file:border-0
                                                    file:text-sm file:font-semibold
                                                    file:bg-blue-50 file:text-blue-700
                                                    hover:file:bg-blue-100">
                                            <button type="submit"
                                                class="w-full bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition duration-300 ease-in-out">Subir
                                                Imagen</button>
                                        </form>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
