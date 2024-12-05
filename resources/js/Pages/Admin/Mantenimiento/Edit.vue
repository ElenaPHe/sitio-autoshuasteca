<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Inicializar el formulario con los datos existentes del mantenimiento
const props = defineProps(['mantenimiento']);

const formImagen = useForm({
    imagen: null
});

function onFileChange(event) {
    formImagen.imagen = event.target.files[0];
}

function subirImagen() {
    formImagen.post(route('mantenimiento.subirImagen', props.mantenimiento.id), {
        onSuccess: () => {
            console.log('Imagen subida correctamente');
            formImagen.reset();
            window.location.reload();
        },
        onError: (errors) => {
            console.log('Error al subir la imagen', errors);
        },
    });
}

function eliminarImagen() {
    if (confirm('¿Estás seguro de que deseas eliminar la imagen?')) {
        formImagen.delete(route('mantenimiento.eliminarImagen', props.mantenimiento.id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Imagen eliminada correctamente');
                window.location.reload();
            },
            onError: (errors) => {
                console.log('Error al eliminar la imagen', errors);
            },
        });
    }
}

const form = useForm({
    titulo: props.mantenimiento.titulo,
    paqueteOne: props.mantenimiento.paqueteOne,
    paqueteTwo: props.mantenimiento.paqueteTwo,
    paqueteThree: props.mantenimiento.paqueteThree,
    paqueteFour: props.mantenimiento.paqueteFour,
    paqueteFive: props.mantenimiento.paqueteFive,
    paqueteSix: props.mantenimiento.paqueteSix,
    paqueteSeven: props.mantenimiento.paqueteSeven,
    paqueteEight: props.mantenimiento.paqueteEight,
    paqueteNine: props.mantenimiento.paqueteNine,
});

// Función para manejar el envío del formulario
function submit() {
    form.put(route('mantenimiento.actualizar', props.mantenimiento.id), {
        onSuccess: () => {
            console.log('Formulario enviado correctamente');
        },
        onError: (errors) => {
            console.log('Error al enviar el formulario', errors);
        },
    });
}
</script>

<template>
    <Head title="Editar Mantenimiento" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Formulario de Mantenimiento</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1 class="text-3xl font-bold text-gray-900 mb-8">
                            Información de {{ props.mantenimiento.titulo }}
                          </h1>

                          <div class="mb-6 space-y-6 bg-white p-6 rounded-lg shadow-md border border-gray-200">
                            <!-- Foto del Auto -->
                            <label for="imagen" class="block text-gray-700 text-sm font-semibold">
                                Subir Nueva Imagen
                            </label>
                            <template v-if="props.mantenimiento.imagen">
                                <div class="flex flex-col items-center space-y-3">
                                    <img :src="`/storage/${props.mantenimiento.imagen}`" alt="Foto del Auto"
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

                        <form @submit.prevent="submit" class="space-y-6" enctype="multipart/form-data">
                            <!-- Titulo -->
                            <div>
                                <label for="titulo" class="block text-sm font-medium text-gray-700">
                                    Modelo de auto
                                </label>

                                <!-- Input para el titulo -->
                                <input type="text" id="titulo" name="titulo" v-model="form.titulo"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>



                            <div>
                                <label for="paqueteOne" class="block text-sm font-medium text-gray-700">
                                    Paquete 1: 15 mil km. / 1 año
                                </label>

                                <!-- Input para el paquete 1 -->
                                <input type="number" id="paqueteOne" name="paqueteOne" v-model="form.paqueteOne"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteTwo" class="block text-sm font-medium text-gray-700">
                                    Paquete 2: 30 mil km. / 2 años
                                </label>

                                <!-- Input para el paquete 2 -->
                                <input type="number" id="paqueteTwo" name="paqueteTwo" v-model="form.paqueteTwo"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteThree" class="block text-sm font-medium text-gray-700">
                                    Paquete 3: 45 mil km. / 3 años
                                </label>

                                <!-- Input para el paquete 3 -->
                                <input type="number" id="paqueteThree" name="paqueteThree" v-model="form.paqueteThree"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteFour" class="block text-sm font-medium text-gray-700">
                                    Paquete 4: 60 mil km. / 4 años
                                </label>

                                <!-- Input para el paquete 4 -->
                                <input type="number" id="paqueteFour" name="paqueteFour" v-model="form.paqueteFour"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteFive" class="block text-sm font-medium text-gray-700">
                                    Paquete 5: 75 mil km. / 5 años
                                </label>

                                <!-- Input para el paquete 5 -->
                                <input type="number" id="paqueteFive" name="paqueteFive" v-model="form.paqueteFive"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteSix" class="block text-sm font-medium text-gray-700">
                                    Paquete 6: 90 mil km. / 6 años
                                </label>

                                <!-- Input para el paquete 6 -->
                                <input type="number" id="paqueteSix" name="paqueteSix" v-model="form.paqueteSix"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteSeven" class="block text-sm font-medium text-gray-700">
                                    Paquete 7: 105 mil km. / 7 años
                                </label>

                                <!-- Input para el paquete 7 -->
                                <input type="number" id="paqueteSeven" name="paqueteSeven" v-model="form.paqueteSeven"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteEight" class="block text-sm font-medium text-gray-700">
                                    Paquete 8: 120 mil km. / 8 años
                                </label>

                                <!-- Input para el paquete 8 -->
                                <input type="number" id="paqueteEight" name="paqueteEight" v-model="form.paqueteEight"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex justify-end">
                                <Link :href="route('mantenimiento.index')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 mr-4">Cancelar</Link>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
