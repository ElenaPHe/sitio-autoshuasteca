<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    fotoAuto: null, // Inicializamos como null porque será un archivo
    infoGeneral: {
        marca: '',
        modelo: '',
        year: '',
        kilometraje: '',
        color: '',
        numpuertas: '',
        transmision: '',
        motor: '',
        colorInterno: '',
        tipoAuto: '',
        precio: '',
        precioAnterior: '',
        version: '',
    },
    descripcion: '',
    infoDistribuidor: {
        nombre: '',
        estado: '',
        ciudad: '',
        fechaAlta: '',
        telefono: ''
    },
    carrusel: [] // Será un array de archivos
});

const submit = () => {
    form.post(route('seminuevos.store'), {
        onSuccess: () => {
            form.reset();
            console.log('El formulario se ha enviado correctamente');
            window.location.href = route('seminuevos.index');
        }
    });
};
</script>

<template>

    <Head title="Seminuevos" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-vwtext text-xl text-gray-800 leading-tight">Contendo de Seminuevos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-start mb-4">
                            <h1>Formulario Autos Seminuevos</h1>
                        </div>

                        <form @submit.prevent="submit" enctype="multipart/form-data"
                            class="bg-white shadow-md rounded-lg overflow-hidden">
                            <!-- Foto del Auto -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Foto del Auto:</label>
                                <input type="file" @change="form.fotoAuto = $event.target.files[0]"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-800 hover:file:bg-indigo-100" />
                            </div>
                            <h2 class="text-xl font-vwheadbold text-gray-800">Información General</h2>
                            <!-- Información General -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <input v-model="form.infoGeneral.marca" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Marca" />
                                </div>
                                <div>
                                    <input v-model="form.infoGeneral.modelo" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Modelo" />
                                </div>
                                <div>
                                    <input v-model="form.infoGeneral.year" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Año" />
                                </div>
                                <div>
                                    <input v-model="form.infoGeneral.kilometraje" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Kilometraje" />
                                </div>
                                <div>
                                    <input v-model="form.infoGeneral.color" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Color" style="text-transform: capitalize;" />
                                </div>
                                <div>
                                    <input v-model="form.infoGeneral.numpuertas" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Número de Puertas" />
                                </div>
                                <div>
                                    <!-- <input v-model="form.infoGeneral.transmision" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Transmisión" /> -->
                                        <select v-model="form.infoGeneral.transmision" name="" id="" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Seleccione una transmisión</option>
                                            <option value="manual">Manual</option>
                                            <option value="automatica">Automática</option>
                                        </select>
                                </div>
                                <div>
                                    <input v-model="form.infoGeneral.motor" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Motor" />
                                </div>
                                <div>
                                    <input v-model="form.infoGeneral.colorInterno" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Color Interno" style="text-transform: capitalize;" />
                                </div>
                                <div>
                                    <input v-model="form.infoGeneral.tipoAuto" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Tipo de Auto" />
                                </div>
                                <div>
                                    <input v-model="form.infoGeneral.version" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Version" />
                                </div>
                                <div>
                                    <input v-model="form.infoGeneral.precio" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Precio" />
                                </div>
                                <div>
                                    <input v-model="form.infoGeneral.precioAnterior" type="text"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Precio Anterior" />
                                </div>





                            </div>

                            <!-- Descripción -->
                            <h2 class="text-xl font-vwheadbold text-gray-800">Descripción</h2>
                            <div class="mb-4">
                                <textarea v-model="form.descripcion"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Descripción del auto"></textarea>
                            </div>

                            <!-- Información del Distribuidor -->
                            <h2 class="text-xl font-vwheadbold text-gray-800">Información del distruibuidor</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input v-model="form.infoDistribuidor.nombre" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Nombre del Distribuidor" />
                                <input v-model="form.infoDistribuidor.estado" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Estado" />
                                <input v-model="form.infoDistribuidor.ciudad" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Ciudad" />
                                <input v-model="form.infoDistribuidor.fechaAlta" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Fecha de Alta" />
                                <input v-model="form.infoDistribuidor.telefono" type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Teléfono" />
                            </div>

                            <!-- Carrusel (Múltiples Imágenes) -->
                            <h2 class="text-xl font-vwheadbold text-gray-800">Carrusel de imagenes</h2>
                            <div class="space-y-4">
                                <input type="file" multiple @change="form.carrusel = $event.target.files"
                                    class="mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-sm file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                    accept="image/*" />
                            </div>

                            <!-- Botón de Envío -->
                            <div>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Enviar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
