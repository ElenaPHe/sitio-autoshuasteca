<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    seminuevo: Object // Pasamos el registro existente como prop
});

const formImagen = useForm({
    fotoAuto: null
});

const formCarrusel = useForm({
    carrusel: []
});


function onFileChange(event) {
    formImagen.fotoAuto = event.target.files[0];
}

function onFileChangeCarrusel(event) {
    formCarrusel.carrusel = Array.from(event.target.files);
}



function subirImagen() {
    formImagen.post(route('seminuevos.subirImagen', props.seminuevo.id), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('La imagen se ha subido correctamente');
            formImagen.reset();
            window.location.reload();
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
}

function eliminarImagen() {
    if (confirm('¿Estás seguro de eliminar la imagen?')) {
        formImagen.delete(route('seminuevos.eliminarImagen', props.seminuevo.id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('La imagen se ha eliminado correctamente');
                window.location.reload();
            },
            onError: (errors) => {
                console.log(errors);
            }
        });
    }
}

function subirCarrusel() {
    formCarrusel.post(route('seminuevos.subirCarrusel', props.seminuevo.id), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Las imágenes del carrusel se han subido correctamente');
            formCarrusel.reset('carrusel');
            window.location.reload();
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
}

function eliminarCarrusel() {
    if (confirm('¿Estás seguro de eliminar el carrusel de imágenes?')) {
        formCarrusel.delete(route('seminuevos.eliminarCarrusel', props.seminuevo.id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('El carrusel de imágenes se ha eliminado correctamente');
                window.location.reload();
            },
            onError: (errors) => {
                console.log(errors);
            }
        });
    }
}




const form = useForm({
    infoGeneral: {
        marca: props.seminuevo.infoGeneral.marca || '',
        modelo: props.seminuevo.infoGeneral.modelo || '',
        year: props.seminuevo.infoGeneral.year || '',
        kilometraje: props.seminuevo.infoGeneral.kilometraje || '',
        color: props.seminuevo.infoGeneral.color || '',
        numpuertas: props.seminuevo.infoGeneral.numpuertas || '',
        transmision: props.seminuevo.infoGeneral.transmision || '',
        motor: props.seminuevo.infoGeneral.motor || '',
        colorInterno: props.seminuevo.infoGeneral.colorInterno || '',
        tipoAuto: props.seminuevo.infoGeneral.tipoAuto || '',
        precio: props.seminuevo.infoGeneral.precio || '',
        precioAnterior: props.seminuevo.infoGeneral.precioAnterior || '',
    },
    descripcion: props.seminuevo.descripcion || '',
    infoDistribuidor: {
        nombre: props.seminuevo.infoDistribuidor.nombre || '',
        estado: props.seminuevo.infoDistribuidor.estado || '',
        ciudad: props.seminuevo.infoDistribuidor.ciudad || '',
        fechaAlta: props.seminuevo.infoDistribuidor.fechaAlta || '',
        telefono: props.seminuevo.infoDistribuidor.telefono || ''
    }
});

