<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Inicializar el formulario con los datos existentes del mantenimiento
const props = defineProps(['mantenimiento']);

const form = useForm({
    titulo: props.mantenimiento.titulo,
    imagen: null,
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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Mantenimiento</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
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
                                <label for="imagen" class="block text-sm font-medium text-gray-700">
                                    Imagen
                                </label>

                                <!-- Input para la imagen -->
                                <input type="file" id="imagen" name="imagen" @change="event => form.imagen = event.target.files[0]"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteOne" class="block text-sm font-medium text-gray-700">
                                    Paquete 1: 15 mil km. / 1 año
                                </label>

                                <!-- Input para el paquete 1 -->
                                <input type="text" id="paqueteOne" name="paqueteOne" v-model="form.paqueteOne"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteTwo" class="block text-sm font-medium text-gray-700">
                                    Paquete 2: 30 mil km. / 2 años
                                </label>

                                <!-- Input para el paquete 2 -->
                                <input type="text" id="paqueteTwo" name="paqueteTwo" v-model="form.paqueteTwo"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteThree" class="block text-sm font-medium text-gray-700">
                                    Paquete 3: 45 mil km. / 3 años
                                </label>

                                <!-- Input para el paquete 3 -->
                                <input type="text" id="paqueteThree" name="paqueteThree" v-model="form.paqueteThree"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteFour" class="block text-sm font-medium text-gray-700">
                                    Paquete 4: 60 mil km. / 4 años
                                </label>

                                <!-- Input para el paquete 4 -->
                                <input type="text" id="paqueteFour" name="paqueteFour" v-model="form.paqueteFour"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteFive" class="block text-sm font-medium text-gray-700">
                                    Paquete 5: 75 mil km. / 5 años
                                </label>

                                <!-- Input para el paquete 5 -->
                                <input type="text" id="paqueteFive" name="paqueteFive" v-model="form.paqueteFive"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteSix" class="block text-sm font-medium text-gray-700">
                                    Paquete 6: 90 mil km. / 6 años
                                </label>

                                <!-- Input para el paquete 6 -->
                                <input type="text" id="paqueteSix" name="paqueteSix" v-model="form.paqueteSix"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteSeven" class="block text-sm font-medium text-gray-700">
                                    Paquete 7: 105 mil km. / 7 años
                                </label>

                                <!-- Input para el paquete 7 -->
                                <input type="text" id="paqueteSeven" name="paqueteSeven" v-model="form.paqueteSeven"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label for="paqueteEight" class="block text-sm font-medium text-gray-700">
                                    Paquete 8: 120 mil km. / 8 años
                                </label>

                                <!-- Input para el paquete 8 -->
                                <input type="text" id="paqueteEight" name="paqueteEight" v-model="form.paqueteEight"
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
