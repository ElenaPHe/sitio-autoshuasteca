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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Auto Seminuevo</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-start mb-4">
                            <h1>Formulario para Editar Autos Seminuevos</h1>
                        </div>

                        <div class="mb-4">

                            <!-- Foto del Auto -->
                            <template v-if="props.seminuevo.fotoAuto">

                                <img :src="`/storage/${props.seminuevo.fotoAuto}`" alt="Foto Actual"
                                    class="mb-2 w-48 h-auto">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Cambiar Foto del Auto
                                    (Opcional):</label>

                                <button @click="eliminarImagen" class="bg-red-500 text-white px-3 py-1 rounded-lg">Eliminar Imagen</button>

                            </template>

                            <template v-else>
                                <form @submit.prevent="subirImagen">
                                    <label for="">Subir Nueva Imagen</label>
                                    <input type="file" @change="onFileChange" class="block w-full" accept="image/*" />
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Subir
                                        Imagen</button>
                                </form>
                            </template>



                        </div>

                        <form @submit.prevent="submit" enctype="multipart/form-data">

                            <!-- Información General -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Información General:</label>
                                <input v-model="form.infoGeneral.marca" type="text" class="block w-full"
                                    placeholder="Marca" />
                                <input v-model="form.infoGeneral.modelo" type="text" class="block w-full mt-2"
                                    placeholder="Modelo" />
                                <input v-model="form.infoGeneral.year" type="text" class="block w-full mt-2"
                                    placeholder="Año" />
                                <input v-model="form.infoGeneral.kilometraje" type="text" class="block w-full mt-2"
                                    placeholder="Kilometraje" />
                                <input v-model="form.infoGeneral.color" type="text" class="block w-full mt-2"
                                    placeholder="Color" style="text-transform: capitalize;" />
                                <input v-model="form.infoGeneral.numpuertas" type="text" class="block w-full mt-2"
                                    placeholder="Número de Puertas" />
                                <!-- <input v-model="form.infoGeneral.transmision" type="text"  class="block w-full mt-2"
                                    placeholder="Transmisión" /> -->
                                    <select class="block w-full mt-2" name="" id="" v-model="form.infoGeneral.transmision">
                                        <option value="">Selecciona una transmisión</option>
                                        <option value="manual">Manual</option>
                                        <option value="automatica">Automática</option>
                                    </select>
                                <input v-model="form.infoGeneral.motor" type="text" class="block w-full mt-2"
                                    placeholder="Motor" />
                                <input v-model="form.infoGeneral.colorInterno" type="text" class="block w-full mt-2"
                                    placeholder="Color Interno" style="text-transform: capitalize;"  />
                                <input v-model="form.infoGeneral.tipoAuto" type="text" class="block w-full mt-2"
                                    placeholder="Tipo de Auto" />
                                <input v-model="form.infoGeneral.precio" type="text" class="block w-full mt-2"
                                    placeholder="Precio" />
                                <input v-model="form.infoGeneral.precioAnterior" type="text" class="block w-full mt-2"
                                    placeholder="Precio Anterior" />
                            </div>

                            <!-- Descripción -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                                <textarea v-model="form.descripcion" class="block w-full"
                                    placeholder="Descripción del auto"></textarea>
                            </div>

                            <!-- Información del Distribuidor -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Información del
                                    Distribuidor:</label>
                                <input v-model="form.infoDistribuidor.nombre" type="text" class="block w-full"
                                    placeholder="Nombre del Distribuidor" />
                                <input v-model="form.infoDistribuidor.estado" type="text" class="block w-full mt-2"
                                    placeholder="Estado" />
                                <input v-model="form.infoDistribuidor.ciudad" type="text" class="block w-full mt-2"
                                    placeholder="Ciudad" />
                                <input v-model="form.infoDistribuidor.fechaAlta" type="text" class="block w-full mt-2"
                                    placeholder="Fecha de Alta" />
                                <input v-model="form.infoDistribuidor.telefono" type="text" class="block w-full mt-2"
                                    placeholder="Teléfono" />
                            </div>

                            <!-- Botón de Envío -->
                            <div>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Actualizar</button>
                            </div>
                        </form>


                        <div class="mb-4">

                            <!-- Foto del Auto -->
                            <template v-if="props.seminuevo.carrusel && props.seminuevo.carrusel.length > 0">
                                <div class="flex flex-wrap gap-2">
                                    <img v-for="img in props.seminuevo.carrusel" :key="img" :src="`/storage/${img}`"
                                        class="w-32 h-auto mb-2" alt="Imagen Carrusel">
                                </div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Cambiar las imagenes del carrusel :</label>
                                <button @click="eliminarCarrusel" class="bg-green-500 text-white px-3 py-1 rounded-lg">Cambiar carrusel</button>
                            </template>

                            <template v-else>
                                <form @submit.prevent="subirCarrusel">
                                    <label for="">Subir Carrusel de Imagenes</label>
                                    <input type="file" multiple @change="onFileChangeCarrusel" class="block w-full" accept="image/*" />
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Subir
                                        Carrusel</button>
                                </form>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
