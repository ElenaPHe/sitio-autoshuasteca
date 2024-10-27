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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contendo de Seminuevos</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-start mb-4">
                            <h1>Formulario Autos Seminuevos</h1>
                        </div>

                        <form @submit.prevent="submit" enctype="multipart/form-data">
                            <!-- Foto del Auto -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Foto del Auto:</label>
                                <input type="file" @change="form.fotoAuto = $event.target.files[0]" class="block w-full" accept="image/*" />
                            </div>

                            <!-- Información General -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Información General:</label>
                                <input v-model="form.infoGeneral.marca" type="text" class="block w-full" placeholder="Marca" />
                                <input v-model="form.infoGeneral.modelo" type="text" class="block w-full" placeholder="Modelo" />
                                <input v-model="form.infoGeneral.year" type="text" class="block w-full mt-2" placeholder="Año" />
                                <input v-model="form.infoGeneral.kilometraje" type="text" class="block w-full mt-2" placeholder="Kilometraje" />
                                <input v-model="form.infoGeneral.color" type="text" class="block w-full mt-2" placeholder="Color" />
                                <input v-model="form.infoGeneral.numpuertas" type="text" class="block w-full mt-2" placeholder="Número de Puertas" />
                                <input v-model="form.infoGeneral.transmision" type="text" class="block w-full mt-2" placeholder="Transmisión" />
                                <input v-model="form.infoGeneral.motor" type="text" class="block w-full mt-2" placeholder="Motor" />
                                <input v-model="form.infoGeneral.colorInterno" type="text" class="block w-full mt-2" placeholder="Color Interno" />
                                <input v-model="form.infoGeneral.tipoAuto" type="text" class="block w-full mt-2" placeholder="Tipo de Auto" />
                                <input v-model="form.infoGeneral.version" type="text" class="block w-full mt-2" placeholder="Version" />
                                <input v-model="form.infoGeneral.precio" type="text" class="block w-full mt-2" placeholder="Precio" />
                                <input v-model="form.infoGeneral.precioAnterior" type="text" class="block w-full mt-2" placeholder="Precio Anterior" />


                            </div>

                            <!-- Descripción -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                                <textarea v-model="form.descripcion" class="block w-full" placeholder="Descripción del auto"></textarea>
                            </div>

                            <!-- Información del Distribuidor -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Información del Distribuidor:</label>
                                <input v-model="form.infoDistribuidor.nombre" type="text" class="block w-full" placeholder="Nombre del Distribuidor" />
                                <input v-model="form.infoDistribuidor.estado" type="text" class="block w-full mt-2" placeholder="Estado" />
                                <input v-model="form.infoDistribuidor.ciudad" type="text" class="block w-full mt-2" placeholder="Ciudad" />
                                <input v-model="form.infoDistribuidor.fechaAlta" type="text" class="block w-full mt-2" placeholder="Fecha de Alta" />
                                <input v-model="form.infoDistribuidor.telefono" type="text" class="block w-full mt-2" placeholder="Teléfono" />
                            </div>

                            <!-- Carrusel (Múltiples Imágenes) -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Carrusel de Imágenes:</label>
                                <input type="file" multiple @change="form.carrusel = $event.target.files" class="block w-full" accept="image/*" />
                            </div>

                            <!-- Botón de Envío -->
                            <div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
