<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, defineEmits, ref } from 'vue';

const props = defineProps({
  nuevos: Object,
  titulo: {
    type: String,
    default: '¿Estás seguro de eliminar este auto?',
  },
  mensaje: {
    type: String,
    default: 'Una vez eliminado, no podrás recuperar este auto.',
  }
});

const form = useForm({
  estado: false,
});

function cambiarEstado(id) {
  form.post(route('nuevos.cambiarEstado', id),
    {
      onSuccess: () => {
        console.log('success');
      },
      onError: (error) => {
        console.log(error);
      },
      preserveScroll: true,
      preserveState: true,
    });
}


const visibleDelete = ref(false);
const confirmado = ref(false);
const emit = defineEmits(['confirmar', 'cancelar', 'accionCompletada']);

const deleteId = ref(null);

function openDeleteModal(id) {
  visibleDelete.value = true;
  deleteId.value = id;
}

function confirmar() {
  form.delete(route('nuevos.destroy', deleteId.value), {
    preserveScroll: true,

    onSuccess: () => {
      confirmado.value = true;
      setTimeout(() => {
        visibleDelete.value = false;
        emit('confirmar');
        emit('accionCompletada', 'Auto eliminado correctamente');
        location.href = route('nuevos.index');
        console.log('success');
      }, 3000);
    },
    onError: (error) => {
      console.log(error);
    },
  });
}
const cancelar = () => {
  visibleDelete.value = false;
  emit('cancelar');
};


console.log(props.nuevos);
</script>

<template>

  <Head title="Autos Nuevos" />
  <AuthenticatedLayout>
    <!-- <template #header>
      <h2 class="font-vwheadbold text-xl text-gray-800 leading-tight">Contenido de Nuevos</h2>
    </template> -->

    <div class="py-0 bg-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white sm:rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-xl">
          <div class="p-8 bg-gray-100">
            <div class="flex justify-end mb-8">
              <Link :href="route('nuevos.create')"
                class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-full font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-300 ease-in-out">
                Crear Nuevo
              </Link>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
              <div v-for="infoNuevo in nuevos" :key="infoNuevo.id"
                class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2">
                <h1 class="font-bold text-gray-800 text-xl mb-3">{{ infoNuevo.modelo }}</h1>
                <div class="relative overflow-hidden rounded-lg mb-4 group">
                  <img :src="`/storage/${infoNuevo.fotoAuto}`" :alt="`Imagen de ${infoNuevo.modelo}`"
                    class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110">

                </div>
                <div class="flex flex-wrap gap-2 justify-between">
                  <Link :href="`/seccion-nuevos/${infoNuevo.id}/edit`"
                    class="flex-grow bg-blue-500 text-white px-4 py-2 rounded-md font-medium hover:bg-blue-600 transition duration-300 ease-in-out transform hover:-translate-y-1 text-center">
                    Editar
                  </Link>
                  <button @click="cambiarEstado(infoNuevo.id)"
                    :class="infoNuevo.estado ? 'border border-red-500 text-red-600 hover:text-white hover:bg-red-500' : 'border border-green-500 text-green-600  hover:text-white hover:bg-green-500'"
                    class="flex-grow px-4 py-2 rounded-md font-medium transition duration-300 ease-in-out transform hover:-translate-y-1">
                    {{ infoNuevo.estado ? 'Deshabilitar' : 'Habilitar' }}
                  </button>
                  <button @click="openDeleteModal(infoNuevo.id)"
                    class="flex-grow bg-red-500 text-white px-4 py-2 rounded-md font-medium hover:bg-red-600 transition duration-300 ease-in-out transform hover:-translate-y-1">
                    Eliminar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <Transition name="fade">
      <div v-if="visibleDelete" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>
        <div class="bg-white rounded-lg p-8 shadow-xl z-10 max-w-md w-full mx-4">
          <div class="text-center">
            <div v-if="!confirmado"
              class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
              <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
            </div>
            <div v-else class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
              <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
              </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ titulo }}</h3>
            <p class="text-sm text-gray-500 mb-4">{{ mensaje }}</p>
            <div v-if="!confirmado" class="flex justify-center space-x-4">
              <button @click="confirmar"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-green-500">
                Confirmar
              </button>
              <button @click="cancelar"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-transparent rounded-md hover:bg-gray-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-gray-500">
                Cancelar
              </button>
            </div>
          </div>
        </div>
      </div>
    </Transition>

  </AuthenticatedLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.checkmark__circle {
  stroke-dasharray: 166;
  stroke-dashoffset: 166;
  stroke-width: 2;
  stroke-miterlimit: 10;
  stroke: #7ac142;
  fill: none;
  animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark__check {
  transform-origin: 50% 50%;
  stroke-dasharray: 48;
  stroke-dashoffset: 48;
  stroke: #7ac142;
  stroke-width: 3;
  fill: none;
  animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
  100% {
    stroke-dashoffset: 0;
  }
}
</style>
