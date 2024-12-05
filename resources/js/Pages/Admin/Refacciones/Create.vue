<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    imagen: null,
    nombre: '',
    infoGeneral: {
        descripcion: '',
        numParte: '',
        stock: '',
        precio: '',
    },
    tipoRefaccion: '',
    infoKit: [
        {
            nombre: '',
            descripcion: '',
        }
    ],
    carruselKit: [],
    aplicacion: '',
});

function onFileUploadImagen(event) {
    form.imagen = event.target.files[0];
}

function onFileUploadCarrusel(event) {
    const files = Array.from(event.target.files);
    form.carruselKit = files;
}

function addKit() {
    form.infoKit.push({
        nombre: '',
        descripcion: '',
    });
}

function removeKit(index) {
    form.infoKit.splice(index, 1);
}


const submit = () => {
    form.post(route('refacciones.store'), {
        onSuccess: () => {
            form.reset();
            console.log('El formulario se ha enviado correctamente');
            window.location.href = route('refacciones.index');
        },
        onError: (error) => {
            console.log('Ha ocurrido un error al enviar el formulario', error);
        }
    });
};
</script>

<template>

    <Head title="Refacciones" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-vwtext text-xl text-gray-800 leading-tight">Formulario de Refacciones</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">


                        <form @submit.prevent="submit" class="bg-white shadow-md rounded-lg overflow-hidden"
                            enctype="multipart/form-data">
                            <div class="p-6 space-y-6">
                                <!-- Informacion general -->
                                <div class="space-y-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Información General</h2>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre
                                                Refacción</label>
                                            <input type="text" id="nombre" v-model="form.nombre"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="foto" class="block text-sm font-medium text-gray-700">Imagen
                                            </label>
                                            <input type="file" id="imagen" @change="onFileUploadImagen"
                                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-800 hover:file:bg-indigo-100">
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="descripcion"
                                                class="block text-sm font-medium text-gray-700">Descripción</label>
                                            <input type="text" id="descripcion" v-model="form.infoGeneral.descripcion"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="numParte" class="block text-sm font-medium text-gray-700">No.
                                                Parte</label>
                                            <input type="text" id="noParte" v-model="form.infoGeneral.numParte"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="stock"
                                                class="block text-sm font-medium text-gray-700">Stock</label>
                                            <input type="number" id="stock" v-model="form.infoGeneral.stock"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="precio"
                                                class="block text-sm font-medium text-gray-700">Precio</label>
                                            <input type="text" id="precio" v-model="form.infoGeneral.precio"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>

                                        <div>
                                            <label for="precio"
                                                class="block text-sm font-medium text-gray-700">Presentación</label>

                                            <select v-model="form.tipoRefaccion" name="" id=""
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                                                <option value="Unico">Unico</option>
                                                <option value="Kit">Kit Refacciones</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kit de refacciones -->
                                <div class="space-y-4" v-if="form.tipoRefaccion == 'Kit'">
                                    <div class="flex justify-between items-center">
                                        <h2 class="text-xl font-semibold text-gray-800">Información del Kit <small
                                                style="font-style: italic;">(Si no es kit no llenar)</small></h2>
                                        <button type="button" @click="addKit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Agregar Contenido del Kit
                                        </button>
                                    </div>
                                    <div v-for="(content, index) in form.infoKit" :key="index"
                                        class="bg-gray-50 p-4 rounded-md space-y-4">
                                        <h3 class="text-lg font-semibold text-gray-800">Refacción {{ index + 1 }}</h3>
                                        <div>
                                            <label :for="'contentName' + index"
                                                class="block text-sm font-medium text-gray-700">Nombre</label>
                                            <input type="text" :id="'contentName' + index" v-model="content.nombre"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <label :for="'contentDescription' + index"
                                                class="block text-sm font-medium text-gray-700">Descripción</label>
                                            <input type="text" :id="'contentDescription' + index"
                                                v-model="content.descripcion"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>



                                        <button type="button" @click="removeKit(index)"
                                            class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Eliminar
                                        </button>
                                    </div>
                                </div>

                                <!-- Carrusel Kit -->
                                <div class="space-y-4"  v-if="form.tipoRefaccion == 'Kit'">
                                    <h2 class="text-xl font-semibold text-gray-800">Carrusel kit <small
                                            class="italic">Tambien añade la foto del kit</small> </h2>
                                    <div>
                                        <label for="colores"
                                            class="block text-sm font-medium text-gray-700">Imagen</label>
                                        <input type="file" id="colores" multiple @change="onFileUploadCarrusel"
                                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                            accept="image/*">
                                    </div>
                                </div>

                                <!-- Aplicacion -->
                                <div class="space-y-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Aplicación</h2>
                                    <div>
                                        <label for="colores" class="block text-sm font-medium text-gray-700">Mencionar
                                            la compatibilidad de autos</label>
                                        <textarea id="aplicacion" v-model="form.aplicacion"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
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
            </div>
        </div>
    </AuthenticatedLayout>
</template>
