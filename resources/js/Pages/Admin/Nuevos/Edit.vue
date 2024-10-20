<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    inicio: Object,
});

const form = useForm({
    imagen: props.inicio.imagen || null,
    carrousel: props.inicio.carrousel || [],
    promociones: props.inicio.promociones || [
        {
            titulo: props.inicio.promociones[0].titulo || '',
            imagen: props.inicio.promociones[0].imagen || null,
            descripcion: props.inicio.promociones[0].descripcion || '',
        }
    ],
});

function handleFileUpload(event, index = null, field = 'carrousel') {
    const files = Array.from(event.target.files);
    form.carrousel = files;
}

const handleImageUpload = (event, field, index = null) => {
    const file = event.target.files[0];

    if (field === 'imagen') {
        form.imagen = file;
    } else if (field === 'promociones') {
        form.promociones[index].imagen = file;
    }
}

function addPromocion() {
    form.promociones.push({
        titulo: '',
        imagen: null,
        descripcion: '',
    });
}

function removePromocion(index) {
    form.promociones.splice(index, 1);
}

function submit() {
    alert('Enviando formulario');
    console.log(form);
    form.put(`/inicio/${props.inicio.id}`, {
        onSuccess: () => {
            console.log('Formulario enviado');
        },

        onError: (errors) => {
            console.log('Error al enviar formulario', errors);
        },
    });
}

</script>

<template>

    <Head title="Editar inicio" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar inicio</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <label for="imagen" class="block text-sm font-medium text-gray-700">
                                    Imagen de inicio
                                </label>
                                <div class="mb-2">
                                    <img :src="`/storage/${props.inicio.imagen}`" alt="Imagen actual" class="w-32 h-32 object-cover">
                                </div>
                                <input type="file" id="imagen" name="imagen"
                                    @change="event => handleImageUpload(event, 'imagen')"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="carrousel" class="block text-sm font-medium text-gray-700">
                                    Carrousel
                                </label>
                                <div class="mb-2 flex space-x-2">
                                    <div v-for="(image, index) in props.inicio.carrousel" :key="index">
                                        <img :src="`/storage/${image}`" alt="Imagen carrousel actual" class="w-32 h-32 object-cover">
                                    </div>
                                </div>
                                <input type="file" id="carrousel" name="carrousel"
                                    @change="event => handleFileUpload(event)" multiple
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="promociones" class="block text-sm font-medium text-gray-700">
                                    Promociones
                                </label>
                                <div v-for="(promo, index) in form.promociones" :key="index" class="mb-4">
                                    <div class="flex space-x-4">
                                        <input type="text" v-model="promo.titulo" placeholder="titulo de la promocion"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                        <div class="mb-2">
                                            <img :src="`/storage/${promo.imagen}`" alt="Imagen promocion actual" class="w-32 h-32 object-cover" v-if="promo.imagen">
                                        </div>
                                        <input type="file" @change="event => handleImageUpload(event, 'promociones', index)" id="promociones-imagen" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" >
                                        <input type="text" v-model="promo.descripcion" placeholder="descripcion de la promocion"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                        <button @click.prevent="removePromocion(index)" class="bg-red-500 text-white px-4 py-2 rounded">Eliminar</button>
                                    </div>
                                </div>
                                <button @click.prevent="addPromocion" class="bg-green-500 text-white px-4 py-2 rounded">Agregar promocion</button>
                            </div>
                            <div class="flex justify-end">
                                <Link href="/inicio" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 mr-4">Cancelar</Link>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
                            </div>
                        </form>
                        <div class=" flex justify-end mb-4">
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
    </AuthenticatedLayout>
</template>
