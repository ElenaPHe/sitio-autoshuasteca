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
            window.location = route('refacciones.edit', props.refacciones.id);
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

        <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
              <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-6 sm:p-10">
                  <h1 class="text-3xl font-bold text-gray-900 mb-8">
                    Información de {{ props.refacciones.nombre }}
                  </h1>

                  <form @submit.prevent="actualizaRefaccion" enctype="multipart/form-data">
                    <!-- Información general -->
                    <section class="mb-10">
                      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Información general</h2>
                      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                          <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                          <input type="text" id="descripcion" v-model="form.infoGeneral.descripcion"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                          <label for="numParte" class="block text-sm font-medium text-gray-700 mb-1">No. Parte</label>
                          <input type="text" id="noParte" v-model="form.infoGeneral.numParte"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                          <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                          <input type="number" id="stock" v-model="form.infoGeneral.stock"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                          <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">Precio</label>
                          <input type="text" id="precio" v-model="form.infoGeneral.precio"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                          <label for="tipoRefaccion" class="block text-sm font-medium text-gray-700 mb-1">Presentación</label>
                          <select v-model="form.tipoRefaccion" id="tipoRefaccion"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="Unico">Refacción</option>
                            <option value="Kit">Kit Refacciones</option>
                          </select>
                        </div>
                      </div>
                    </section>

                    <!-- Kit de refacciones -->
                    <section class="mb-10">
                      <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">Información del Kit</h2>
                        <button type="button" @click="addKit"
                          class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                          Agregar Contenido del Kit
                        </button>
                      </div>
                      <p class="text-sm text-gray-500 italic mb-4">Si no es kit, no llenar</p>
                      <div v-for="(content, index) in form.infoKit" :key="index" class="bg-gray-50 p-6 rounded-lg mb-4">
                        <div class="mb-4">
                          <label :for="'contentName' + index" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                          <input type="text" :id="'contentName' + index" v-model="content.nombre"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <button type="button" @click="removeKit(index)"
                          class="px-3 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                          Eliminar
                        </button>
                      </div>
                    </section>

                    <!-- Aplicación -->
                    <section class="mb-10">
                      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Aplicación</h2>
                      <div>
                        <label for="aplicacion" class="block text-sm font-medium text-gray-700 mb-1">Mencionar la compatibilidad de autos</label>
                        <textarea id="aplicacion" v-model="form.aplicacion" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                      </div>
                    </section>

                    <!-- Botón de enviar -->
                    <div class="flex justify-end">
                      <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Guardar cambios
                      </button>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Imágenes -->
              <div class="mt-10 bg-white shadow-xl rounded-lg overflow-hidden">
                <div class="p-6 sm:p-10">
                  <h2 class="text-2xl font-semibold text-gray-800 mb-6">Imágenes</h2>

                  <!-- Foto principal -->
                  <section class="mb-10">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Foto principal de la refacción</h3>
                    <div v-if="props.refacciones.imagen" class="mb-4">
                      <img :src="`/storage/${props.refacciones.imagen}`" alt="Foto del auto" class="w-full max-w-md h-auto rounded-lg shadow-md">
                      <button @click="eliminarImagen"
                        class="mt-4 px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                        Eliminar Imagen
                      </button>
                    </div>
                    <form v-else @submit.prevent="subirImagen" enctype="multipart/form-data" class="space-y-4">
                      <div>
                        <label for="fotoAuto" class="block text-sm font-medium text-gray-700 mb-1">
                          Subir foto de la refacción
                        </label>
                        <input type="file" id="fotoAuto" @change="onFileUploadImagen" accept="image/*"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                      </div>
                      <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        Subir Imagen
                      </button>
                    </form>
                  </section>

                  <!-- Imágenes del carrusel -->
                  <section>
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Imágenes del carrusel</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mb-6">
                      <div v-for="(imagen, index) in props.refacciones.carruselKit" :key="index"
                        class="bg-white rounded-lg shadow-md overflow-hidden">
                        <img :src="`/storage/${imagen}`" alt="Imagen del carrusel" class="w-full h-48 object-cover">
                        <div class="p-4">
                          <button @click.prevent="eliminarImagenCarrusel(index)"
                            class="w-full px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                            Eliminar Imagen
                          </button>
                        </div>
                      </div>
                    </div>
                    <form @submit.prevent="subirImagenCarrusel" enctype="multipart/form-data" class="space-y-4">
                      <div>
                        <label for="imagenCarrusel" class="block text-sm font-medium text-gray-700 mb-1">
                          Subir imagen para el carrusel
                        </label>
                        <input type="file" id="imagenCarrusel" @change="onFileUploadCarrusel" accept="image/*"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                      </div>
                      <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        Subir imagen al carrusel
                      </button>
                    </form>
                  </section>
                </div>
              </div>
            </div>
          </div>
    </AuthenticatedLayout>
</template>
