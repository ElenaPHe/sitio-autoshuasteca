<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    nuevo: Object,
});

// const formNuevos = useForm({
//     modelo: '',
//     fotoAuto: null, // Inicializamos como null porque será un archivo
//     infoGeneral: {
//         eslogan: '',
//         precio: '',
//         motor: '',
//         transmision: '',
//         potencia: '',
//         torque: '',
//         versiones: '',
//     },
//     desing: {
//         titulo: '',
//         encabezado: '',
//         descripcion: '',
//     },
//     desingContent: [
//         {
//             titulo: '',
//             subtitulo: '',
//             descripcion: '',
//             imagen: null,
//         }
//     ],
//     colores: [],
//     tecnologia: {
//         titulo: '',
//         encabezado: '',
//         descripcion: '',
//     },
//     tecnologiaContenido: [
//         {
//             titulo: '',
//             subtitulo: '',
//             descripcion: '',
//             imagen: null,
//         }
//     ],
//     galeria: [],
//     versiones: [
//         {
//             nomVersion: '',
//             imagen: null,
//             infoGen: [
//                 {
//                     precioVersion: '',
//                     rendimiento: '',
//                     potencia: '',
//                 }
//             ],
//             caracteristicas: [],
//         }
//     ],
// });

// Función para manejar la subida de imágenes

const formNuevos = useForm({
    modelo: props.nuevo.modelo || '',
    // fotoAuto: props.nuevo.fotoAuto || null,
    infoGeneral: {
        eslogan: props.nuevo.infoGeneral.eslogan || '',
        precio: props.nuevo.infoGeneral.precio || '',
        motor: props.nuevo.infoGeneral.motor || '',
        transmision: props.nuevo.infoGeneral.transmision || '',
        potencia: props.nuevo.infoGeneral.potencia || '',
        torque: props.nuevo.infoGeneral.torque || '',
        versiones: props.nuevo.infoGeneral.versiones || '',
    },
    disenio: {
        titulo: props.nuevo.disenio?.titulo || '',
        encabezado: props.nuevo.disenio?.encabezado || '',
        descripcion: props.nuevo.disenio?.descripcion || '',
    },
    disenioContenido: props.nuevo.disenioContenido || [
        {
            titulo: props.nuevo.disenioContenido?.titulo || '',
            subtitulo: props.nuevo.disenioContenido?.subtitulo || '',
            descripcion: props.nuevo.disenioContenido?.descripcion || '',
            imagen: props.nuevo.disenioContenido?.imagen || null,
        }
    ],
    colores: props.nuevo.colores || [],
    tecnologia: {
        titulo: props.nuevo.tecnologia?.titulo || '',
        encabezado: props.nuevo.tecnologia?.encabezado || '',
        descripcion: props.nuevo.tecnologia?.descripcion || '',
    },
    tecnologiaContenido: props.nuevo.tecnologiaContenido || [
        {
            titulo: props.nuevo.tecnologiaContenido?.titulo || '',
            subtitulo: props.nuevo.tecnologiaContenido?.subtitulo || '',
            descripcion: props.nuevo.tecnologiaContenido?.descripcion || '',
            // imagen: props.nuevo.tecnologiaContenido?.imagen || null,
        }
    ],
    // galeria: props.nuevo.galeria || [],
    versiones: props.nuevo.versiones || [
        {
            nomVersion: props.nuevo.versiones?.nomVersion || '',
            // imagen: props.nuevo.versiones?.imagen || null,
            infoGen: [
                {
                    precioVersion: props.nuevo.versiones?.infoGen?.precioVersion || '',
                    rendimiento: props.nuevo.versiones?.infoGen?.rendimiento || '',
                    potencia: props.nuevo.versiones?.infoGen?.potencia || '',
                }
            ],
            caracteristicas: props.nuevo.versiones?.caracteristicas || [],
        }
    ],
});

function onfileUploadAuto(event) {
    const file = event.target.files[0];
    formNuevos.fotoAuto = file;
}

function onfileUploadDesingContent(event, index) {
    const file = event.target.files[0];
    formNuevos.disenioContenido[index].imagen = file;
}

function onfileUploadColores(event) {
    const files = Array.from(event.target.files);
    formNuevos.colores = files;
}

function onfileUploadTecnologiaContenido(event, index) {
    const file = event.target.files[0];
    formNuevos.tecnologiaContenido[index].imagen = file;
}

