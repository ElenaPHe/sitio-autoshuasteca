<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="max-w-md mx-auto bg-slate-100 p-6 rounded-lg">
            <div class="flex justify-center mb-8">
                <svg viewBox="0 0 1024 1024" class="w-24 h-24" xmlns="http://www.w3.org/2000/svg" fill="rgb(0,30,80)">
                    <g
                        transform="matrix(10.188387870788574, 0, 0, 10.188387870788574, -251.519936680809, -252.79260253906244)">
                        <path
                            d="M75,120.4c-24.9,0-45.3-20.5-45.3-45.4c0-5.6,1-10.9,2.9-15.9l26.5,53.3c0.3,0.7,0.8,1.3,1.6,1.3 c0.8,0,1.3-0.6,1.6-1.3l12.2-27.3c0.1-0.3,0.3-0.6,0.6-0.6s0.4,0.3,0.6,0.6l12.2,27.3c0.3,0.7,0.8,1.3,1.6,1.3 c0.8,0,1.3-0.6,1.6-1.3l26.5-53.3c1.9,5,2.9,10.3,2.9,15.9C120.3,99.9,99.9,120.4,75,120.4z M75,64.7c-0.3,0-0.4-0.3-0.6-0.6 l-14.2-32c4.6-1.7,9.6-2.6,14.8-2.6c5.2,0,10.2,0.9,14.8,2.6l-14.2,32C75.4,64.5,75.3,64.7,75,64.7z M60.5,97.6 c-0.3,0-0.4-0.3-0.6-0.6l-23-46.4c4.1-6.3,9.6-11.6,16.3-15.3l16.6,36.9C70,72.8,70.5,73,71,73h8c0.6,0,1-0.1,1.3-0.8l16.6-36.9 c6.6,3.7,12.2,9,16.3,15.3L90,97c-0.1,0.3-0.3,0.6-0.6,0.6c-0.3,0-0.4-0.3-0.6-0.6l-8.7-19.8c-0.3-0.7-0.7-0.8-1.3-0.8h-8 c-0.6,0-1,0.1-1.3,0.8L61.1,97C61,97.3,60.8,97.6,60.5,97.6z M75,125c27.7,0,50-22.3,50-50c0-27.7-22.3-50-50-50 c-27.7,0-50,22.3-50,50C25,102.7,47.3,125,75,125z" />
                    </g>
                </svg>
            </div>
            <form @submit.prevent="submit" class="font-vwtext">
                <div class="mt-4">
                    <InputLabel for="email" value="Correo Electronico"/>
                    <TextInput id="email" type="email" class="block w-full mt-1" v-model="form.email" required autofocus
                        autocomplete="username" />
                    <InputError class="mt-2 " :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />
                    <TextInput id="password" type="password" class="block w-full mt-1" v-model="form.password" required
                        autocomplete="current-password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="flex justify-center mt-6">
                    <PrimaryButton class="w-auto bg-[#00B0F0] hover:bg-[#0094d2] text-white py-2 px-4 rounded-md text-center"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Iniciar sesión
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>
