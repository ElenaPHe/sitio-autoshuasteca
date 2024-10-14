<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const isContentLoaded = ref(false);

onMounted(() => {
    // Add a small delay to trigger the load animation
    setTimeout(() => {
        isContentLoaded.value = true;
    }, 300);
});
</script>

<template>

    <Head title="Autos Nuevos" />

    <UserLayout>
        <div class="relative h-screen pt-8">


            <!-- Contenido adicional -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <h2 :class="[
                    'text-3xl font-bold mb-4 transition-all duration-1000 ease-out font-vwheadbold',
                    { 'opacity-0 translate-y-[20px]': !isContentLoaded, 'opacity-100 translate-y-0': isContentLoaded }
                ]">
                    Autos nuevos
                </h2>

            </div>
            <div class="h-screen">
                <h1>Hola</h1>


            </div>

        </div>
    </UserLayout>
</template>

<style scoped>
/* Puedes agregar estilos adicionales aquí si es necesario */
</style>
