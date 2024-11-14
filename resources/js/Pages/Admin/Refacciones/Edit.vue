<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    refacciones: Object,
});

const form = useForm({
    // imagen: props.refacciones.imagen || '',
    nombre: props.refacciones.nombre || '',
    infoGeneral: {
        descripcion: props.refacciones.infoGeneral.descripcion || '',
        numParte: props.refacciones.infoGeneral.numParte || '',
        stock: props.refacciones.infoGeneral.stock || '',
        precio: props.refacciones.infoGeneral.precio || '',
    },
    tipoRefaccion: props.refacciones.tipoRefaccion || '',
    infoKit: [
        {
            nombre: props.refacciones.infoKit.nombre || '',
        }
    ],
    // carruselKit: props.refacciones.carruselKit || [],
    aplicacion: props.refacciones.aplicacion || '',
});

//manejo para cambiar la imagen del auto
const formImagen = useForm({
    imagen: null,
})
function onFileUploadImagen(event){
    const file = event.target.files[0];
    formImagen.imagen = file;
}
const subirImagen = () => {
    formImagen.post(route('refacciones.subirImagen', props.refacciones.id), {
        onSuccess: () => {
            formImagen.reset();
            console.log('Imagen actualizada');
            window.location = route('refacciones.index');
        }
    });
};
function eliminarImagen(){
    formImagen.delete(route('refacciones.eliminarImagen', props.refacciones.id), {
        onSuccess: () => {
            formImagen.reset();
            console.log('Imagen eliminada');
            window.location = route('refacciones.index');
        }
    });
}

//manejo para cambiar la imagen del carrusel
const formCarrusel = useForm({
    carruselKit: [],
});
function onFileUploadCarrusel(event){
    formCarrusel.carruselKit.push(event.target.files[0]);
}
const subirImagenCarrusel = () => {
    formCarrusel.post(route('refacciones.subirCarrusel', props.refacciones.id), {
        onSuccess: () => {
            formCarrusel.reset();
            console.log('Carrusel actualizado');
            location.reload();
        }
    });
};
function eliminarImagenCarrusel(index){
    if(confirm('¿Estás seguro de eliminar esta imagen?')){
        formCarrusel.delete(route('refacciones.eliminarCarrusel', { id: props.refacciones.id, index: index }), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Imagen eliminada');
                window.location.reload();
            },
            onError: (errors) => {
                console.log(errors);
            }
        });
    }
}


function addKit(){
    form.infoKit.push({
        nombre: '',
    });
}

function removeKit(index){
    form.infoKit.splice(index, 1);
}

const actualizaRefaccion = () => {
    form.put(route('refacciones.update', props.refacciones.id, ), {
        onSuccess: () => {
            form.reset();
            console.log('Refaccion actualizada');
            // window.location = route('refacciones.index');
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
};
</script>

<template>

    <Head title="Refacciones" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-vwtext text-xl text-gray-800 leading-tight">Contendo de Refacciones</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">


                        <form @submit.prevent="actualizaRefaccion" class="bg-white shadow-md rounded-lg overflow-hidden" enctype="multipart/form-data">
                            <div class="p-6 space-y-6">
                                <!-- Informacion general -->
                                <div class="space-y-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Información general de {{ props.refacciones.nombre }} </h2>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- <div>
                                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre Refacción</label>
                                            <input type="text" id="nombre" v-model="form.nombre" disabled
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div> -->
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                                            <input type="text" id="descripcion" v-model="form.infoGeneral.descripcion"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="numParte" class="block text-sm font-medium text-gray-700">No. Parte</label>
                                            <input type="text" id="noParte" v-model="form.infoGeneral.numParte"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
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

                                                <select v-model="form.tipoRefaccion" name="" id="" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                                                    <option value="Unico">Refacción</option>
                                                    <option value="Kit">Kit Refacciones</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Kit de refacciones -->
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <h2 class="text-xl font-semibold text-gray-800">Información del Kit <small style="font-style: italic;">(Si no es kit no llenar)</small></h2>
                                        <button type="button" @click="addKit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Agregar Contenido del Kit
                                        </button>
                                    </div>
                                    <div v-for="(content, index) in form.infoKit" :key="index"
                                        class="bg-gray-50 p-4 rounded-md space-y-4">
                                        <div>
                                            <label :for="'contentName' + index"
                                                class="block text-sm font-medium text-gray-700">Nombre</label>
                                            <input type="text" :id="'contentName' + index" v-model="content.nombre"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>



                                        <button type="button" @click="removeKit(index)"
                                            class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                                <!-- Carrusel Kit -->
                                <!-- <div class="space-y-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Carrusel kit</h2>
                                    <div>
                                        <label for="colores" class="block text-sm font-medium text-gray-700">Imagen</label>
                                        <input type="file" id="colores" multiple @change="onFileUploadCarrusel"
                                            class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
                                    </div>
                                </div> -->
                                <!-- Aplicacion -->
                                <div class="space-y-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Aplicación</h2>
                                    <div>
                                        <label for="colores" class="block text-sm font-medium text-gray-700">Mencionar la compatibilidad de autos</label>
                                        <textarea id="aplicacion" v-model="form.aplicacion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
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


                    <div class="mb-4">
                        <p>Foto de la refaccion</p>
                        <template v-if="props.refacciones.imagen">
                            <img :src="`/storage/${props.refacciones.imagen}`" alt="Foto del auto" class="mt-4 h-40">
                            <button @click="eliminarImagen"
                                class="mt-2 px-4 py-2 bg-red-500 text-white rounded-md">Eliminar Imagen</button>
                        </template>
                        <template v-else>
                            <form @submit.prevent="subirImagen" class="space-y-6" enctype="multipart/form-data">
                                <label for="fotoAuto" class="block text-sm font-medium text-gray-700">
                                    Foto de la refacción
                                </label>
                                <input type="file" @change="onFileUploadImagen" class="mt-1 block
                                    w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none
                                    focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" accept="image/*">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Subir
                                    Imagen</button>
                            </form>
                        </template>
                    </div>

                    <div class="mb-4">
                        <p>Imagenes del carrusel </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <template v-if="props.refacciones.carruselKit && props.refacciones.carruselKit.length">
                                <div v-for="(imagen, index) in props.refacciones.carruselKit" :key="index"
                                    class="bg-white p -4 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                                    <img :src="`/storage/${imagen}`" alt="Color"
                                        class="w-full h-48 object-cover rounded-md mb-3">
                                    <button @click.prevent="eliminarImagenCarrusel(index)"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out">Eliminar
                                        Imagen</button>
                                </div>
                            </template>
                            <template v-else>
                                <p>No hay imagenes en el carrusel de refaccion</p>
                            </template>
                            <form @submit.prevent="subirImagenCarrusel" class="space-y-6"
                                enctype="multipart/form-data">
                                <label for="colores" class="block text-sm font-medium text-gray-700">
                                    Refacciones
                                </label>
                                <input type="file" @change="onFileUploadCarrusel" class="mt-1 block
                                w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none
                                focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" accept="image/*">
                                <button type="submit"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Subir imagen
                                    de la refaccion</button>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
