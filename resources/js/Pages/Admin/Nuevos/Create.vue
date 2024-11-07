<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
// import { version } from 'vite';

// const props = defineProps({
//     inicios: Object,
// });
const formNuevos = useForm({
    modelo: '',
    fotoAuto: null, // Inicializamos como null porque será un archivo
    infoGeneral: {
        eslogan: '',
        precio: '',
        motor: '',
        transmision: '',
        potencia: '',
        torque: '',
        versiones: '',
        stock: '',
    },
    disenio: {
        titulo: '',
        encabezado: '',
        descripcion: '',
    },
    disenioContenido: [
        {
            titulo: '',
            subtitulo: '',
            descripcion: '',
            imagen: null,
        }
    ],
    colores: [],
    tecnologia: {
        titulo: '',
        encabezado: '',
        descripcion: '',
    },
    tecnologiaContenido: [
        {
            titulo: '',
            subtitulo: '',
            descripcion: '',
            imagen: null,
        }
    ],
    galeria: [],
    versiones: [
        {
            nomVersion: '',
            imagen: null,
            infoGen: [
                {
                    precioVersion: '',
                    rendimiento: '',
                    potencia: '',
                }
            ],
            caracteristicas: [],
        }
    ],
});

// Función para manejar la subida de imágenes
function onfileUploadAuto(event) {
    const file = event.target.files[0];
    formNuevos.fotoAuto = file;
}
// Función para manejar la subida de imágenes de diseño de contenido
function onfileUploadDesingContent(event, index) {
    const file = event.target.files[0];
    formNuevos.disenioContenido[index].imagen = file;
}
// Función para manejar la subida de imágenes de colores
function onfileUploadColores(event) {
    const files = Array.from(event.target.files);
    formNuevos.colores = files;
}
// Función para manejar la subida de imágenes de tecnología de contenido
function onfileUploadTecnologiaContenido(event, index) {
    const file = event.target.files[0];
    formNuevos.tecnologiaContenido[index].imagen = file;
}

// Función para manejar la subida de imágenes de galeria
function onfileUploadGaleria(event) {
    const files = Array.from(event.target.files);
    formNuevos.galeria = files;
}
// Función para manejar la subida de imágenes de versiones
function onfileUploadVersion(event, index) {
    const file = event.target.files[0];
    formNuevos.versiones[index].imagen = file;
}

// Función para agregar el diseño de contenido
function addDesingContent() {
    formNuevos.disenioContenido.push({
        titulo: '',
        subtitulo: '',
        descripcion: '',
        imagen: null,
    });
}
// Función para eliminar el diseño de contenido
function removeDesingContent(index) {
    formNuevos.disenioContenido.splice(index, 1);
}
// Función para agregar tecnología de contenido
function addTecnologiaContenido() {
    formNuevos.tecnologiaContenido.push({
        titulo: '',
        subtitulo: '',
        descripcion: '',
        imagen: null,
    });
}
// Función para eliminar tecnología de contenido
function removeTecnologiaContenido(index) {
    formNuevos.tecnologiaContenido.splice(index, 1);
}
// Función para agregar versión
function addVersion() {
    formNuevos.versiones.push({
        nomVersion: '',
        imagen: null,
        infoGen: [
            {
                precioVersion: '',
                rendimiento: '',
                potencia: '',
            }
        ],
        caracteristicas: [],
    });
}
// Función para eliminar versión
function removeVersion(index) {
    formNuevos.versiones.splice(index, 1);
}
const submitAuto = () => {
    formNuevos.post(route('nuevos.store'), {
        onSuccess: () => {
            formNuevos.reset();
            console.log('El formulario se ha enviado correctamente');
            window.location.href = route('nuevos.index');
        }
    });
};

</script>

