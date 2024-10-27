<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps({
    seminuevo: Object,
});

const isContentLoaded = ref(false);

onMounted(() => {
    setTimeout(() => {
        isContentLoaded.value = true;
    }, 300);
});

console.log(props.seminuevo);
</script>

<template>

    <Head title="Autos Seminuevos" />

    <UserLayout>
        <div class="relative min-h-screen pt-8 bg-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <h2 :class="[
                    'text-4xl font-bold mb-8 text-center transition-all duration-1000 ease-out font-vwheadbold text-gray-800',
                    { 'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded }
                ]">
                   Info Seminuevo {{ props.seminuevo.infoGeneral.modelo }}
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <h1>{{ props.seminuevo.descripcion }}</h1>
                </div>

                <!-- Link para regresar a seminuevos.index-->
                <div class="flex justify-center mt-8">
                    <Link :href="route('seminuevos')"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Regresar
                    </Link>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<style scoped>
.relative:hover img {
    transform: scale(1.1);
}
</style>
