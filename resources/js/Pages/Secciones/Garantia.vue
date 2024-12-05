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

    <Head title="Home" />

    <UserLayout>
        <!-- <div class="relative h-screen">
            <div class=" text-center mb-8">
                <h2 class="text-5xl font-vwheadbold pt-20">Más kilómetros de vida para tu Volkswagen</h2>
                <p class="font-vwtext pt-6">Conoce los beneficios y plazos de nuestras garantías para mantener al máximo el valor de tu Volkswagen.</p>
            </div>

            <div class="my-12">
                <h2 class="text-5xl font-vwheadbold text-center mb-8 pt-8">Garantía Extendida</h2>
                <div class="flex flex-col md:flex-row items-center">
                    <div class="w-full md:w-1/2">
                        <p class="font-vwheadlight">
                            Volkswagen extiende la garantía de tu vehículo para que lo único a lo que te dediques es a disfrutar tu auto. <br> <br> Sabemos lo importante que es tu Volkswagen, por ello la Garantía Extendida Volkswagen te permite mantener los beneficios de la garantía de fábrica por más tiempo por 6 años o 125,000 km (considerando la cobertura de la garantía de fábrica).
                        </p>
                        <ul class="list-disc list-inside">
                            Beneficios:
                            <li.>Mantenimiento preventivo</li.>
                            <li>Reparaciones especializadas</li>
                            <li>Actualización de software</li>
                            <li>Inspección de seguridad</li>
                        </ul>
                    </div>
                    <div class="w-full md:w-1/2 h-[300px] md:h-[400px]" style="background-image: url('https://vw-huasteca.com.mx/Assets/img/garantia/garantia-img-03.jpg');">
                    </div>
                </div>
            </div>


        </div> -->

    </UserLayout>
</template>

<style scoped>
/* Puedes agregar estilos adicionales aquí si es necesario */
</style>