// Función para manejar la subida de imágenes de galeria
function onfileUploadGaleria(event) {
    const files = Array.from(event.target.files);
    formNuevos.galeria = files;
}

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

function removeDesingContent(index) {
    formNuevos.disenioContenido.splice(index, 1);
}

function addTecnologiaContenido() {
    formNuevos.tecnologiaContenido.push({
        titulo: '',
        subtitulo: '',
        descripcion: '',
        imagen: null,
    });
}
function removeTecnologiaContenido(index) {
    formNuevos.tecnologiaContenido.splice(index, 1);
}

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
function removeVersion(index) {
    formNuevos.versiones.splice(index, 1);
}

const actualizaAuto = () => {
    formNuevos.put(route('nuevos.update', props.nuevo.id), {
        onSuccess: () => {
            formNuevos.reset();
            console.log('El formulario se ha actualizado correctamente');
            window.location.href = route('nuevos.index');
        }
    });
};

</script>

<template>

    <Head title="Inicio" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contendo de inicio</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="">

                            <form @submit.prevent="actualizaAuto" enctype="multipart/form-data">

                                <!-- Modelo -->
                                <div class="mb-4">
                                    <label for="modelo" class="block text-sm font-medium text-gray-700">
                                        Modelo
                                    </label>
                                    <input type="text" name="modelo" id="modelo" v-model="formNuevos.modelo"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <!-- Foto del Auto
                                <div class="mb-4">
                                    <label for="fotoAuto" class="block text-sm font-medium text-gray-700">
                                        Foto del Auto
                                    </label>
                                    <input type="file" id="fotoAuto" name="fotoAuto" @change="onfileUploadAuto"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div> -->

                                <!-- Información General -->
                                <div class="mb-4">
                                    <label for="eslogan" class="block text-sm font-medium text-gray-700">
                                        Eslogan
                                    </label>
                                    <input type="text" name="eslogan" id="eslogan"
                                        v-model="formNuevos.infoGeneral.eslogan"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                    <label for="precio" class="block text-sm font-medium text-gray-700">
                                        Precio
                                    </label>
                                    <input type="text" name="precio" id="precio" v-model="formNuevos.infoGeneral.precio"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                    <label for="motor" class="block text-sm font-medium text-gray-700">
                                        Motor
                                    </label>
                                    <input type="text" name="motor" id="motor" v-model="formNuevos.infoGeneral.motor"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                    <label for="motor" class="block text-sm font-medium text-gray-700">
                                        Transmisión
                                    </label>
                                    <input type="text" name="trans" id="trans"
                                        v-model="formNuevos.infoGeneral.transmision"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                    <label for="motor" class="block text-sm font-medium text-gray-700">
                                        Potencia
                                    </label>
                                    <input type="text" name="pote" id="pote" v-model="formNuevos.infoGeneral.potencia"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                    <label for="motor" class="block text-sm font-medium text-gray-700">
                                        Torque
                                    </label>
                                    <input type="text" name="torque" id="torque" v-model="formNuevos.infoGeneral.torque"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                    <label for="motor" class="block text-sm font-medium text-gray-700">
                                        Versiones
                                    </label>
                                    <input type="text" name="versiones" id="versiones"
                                        v-model="formNuevos.infoGeneral.versiones"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <!-- Diseño -->
                                <div class="mb-4">
                                    <label for="titulo" class="block text-sm font-medium text-gray-700">
                                        Título
                                    </label>
                                    <input type="text" name="titulo" id="titulo" v-model="formNuevos.disenio.titulo"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                    <label for="encabezado" class="block text
                                    -sm font-medium text-gray-700">
                                        Encabezado
                                    </label>
                                    <input type="text" name="encabezado" id="encabezado"
                                        v-model="formNuevos.disenio.encabezado"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                    <label for="descripcion" class="block text-sm font-medium text-gray-700">
                                        Descripción
                                    </label>
                                    <textarea name="descripcion" id="descripcion"
                                        v-model="formNuevos.disenio.descripcion"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>

                                <!-- Diseño de Contenido -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Diseño de Contenido</label>
                                    <button type="button" @click="addDesingContent"
                                        class="mt-1 mb-2 px-4 py-2 bg-blue-500 text-white rounded-md">Agregar Diseño de
                                        Contenido</button>
                                    <div v-for="(content, index) in formNuevos.disenioContenido" :key="index"
                                        class="mb-4 border p-4 rounded-md">
                                        <label for="titulo"
                                            class="block text-sm font-medium text-gray-700">Título</label>
                                        <input type="text" :name="'titulo' + index" v-model="content.titulo"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                        <label for="subtitulo"
                                            class="block text-sm font-medium text-gray-700">Subtítulo</label>
                                        <input type="text" :name="'subtitulo' + index" v-model="content.subtitulo"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                        <label for="descripcion"
                                            class="block text-sm font-medium text-gray-700">Descripción</label>
                                        <textarea :name="'descripcion' + index" v-model="content.descripcion"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>

                                        <label for="imagen"
                                            class="block text-sm font-medium text-gray-700">Imagen</label>
                                        <input type="file" :name="'imagen' + index"
                                            @change="event => onfileUploadDesingContent(event, index)"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                        <button type="button" @click="removeDesingContent(index)"
                                            class="mt-2 px-4 py-2 bg-red-500 text-white rounded-md">Eliminar</button>
                                    </div>
                                </div>

                                <!-- Colores -->
                                <!-- Colores -->
                                <div class="mb-4">
                                    <label for="colores" class="block text-sm font-medium text-gray-700">
                                        Colores
                                    </label>
                                    <input type="file" id="colores" name="colores" accept="image/*" multiple
                                        @change="onfileUploadColores"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <!-- <div class="mt-2">
                                        <div v-for="(color, index) in formNuevos.colores" :key="index" class="inline-block mr-2">
                                            <img :src="URL.createObjectURL(color)" alt="Color" class="h-10 w-10 object-cover rounded-full">
                                        </div>
                                    </div> -->
                                </div>

                                <!-- Tecnología -->
                                <div class="mb-4">
                                    <label for="titulo" class="block text-sm font-medium text-gray-700">
                                        Título
                                    </label>
                                    <input type="text" name="titulo" id="titulo" v-model="formNuevos.tecnologia.titulo"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                    <label for="encabezado" class="block text
                                    -sm font-medium text-gray-700">
                                        Encabezado
                                    </label>
                                    <input type="text" name="encabezado" id="encabezado"
                                        v-model="formNuevos.tecnologia.encabezado"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                    <label for="descripcion" class="block text-sm font-medium text-gray-700">
                                        Descripción
                                    </label>
                                    <textarea name="descripcion" id="descripcion"
                                        v-model="formNuevos.tecnologia.descripcion"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>

                                <!-- Tecnología de Contenido -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Tecnología de
                                        Contenido</label>
                                    <button type="button" @click="addTecnologiaContenido"
                                        class="mt-1 mb-2 px-4 py-2 bg-blue-500 text-white rounded-md">Agregar Tecnología
                                        de
                                        Contenido</button>
                                    <div v-for="(content, index) in formNuevos.tecnologiaContenido" :key="index"
                                        class="mb-4 border p-4 rounded-md">
                                        <label for="titulo"
                                            class="block text-sm font-medium text-gray-700">Título</label>
                                        <input type="text" :name="'titulo' + index" v-model="content.titulo"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                        <label for="subtitulo"
                                            class="block text-sm font-medium text-gray-700">Subtítulo</label>
                                        <input type="text" :name="'subtitulo' + index" v-model="content.subtitulo"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                        <label for="descripcion"
                                            class="block text-sm font-medium text-gray-700">Descripción</label>
                                        <textarea :name="'descripcion' + index" v-model="content.descripcion"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>

                                        <label for="imagen"
                                            class="block text-sm font-medium text-gray-700">Imagen</label>
                                        <input type="file" :name="'imagen' + index"
                                            @change="event => onfileUploadTecnologiaContenido(event, index)"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                        <button type="button" @click="removeTecnologiaContenido(index)"
                                            class="mt-2 px-4 py-2 bg-red-500 text-white rounded-md">Eliminar</button>
                                    </div>
                                </div>

                                <!-- Galería -->
                                <div class="mb-4">
                                    <label for="galeria" class="block text-sm font-medium text-gray-700">
                                        Galería
                                    </label>
                                    <input type="file" id="galeria" name="galeria" accept="image/*" multiple
                                        @change="onfileUploadGaleria"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <!-- <div class="mt-2">
                                        <div v-for="(imagen, index) in formNuevos.galeria" :key="index" class="inline-block mr-2">
                                            <img :src="URL.createObjectURL(imagen)" alt="Imagen" class="h-10 w-10 object-cover rounded-full">
                                        </div>
                                    </div> -->
                                </div>

                                <!-- Versiones -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Versiones</label>
                                    <button type="button" @click="addVersion"
                                        class="mt-1 mb-2 px-4 py-2 bg-blue-500 text-white rounded-md">Agregar
                                        Versión</button>
                                    <div v-for="(version, index) in formNuevos.versiones" :key="index"
                                        class="mb-4 border p-4 rounded-md">
                                        <label for="nomVersion" class="block text-sm font-medium text-gray-700">Nombre
                                            de la
                                            Versión</label>
                                        <input type="text" :name="'nomVersion' + index" v-model="version.nomVersion"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                        <label for="imagen"
                                            class="block text-sm font-medium text-gray-700">Imagen</label>
                                        <input type="file" :name="'imagen' + index"
                                            @change="event => onfileUploadVersion(event, index)"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                        <div class="mt-4">
                                            <label class="block text-sm font-medium text-gray-700">Información
                                                General</label>
                                            <div v-for="(info, infoIndex) in version.infoGen" :key="infoIndex"
                                                class="mb-4">
                                                <label for="precioVersion"
                                                    class="block text-sm font-medium text-gray-700">Precio</label>
                                                <input type="text" :name="'precioVersion' + index + infoIndex"
                                                    v-model="info.precioVersion"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                                <label for="rendimiento"
                                                    class="block text-sm font-medium text-gray-700">Rendimiento</label>
                                                <input type="text" :name="'rendimiento' + index + infoIndex"
                                                    v-model="info.rendimiento"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                                                <label for="potencia"
                                                    class="block text-sm font-medium text-gray-700">Potencia</label>
                                                <input type="text" :name="'potencia' + index + infoIndex"
                                                    v-model="info.potencia"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label
                                                class="block text-sm font-medium text-gray-700">Características</label>
                                            <button type="button" @click="version.caracteristicas.push('')"
                                                class="mt-1 mb-2 px-4 py-2 bg-blue-500 text-white rounded-md">Agregar
                                                Característica</button>
                                            <div v-for="(caracteristica, carIndex) in version.caracteristicas"
                                                :key="carIndex" class="mb-4">
                                                <input type="text" :name="'caracteristica' + index + carIndex"
                                                    v-model="version.caracteristicas[carIndex]"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <button type="button"
                                                    @click="version.caracteristicas.splice(carIndex, 1)"
                                                    class="mt-2 px-4 py-2 bg-red-500 text-white rounded-md">Eliminar</button>
                                            </div>
                                        </div>

                                        <button type="button" @click="removeVersion(index)"
                                            class="mt-2 px-4 py-2 bg-red-500 text-white rounded-md">Eliminar
                                            Versión</button>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded justify-center text-center">
                                        Actualizar
                                    </button>
                                </div>

                            </form>
                        </div>

                        <div class="mb-4">
                            <template v-if="props.nuevo.fotoAuto">
                                <img :src="`/storage/${props.nuevo.fotoAuto}`" alt="Foto del auto" class="mt-4 h-40">
                                <button @click="eliminarFotoAuto"
                                    class="mt-2 px-4 py-2 bg-red-500 text-white rounded-md">Eliminar Imagen</button>
                            </template>
                            <template v-else>
                                <form @submit.prevent="subirImagenAuto" class="space-y-6" enctype="multipart/form-data">
                                    <label for="fotoAuto" class="block text-sm font-medium text-gray-700">
                                        Foto del auto
                                    </label>
                                    <input type="file" @change="onFileChangeAuto" class="mt-1 block
                                        w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Subir
                                        Imagen</button>
                                </form>
                            </template>
                        </div>

                        <div class="mb-4">
                            <template v-if="props.nuevo.galeria">
                                <div v-for="(imagen, index) in props.nuevo.galeria" :key="index">
                                    <img :src="`/storage/${imagen}`" alt="Imagen de galería" class="mt-2 h-20">
                                    <button @click.prevent="eliminarImagenGaleria(index)"
                                        class="bg-red-500 text-white px-4 py-2 rounded">Eliminar Imagen</button>
                                </div>
                            </template>
                            <template v-else>
                                <form @submit.prevent="subirImagenGaleria" class="space-y-6"
                                    enctype="multipart/form-data">
                                    <label for="galeria" class="block text-sm font-medium text-gray-700">
                                        Galería
                                    </label>
                                    <input type="file" @change="onFileChangeGaleria" class="mt-1 block
                                        w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Subir
                                        Imagen</button>
                                </form>
                            </template>

                        </div>

                        <div class="mb-4">
                            <template v-if="props.nuevo.colores">
                                <div v-for="(color, index) in props.nuevo.colores" :key="index">
                                    <img :src="`/storage/${color}`" alt="Color" class="mt-2 h-20">
                                    <button @click.prevent="eliminarImagenColor(index)"
                                        class="bg-red-500 text-white px-4 py-2 rounded">Eliminar Imagen</button>
                                </div>
                            </template>
                            <template v-else>
                                <form @submit.prevent="subirImagenColor" class="space-y-6"
                                    enctype="multipart/form-data">
                                    <label for="colores" class="block text-sm font-medium text-gray-700">
                                        Colores
                                    </label>
                                    <input type="file" @change="onFileChangeColor" class="mt-1 block
                                        w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Subir
                                        Carrusel</button>
                                </form>
                            </template>
                        </div>

                        <div class="mb-4">
                            <template v-if="props.nuevo.versiones">
                                <div v-for="(version, index) in props.nuevo.versiones" :key="index">
                                    <div>{{ version.nomVersion }}</div>
                                    <img :src="`/storage/${version.imagen}`" alt="Imagen de versión" class="mt-2 h-20">
                                    <div v-for="(info, infoIndex) in version.infoGen" :key="infoIndex">
                                        <div>{{ info.precioVersion }}</div>
                                        <div>{{ info.rendimiento }}</div>
                                        <div>{{ info.potencia }}</div>
                                    </div>
                                    <div v-for="(caracteristica, carIndex) in version.caracteristicas" :key="carIndex">
                                        <div>{{ caracteristica }}</div>
                                    </div>
                                    <button @click.prevent="eliminarImagenVersion(index)"
                                        class="bg-red-500 text-white px-4 py-2 rounded">Eliminar Imagen</button>
                                </div>
                            </template>
                            <template v-else>
                                <form @submit.prevent="subirImagenVersion" class="space-y-6"
                                    enctype="multipart/form-data">
                                    <label for="versiones" class="block text
                                    -sm font-medium text-gray-700">
                                        Versiones
                                    </label>
                                    <input type="file" @change="onFileChangeVersion" class="mt-1 block
                                        w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Subir
                                        Imagen</button>
                                </form>
                            </template>
                        </div>


                        <div class="mb-4">
                            <template v-if="props.nuevo.desingContent">
                                <div v-for="(content, index) in props.nuevo.desingContent" :key="index">
                                    <div>{{ content.titulo }}</div>
                                    <div>{{ content.subtitulo }}</div>
                                    <div>{{ content.descripcion }}</div>
                                    <img :src="`/storage/${content.imagen}`" alt="Imagen de contenido"
                                        class="mt-2 h-20">
                                    <button @click.prevent="eliminarImagenDesingContent(index)"
                                        class="bg-red-500 text-white px-4 py-2 rounded">Eliminar Imagen</button>
                                </div>
                            </template>
                            <template v-else>
                                <form @submit.prevent="subirImagenDesingContent" class="space-y-6"
                                    enctype="multipart/form-data">
                                    <label for="desingContent" class="block text
                                    -sm font-medium text-gray-700">
                                        Diseño de Contenido
                                    </label>
                                    <input type="file" @change="onFileChangeDesingContent" class="mt-1 block
                                        w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Subir
                                        Imagen</button>
                                </form>
                            </template>
                        </div>


                        <div class="mb-4">
                            <template v-if="props.nuevo.tecnologiaContenido">
                                <div v-for="(content, index) in props.nuevo.tecnologiaContenido" :key="index">
                                    <div>{{ content.titulo }}</div>
                                    <div>{{ content.subtitulo }}</div>
                                    <div>{{ content.descripcion }}</div>
                                    <img :src="`/storage/${content.imagen}`" alt="Imagen de contenido"
                                        class="mt-2 h-20">
                                    <button @click.prevent="eliminarImagenTecnologiaContenido(index)"
                                        class="bg-red-500 text-white px-4 py-2 rounded">Eliminar Imagen</button>
                                </div>
                            </template>
                            <template v-else>
                                <form @submit.prevent="subirImagenTecnologiaContenido" class="space-y-6"
                                    enctype="multipart/form-data">
                                    <label for="tecnologiaContenido" class="block text
                                    -sm font-medium text-gray-700">
                                        Tecnología de Contenido
                                    </label>
                                    <input type="file" @change="onFileChangeTecnologiaContenido" class="mt-1 block
                                        w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none
                                        focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Subir
                                        Imagen</button>
                                </form>
                            </template>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
