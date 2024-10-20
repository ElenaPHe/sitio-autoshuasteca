<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    inicios: Object,
});

</script>

<template>

    <Head title="Inicio" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contendo de inicio</h2>
        </template>



        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-end mb-4">
                            <Link :href="route('inicio.create')"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Crear
                            </Link>
                        </div>

                        <!-- <div v-for="info in inicios" :key="info.id"></div> -->
                        <div v-for="info in inicios" :key="info.id">
                            <div class="space-y-6">
                                <h1 class="text-2xl">Imagen Header</h1>
                                <div>
                                    <img :src="`/storage/${info.imagen}`" alt="Imagen principal">
                                </div>

                                <!-- <Link :href="route('inicio.editImage', info.id)"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Editar Imagen
                                </Link> -->


                                <h1 class="text-2xl">Carrusel</h1>

                                <div v-for="(image, index) in info.carrusel" :key="index">
                                    <img :src="`/storage/${image}`" alt="Imagen carrousel">
                                </div>
                                <!-- <div>
                                    <img src="" alt="Imagen carrousel">
                                </div> -->

                                <h1 class="text-2xl">Promociones</h1>
                                <div v-for="(promo, index) in info.promociones" :key="index" class="flex space-x-4">
                                    <img :src="`/storage/${promo.imagen}`" alt="Imagen promocion" class="w-1/4">
                                    <div>
                                        <h2 class="text-xl">{{ promo.titulo }}</h2>
                                        <p>{{ promo.descripcion }}</p>
                                    </div>
                                </div>


                                <div class="flex justify-end">
                                    <Link :href="`/seccionbienvenida/${info.id}/edit`"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Editar
                                    </Link>
                                    <!-- <Link href=""
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Editar
                                    </Link> -->
                                </div>
                            </div>
                            <hr class="my-4">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