<template>

    <Head title="Inicio" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-vwtext text-xl text-gray-800 leading-tight">Contendo de inicio</h2>
        </template>

        <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8 font-vwtext">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl text-gray-900 text-center mb-8">Formulario de autos nuevos</h1>
                <form @submit.prevent="submitAuto" class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="p-6 space-y-6">
                        <!-- Informacion general -->
                        <div class="space-y-4">
                            <h2 class="text-xl font-semibold text-gray-800">Información General</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="modelo" class="block text-sm font-medium text-gray-700">Modelo</label>
                                    <input type="text" id="modelo" v-model="formNuevos.modelo"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="fotoAuto" class="block text-sm font-medium text-gray-700">Imagen
                                    </label>
                                    <input type="file" id="fotoAuto" @change="onfileUploadAuto"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-800 hover:file:bg-indigo-100">
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="eslogan" class="block text-sm font-medium text-gray-700">Eslogan</label>
                                    <input type="text" id="eslogan" v-model="formNuevos.infoGeneral.eslogan"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                                    <input type="number" id="precio" v-model="formNuevos.infoGeneral.precio"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="motor" class="block text-sm font-medium text-gray-700">Motor</label>
                                    <input type="text" id="motor" v-model="formNuevos.infoGeneral.motor"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="trans"
                                        class="block text-sm font-medium text-gray-700">Transmisión</label>
                                    <input type="text" id="trans" v-model="formNuevos.infoGeneral.transmision"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="pote" class="block text-sm font-medium text-gray-700">Potencia</label>
                                    <input type="text" id="pote" v-model="formNuevos.infoGeneral.potencia"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="torque" class="block text-sm font-medium text-gray-700">Torque</label>
                                    <input type="text" id="torque" v-model="formNuevos.infoGeneral.torque"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="torque" class="block text-sm font-medium text-gray-700">Cantidad en Existencia</label>
                                    <input type="number" id="stock" min="1"  v-model="formNuevos.infoGeneral.stock"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="versiones"
                                        class="block text-sm font-medium text-gray-700">Versiones</label>
                                    <input type="text" id="versiones" v-model="formNuevos.infoGeneral.versiones"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                        <!-- Diseño -->
                        <div class="space-y-4">
                            <h2 class="text-xl font-semibold text-gray-800">Diseño</h2>
                            <div class="space-y-4">
                                <div>
                                    <label for="designHeader"
                                        class="block text-sm font-medium text-gray-700">Encabezado</label>
                                    <input type="text" id="designHeader" v-model="formNuevos.disenio.encabezado"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="designDescription"
                                        class="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea id="designDescription" v-model="formNuevos.disenio.descripcion" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Diseño Contenido -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold text-gray-800">Diseño contenido</h2>
                                <button type="button" @click="addDesingContent"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Agregar contenido
                                </button>
                            </div>
                            <div v-for="(content, index) in formNuevos.disenioContenido" :key="index"
                                class="bg-gray-50 p-4 rounded-md space-y-4">
                                <div>
                                    <label :for="'contentTitle' + index"
                                        class="block text-sm font-medium text-gray-700">Titulo</label>
                                    <input type="text" :id="'contentTitle' + index" v-model="content.titulo"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label :for="'contentSubtitle' + index"
                                        class="block text-sm font-medium text-gray-700">Subtitulo</label>
                                    <input type="text" :id="'contentSubtitle' + index" v-model="content.subtitulo"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label :for="'contentDescription' + index"
                                        class="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea :id="'contentDescription' + index" v-model="content.descripcion" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>
                                <div>
                                    <label :for="'contentImage' + index"
                                        class="block text-sm font-medium text-gray-700">Imagen</label>
                                    <input type="file" :id="'contentImage' + index"
                                        @change="event => onfileUploadDesingContent(event, index)"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <button type="button" @click="removeDesingContent(index)"
                                    class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                        <!-- Colores -->
                        <div class="space-y-4">
                            <h2 class="text-xl font-semibold text-gray-800">Colores</h2>
                            <div>
                                <label for="colores" class="block text-sm font-medium text-gray-700">Imagen</label>
                                <input type="file" id="colores" multiple @change="onfileUploadColores"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
                            </div>
                        </div>
                        <!-- Seguridad o tecnologia -->
                        <div class="space-y-4">
                            <h2 class="text-xl font-semibold text-gray-800">Seguridad-Tecnologia</h2>
                            <div class="space-y-4">
                                <div>
                                    <label for="designHeader"
                                        class="block text-sm font-medium text-gray-700">Titulo</label>
                                    <input type="text" id="designTitle" v-model="formNuevos.tecnologiaContenido.titulo"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="designHeader"
                                        class="block text-sm font-medium text-gray-700">Encabezado</label>
                                    <input type="text" id="designHeader"
                                        v-model="formNuevos.tecnologiaContenido.encabezado"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="designDescription"
                                        class="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea id="designDescription"
                                        v-model="formNuevos.tecnologiaContenido.descripcion" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- Tecnologia Contenido -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold text-gray-800"> Contenido de Seguridad-Tecnologia</h2>
                                <button type="button" @click="addTecnologiaContenido"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Agregar contenido
                                </button>
                            </div>
                            <div v-for="(content, index) in formNuevos.tecnologiaContenido" :key="index"
                                class="bg-gray-50 p-4 rounded-md space-y-4">
                                <div>
                                    <label :for="'contentTitle' + index"
                                        class="block text-sm font-medium text-gray-700">Titulo</label>
                                    <input type="text" :id="'contentTitle' + index" v-model="content.titulo"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label :for="'contentSubtitle' + index"
                                        class="block text-sm font-medium text-gray-700">Subtitulo</label>
                                    <input type="text" :id="'contentSubtitle' + index" v-model="content.subtitulo"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label :for="'contentDescription' + index"
                                        class="block text-sm font-medium text-gray-700">Descripción</label>
                                    <textarea :id="'contentDescription' + index" v-model="content.descripcion" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>
                                <div>
                                    <label :for="'contentImage' + index"
                                        class="block text-sm font-medium text-gray-700">Imagen</label>
                                    <input type="file" :id="'contentImage' + index"
                                        @change="event => onfileUploadTecnologiaContenido(event, index)"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <button type="button" @click="removeTecnologiaContenido(index)"
                                    class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Eliminar contenido
                                </button>
                            </div>
                        </div>
                        <!-- Galeria -->
                        <div class="space-y-4">
                            <h2 class="text-xl font-semibold text-gray-800">Galería</h2>
                            <div>
                                <label for="galeria" class="block text-sm font-medium text-gray-700">Imagen</label>
                                <input type="file" id="galeria" multiple @change="onfileUploadGaleria"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>
                        </div>
                        <!-- Versiones -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-semibold text-gray-800">Versiones</h2>
                                <button type="button" @click="addVersion"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Agregar versión
                                </button>
                            </div>
                            <div v-for="(version, index) in formNuevos.versiones" :key="index"
                                class="bg-gray-50 p-4 rounded-md space-y-4">
                                <div>
                                    <label :for="'versionName' + index"
                                        class="block text-sm font-medium text-gray-700">Nombre
                                        de la versión</label>
                                    <input type="text" :id="'versionName' + index" v-model="version.nomVersion"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label :for="'versionImage' + index"
                                        class="block text-sm font-medium text-gray-700">Imagen</label>
                                    <input type="file" :id="'versionImage' + index"
                                        @change="event => onfileUploadVersion(event, index)"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <div>
                                    <label :for="'versionPrice' + index"
                                        class="block text-sm font-medium text-gray-700">Precio</label>
                                    <input type="number" :id="'versionPrice' + index"
                                        v-model="version.infoGen[0].precioVersion"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label :for="'versionPerformance' + index"
                                        class="block text-sm font-medium text-gray-700">Rendimiento</label>
                                    <input type="text" :id="'versionPerformance' + index"
                                        v-model="version.infoGen[0].rendimiento"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label :for="'versionPower' + index"
                                        class="block text-sm font-medium text-gray-700">Potencia</label>
                                    <input type="text" :id="'versionPower' + index"
                                        v-model="version.infoGen[0].potencia"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <!-- agregar caracteristicas -->
                                <div class="flex justify-between items-center">
                                    <h2 class="text-xl font-semibold text-gray-800">Características</h2>
                                    <button type="button" @click="version.caracteristicas.push('')"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Agregar
                                        Característica</button>
                                </div>
                                <div v-for="(caracteristica, carIndex) in version.caracteristicas" :key="carIndex"
                                    class="mb-4">
                                    <input type="text" :name="'caracteristica' + index + carIndex"
                                        v-model="version.caracteristicas[carIndex]"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <button type="button" @click="version.caracteristicas.splice(carIndex, 1)"
                                        class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Eliminar</button>
                                </div>
                                <button type="button" @click="removeVersion(index)"
                                    class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Eliminar versión
                                </button>
                            </div>
                        </div>

                        <!-- Boton de enviar -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Enviar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