const submit = () => {
    form.put(route('seminuevos.update', props.seminuevo.id), {
        onSuccess: () => {
            console.log('El formulario se ha actualizado correctamente');
            window.location.href = route('seminuevos.index');
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
};

// Para inicializar valores en caso de que quieras hacer algo en la carga de la vista
onMounted(() => {
    // Aquí puedes agregar lógica si es necesario
});
</script>

<template>

    <Head title="Editar Seminuevo" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Formulario de Seminuevo</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <h1 class="text-3xl font-bold text-gray-900 mb-8">
                            Información de {{ props.seminuevo.infoGeneral.marca }} {{ props.seminuevo.infoGeneral.modelo }} {{ props.seminuevo.infoGeneral.year }}
                          </h1>

                        <div class="mb-6 space-y-6 bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <!-- Foto del Auto -->
                            <label for="imagen" class="block text-gray-700 text-sm font-semibold">
                                Subir Nueva Imagen
                            </label>
                            <template v-if="props.seminuevo.fotoAuto">
                                <div class="flex flex-col items-center space-y-3">
                                    <img :src="`/storage/${props.seminuevo.fotoAuto}`" alt="Foto del Auto"
                                        class="w-48 h-auto rounded shadow-lg border border-gray-200" />
                                    <label class="text-gray-700 text-sm font-semibold">
                                        Cambiar Foto del Auto <span class="text-gray-500">(Opcional):</span>
                                    </label>
                                    <button @click="eliminarImagen"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-red-400">
                                        Eliminar Imagen
                                    </button>
                                </div>
                            </template>

                            <template v-else>
                                <form @submit.prevent="subirImagen"
                                    class="space-y-4 border border-gray-200 rounded-lg p-4 shadow-lg bg-white">
                                    <label for="imagen" class="block text-gray-700 text-sm font-medium">
                                        Subir Nueva Imagen
                                    </label>
                                    <input id="imagen" type="file" @change="onFileChange"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-700"
                                        accept="image/*" />
                                    <button type="submit"
                                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        Subir Imagen
                                    </button>
                                </form>
                            </template>
                        </div>


                        <form @submit.prevent="submit" enctype="multipart/form-data"
                            class="space-y-6 bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <!-- Información General -->
                            <div class="space-y-4">
                                <label class="block text-gray-800 text-lg font-semibold">
                                    Información General:
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <input v-model="form.infoGeneral.marca" type="text" disabled
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-200 text-gray-500"
                                        placeholder="Marca" />
                                    <input v-model="form.infoGeneral.modelo" type="text" disabled
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-200 text-gray-500"
                                        placeholder="Modelo" />
                                    <input v-model="form.infoGeneral.year" type="text" disabled
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-200 text-gray-500"
                                        placeholder="Año" />
                                    <input v-model="form.infoGeneral.kilometraje" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Kilometraje" />
                                    <input v-model="form.infoGeneral.color" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Color" style="text-transform: capitalize;" />
                                    <input v-model="form.infoGeneral.numpuertas" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Número de Puertas" />
                                    <select
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        v-model="form.infoGeneral.transmision">
                                        <option value="">Selecciona una transmisión</option>
                                        <option value="Manual">Manual</option>
                                        <option value="Automatica">Automática</option>
                                    </select>
                                    <input v-model="form.infoGeneral.motor" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Motor" />
                                    <input v-model="form.infoGeneral.colorInterno" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Color Interno" style="text-transform: capitalize;" />
                                    <input v-model="form.infoGeneral.tipoAuto" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Tipo de Auto" />
                                    <input v-model="form.infoGeneral.precio" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Precio" />
                                    <input v-model="form.infoGeneral.precioAnterior" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Precio Anterior" />
                                </div>
                            </div>

                            <!-- Descripción -->
                            <div class="space-y-2">
                                <label class="block text-gray-800 text-lg font-semibold">
                                    Descripción:
                                </label>
                                <textarea v-model="form.descripcion"
                                    class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Descripción del auto"></textarea>
                            </div>

                            <!-- Información del Distribuidor -->
                            <div class="space-y-4">
                                <label class="block text-gray-800 text-lg font-semibold">
                                    Información del Distribuidor:
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <input v-model="form.infoDistribuidor.nombre" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Nombre del Distribuidor" />
                                    <input v-model="form.infoDistribuidor.estado" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Estado" />
                                    <input v-model="form.infoDistribuidor.ciudad" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Ciudad" />
                                    <input v-model="form.infoDistribuidor.fechaAlta" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Fecha de Alta" />
                                    <input v-model="form.infoDistribuidor.telefono" type="text"
                                        class="block w-full p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Teléfono" />
                                </div>
                            </div>

                            <!-- Botón de Envío -->
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-400">
                                    Actualizar
                                </button>
                            </div>
                        </form>



                        <div class="mb-6 space-y-6 bg-white p-6 rounded-lg shadow-md border border-gray-200 mt-6">
                            <!-- Fotos del carrusel -->
                            <template v-if="props.seminuevo.carrusel && props.seminuevo.carrusel.length > 0">
                                <div>
                                    <label class="block text-gray-800 text-lg font-semibold mb-2">Imágenes del Carrusel:</label>
                                    <div class="flex flex-wrap gap-4">
                                        <img
                                            v-for="img in props.seminuevo.carrusel"
                                            :key="img"
                                            :src="`/storage/${img}`"
                                            class="w-32 h-32 object-cover rounded-lg border border-gray-200 shadow-md"
                                            alt="Imagen Carrusel"
                                        />
                                    </div>
                                    <div class="mt-4 flex items-center gap-4">
                                        <label class="block text-gray-700 text-sm font-bold">Cambiar las imágenes del carrusel:</label>
                                        <button
                                            @click="eliminarCarrusel"
                                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-red-400"
                                        >
                                            Cambiar Carrusel
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <template v-else>
                                <form @submit.prevent="subirCarrusel" class="space-y-4">
                                    <label class="block text-gray-800 text-lg font-semibold">Subir Carrusel de Imágenes:</label>
                                    <input
                                        type="file"
                                        multiple
                                        @change="onFileChangeCarrusel"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                        accept="image/*"
                                    />
                                    <button
                                        type="submit"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-400"
                                    >
                                        Subir Carrusel
                                    </button>
                                </form>
                            </template>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
