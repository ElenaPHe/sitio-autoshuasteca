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
    terminos: props.inicio.terminos || '',
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
    if (confirm('¿Estás seguro de eliminar esta promoción?')) {
        form.promociones.splice(index, 1);
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

}


//Manejar el cambio de imagen de promociones
const imagenPromoForm = useForm({
    // imagen: null,
    // promociones: [
    //     {
    //         // titulo: '',
    //         imagen: null,
    //         // descripcion: '',
    //     }
    // ],
    promociones: props.inicio.promociones.map(content => ({
        ...content,
        imagen: null,
    })),
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

        <div class="min-h-screen bg-white py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">Editar sección de Inicio</h1>

                <div class="bg-white overflow-hidden  sm:rounded-lg">
                    <div class="p-8 space-y-8">
                        <!-- Imagen Principal -->
                        <section class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Imagen Principal</h2>
                            <div v-if="props.inicio.imagen" class="flex items-center space-x-4">
                                <img :src="`/storage/${props.inicio.imagen}`" alt="Imagen Principal"
                                    class="w-48 h-auto rounded-lg shadow-md">
                                <div>
                                    <p class="text-sm text-gray-600 mb-2">Imagen actual</p>
                                    <button @click="eliminarImagen"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition duration-300">
                                        Eliminar Imagen
                                    </button>
                                </div>
                            </div>
                            <form v-else @submit.prevent="subirImagen" class="space-y-4">
                                <div>
                                    <label for="nuevaImagen" class="block text-sm font-medium text-gray-700 mb-2">Subir
                                        Nueva Imagen</label>
                                    <input id="nuevaImagen" type="file" @change="onFileChange"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        accept="image/*">
                                </div>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition duration-300">
                                    Subir Imagen
                                </button>

                            </form>
                        </section>

                        <!-- Carrusel de Imágenes -->
                        <section class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Carrusel de Imágenes</h2>
                            <div v-if="props.inicio.carrusel && props.inicio.carrusel.length > 0">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
                                    <img v-for="img in props.inicio.carrusel" :key="img" :src="`/storage/${img}`"
                                        class="w-full h-32 object-cover rounded-lg shadow-md" alt="Imagen Carrusel">
                                </div>
                                <button @click="eliminarCarrusel"
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition duration-300">
                                    Cambiar carrusel
                                </button>
                            </div>
                            <form v-else @submit.prevent="subirCarrusel" class="space-y-4">
                                <div>
                                    <label for="carruselImagenes"
                                        class="block text-sm font-medium text-gray-700 mb-2">Subir Carrusel de
                                        Imágenes</label>
                                    <input id="carruselImagenes" type="file" multiple @change="onFileChangeCarrusel"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        accept="image/*">
                                </div>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md transition duration-300">
                                    Subir Carrusel
                                </button>
                            </form>
                        </section>

                        <!-- Formulario de Promociones -->
                        <form @submit.prevent="submit" class="space-y-8">
                            <section class="bg-gray-50 rounded-lg p-6">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Promociones</h2>
                                <div v-for="(promo, index) in form.promociones" :key="index"
                                    class="mb-6 p-4 bg-white rounded-lg shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-medium text-gray-700">Promoción {{ index + 1 }}</h3>
                                        <button @click.prevent="removePromocion(index)"
                                            class="text-red-500 hover:text-red-700 transition duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="text" v-model="promo.titulo" placeholder="Titulo de la promoción"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <textarea v-model="promo.descripcion" placeholder="Descripción de la promoción"
                                        rows="3"
                                        class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                </div>
                                <button @click.prevent="addPromocion"
                                    class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full transition duration-300 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Agregar promoción
                                </button>
                            </section>


                            <!-- Terminos y condiciones -->
                            <section class="bg-gray-50 rounded-lg p-6">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">Términos y condiciones</h2>
                                <textarea v-model="form.terminos" placeholder="Términos y condiciones"
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                            </section>

                            <div class="flex justify-end space-x-4">
                                <Link href="/seccionbienvenida"
                                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-md transition duration-300">
                                Cancelar
                                </Link>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md transition duration-300">
                                    Guardar cambios
                                </button>
                            </div>
                        </form>

                        <!-- Imágenes de promociones existentes -->
                        <section class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Imágenes de promociones existentes</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div v-for="(imagenpromo, index) in props.inicio.promociones" :key="index"
                                    class="bg-white p-4 rounded-lg shadow-sm">
                                    <template v-if="imagenpromo.imagen">
                                        <img :src="`/storage/${imagenpromo.imagen}`" alt="Imagen de promoción"
                                            class="w-full h-40 object-cover rounded-lg mb-2">
                                        <div class="font-medium text-gray-700 mb-2">{{ imagenpromo.titulo }}</div>
                                        <button @click.prevent="eliminarImagenPromo(index)"
                                            class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition duration-300">
                                            Eliminar Imagen
                                        </button>
                                    </template>
                                    <template v-else>
                                        <form @submit.prevent="subirImagenPromo(index)" class="space-y-4"
                                            enctype="multipart/form-data">
                                            <div class="font-medium text-gray-700 mb-2">{{ imagenpromo.titulo }}</div>
                                            <input type="file" @change="event => onFileChangePromo(event, index)"
                                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            <button type="submit"
                                                class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-300">
                                                Subir Imagen
                                            </button>

                                        </form>
                                    </template>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
