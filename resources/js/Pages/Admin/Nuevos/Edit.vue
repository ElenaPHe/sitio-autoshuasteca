<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    nuevo: Object,
});

const formNuevos = useForm({
    modelo: props.nuevo.modelo || '',
    // fotoAuto: props.nuevo.fotoAuto || null,
    infoGeneral: {
        eslogan: props.nuevo.infoGeneral.eslogan || '',
        precio: props.nuevo.infoGeneral.precio || '',
        motor: props.nuevo.infoGeneral.motor || '',
        transmision: props.nuevo.infoGeneral.transmision || '',
        potencia: props.nuevo.infoGeneral.potencia || '',
        torque: props.nuevo.infoGeneral.torque || '',
        versiones: props.nuevo.infoGeneral.versiones || '',
        // stock: props.nuevo.infoGeneral.stock || '',
    },
    disenio: {
        titulo: props.nuevo.disenio?.titulo || '',
        encabezado: props.nuevo.disenio?.encabezado || '',
        descripcion: props.nuevo.disenio?.descripcion || '',
    },
    disenioContenido: props.nuevo.disenioContenido || [
        {
            titulo: props.nuevo.disenioContenido?.titulo || '',
            subtitulo: props.nuevo.disenioContenido?.subtitulo || '',
            descripcion: props.nuevo.disenioContenido?.descripcion || '',
            // imagen: props.nuevo.disenioContenido?.imagen || null,
        }
    ],
    // colores: props.nuevo.colores || [],
    tecnologia: {
        titulo: props.nuevo.tecnologia?.titulo || '',
        encabezado: props.nuevo.tecnologia?.encabezado || '',
        descripcion: props.nuevo.tecnologia?.descripcion || '',
    },
    tecnologiaContenido: props.nuevo.tecnologiaContenido || [
        {
            titulo: props.nuevo.tecnologiaContenido?.titulo || '',
            subtitulo: props.nuevo.tecnologiaContenido?.subtitulo || '',
            descripcion: props.nuevo.tecnologiaContenido?.descripcion || '',
            // imagen: props.nuevo.tecnologiaContenido?.imagen || null,
        }
    ],
    // galeria: props.nuevo.galeria || [],
    versiones: props.nuevo.versiones || [
        {
            nomVersion: props.nuevo.versiones?.nomVersion || '',
            // imagen: props.nuevo.versiones?.imagen || null,
            infoGen: [
                {
                    precioVersion: props.nuevo.versiones?.infoGen?.precioVersion || '',
                    rendimiento: props.nuevo.versiones?.infoGen?.rendimiento || '',
                    potencia: props.nuevo.versiones?.infoGen?.potencia || '',

                }
            ],
            caracteristicas: props.nuevo.versiones?.caracteristicas || [],
        }
    ],
});


//Manejo para cambiar la imafen del auto
const formFotoAuto = useForm({
    fotoAuto: null,
});
function onfileUploadAuto(event) {
    const file = event.target.files[0];
    formFotoAuto.fotoAuto = file;
}
const subirFotoAuto = () => {
    formFotoAuto.post(route('nuevos.cambiarFotoAuto', props.nuevo.id), {
        onSuccess: () => {
            formFotoAuto.reset();
            console.log('La imagen se ha enviado correctamente');
            window.location.href = route('nuevos.index');
        }
    });
};
function eliminarFotoAuto() {
    if (confirm('¿Estás seguro de eliminar la imagen?')) {
        formFotoAuto.delete(route('nuevos.eliminarFotoAuto', props.nuevo.id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('La imagen se ha eliminado correctamente');
                // window.location.reload();
            },
            onError: (errors) => {
                console.log(errors);
            }
        });
    }
}

// Manejo para cambiar las imagenes de galeria
const formGaleria = useForm({
    galeria: [],
});
function onfileUploadGaleria(event) {
    formGaleria.galeria.push(event.target.files[0]);
}
const subirImagenGaleria = () => {
    formGaleria.post(route('nuevos.cambiarImagenGaleria', props.nuevo.id), {
        onSuccess: () => {
            formGaleria.reset();
            console.log('La imagen se ha enviado correctamente');
            location.reload();
        }
    });
};
function eliminarImagenGaleria(index) {
    if (confirm('¿Estás seguro de eliminar la imagen de la galeria?')) {
        formGaleria.delete(route('nuevos.eliminarImagenGaleria', { id: props.nuevo.id, index: index }), {
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

//Manejo para cambiar las imagenes de los colores
const formColores = useForm({
    colores: [],
});
function onfileUploadColores(event) {
    formColores.colores.push(event.target.files[0]);
}
const subirImagenColor = () => {
    formColores.post(route('nuevos.cambiarImagenColor', props.nuevo.id), {
        onSuccess: () => {
            formColores.reset();
            console.log('La imagen se ha enviado correctamente');
            location.reload();
        }
    });
};
function eliminarImagenColor(index) {
    if (confirm('¿Estás seguro de eliminar la imagen de color?')) {
        formColores.delete(route('nuevos.eliminarImagenColor', { id: props.nuevo.id, index }), {
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

//Manejo para cambiar la imagen de desingContent
const formDisenioContenido = useForm({
    disenioContenido: props.nuevo.disenioContenido.map(content => ({
        ...content,
        imagen: null,
    })),
});
function onfileUploadDisenio(event, index) {
    const file = event.target.files[0];
    formDisenioContenido.disenioContenido[index].imagen = file;
}
function subirImagenDesingContent(index) {
    formDisenioContenido.post(route('nuevos.cambiarImagenDesingContent', { id: props.nuevo.id, index }), {
        data: { imagen: formDisenioContenido.disenioContenido[index].imagen },
        onSuccess: () => {
            formDisenioContenido.reset();
            console.log('La imagen se ha enviado correctamente');
            window.location.reload();
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
};
function eliminarImagenDesingContent(index) {
    if (confirm('¿Estás seguro de eliminar la imagen de diseño de contenido?')) {
        formDisenioContenido.delete(route('nuevos.eliminarImagenDesingContent', { id: props.nuevo.id, index }), {
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

//Manejo para cambiar la imagen de tecnologiaContenido
const formTecnologiaContenido = useForm({
    tecnologiaContenido: props.nuevo.tecnologiaContenido.map(content => ({
        ...content,
        imagen: null,
    })),
});
function onfileUploadTecnologiaContenido(event, index) {
    const file = event.target.files[0];
    formTecnologiaContenido.tecnologiaContenido[index].imagen = file;
}
function subirImagenTecnologiaContenido(index) {
    formTecnologiaContenido.post(route('nuevos.cambiarImagenTecnologiaContenido', { id: props.nuevo.id, index }), {
        data: { imagen: formTecnologiaContenido.tecnologiaContenido[index].imagen },
        onSuccess: () => {
            formTecnologiaContenido.reset();
            console.log('La imagen se ha enviado correctamente');
            window.location.reload();
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
};
function eliminarImagenTecnologiaContenido(index) {
    if (confirm('¿Estás seguro de eliminar la imagen de tecnología contenido?')) {
        formTecnologiaContenido.delete(route('nuevos.eliminarImagenTecnologiaContenido', { id: props.nuevo.id, index }), {
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

//Manejo para cambiar la imagen de la version
const formVersion = useForm({
    versiones: props.nuevo.versiones.map(version => ({
        ...version,
        imagen: null,
    })),
});
function onfileUploadVersion(event, index) {
    const file = event.target.files[0];
    formVersion.versiones[index].imagen = file;
}
function subirImagenVersion(index) {
    formVersion.post(route('nuevos.cambiarImagenVersiones', { id: props.nuevo.id, index }), {
        data: { imagen: formVersion.versiones[index].imagen },
        onSuccess: () => {
            formVersion.reset();
            console.log('La imagen se ha enviado correctamente');
            window.location.reload();
        },
        onError: (errors) => {
            console.log(errors);
        }
    });
};
function eliminarImagenVersion(index) {
    if (confirm('¿Estás seguro de eliminar la imagen de la versión?')) {
        formVersion.delete(route('nuevos.eliminarImagenVersiones', { id: props.nuevo.id, index }), {
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


// Info
// Función para agregar el diseño de contenido
function addDesingContent() {
    formNuevos.disenioContenido.push({
        titulo: '',
        subtitulo: '',
        descripcion: '',
        imagen: null,
    });
}
function removeDesingContent(index) {
    formNuevos.disenioContenido.splice(index, 1);
    formDisenioContenido.delete(route('nuevos.eliminarImagenDesingContent', { id: props.nuevo.id, index }), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('La imagen se ha eliminado correctamente');
                // window.location.reload();
            },
            onError: (errors) => {
                console.log(errors);
            }
        });
}
function addTecnologiaContenido() {
    formNuevos.tecnologiaContenido.push({
        titulo: '',
        subtitulo: '',
        descripcion: '',
        imagen: null,
    });
}
function removeTecnologiaContenido(index) {
    formNuevos.tecnologiaContenido.splice(index, 1);
    formTecnologiaContenido.delete(route('nuevos.eliminarImagenTecnologiaContenido', { id: props.nuevo.id, index }), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('La imagen se ha eliminado correctamente');
                // window.location.reload();
            },
            onError: (errors) => {
                console.log(errors);
            }
        });
}

function addVersion() {
    formNuevos.versiones.push({
        nomVersion: '',
        imagen: null,
        infoGen: [
            {
                precioVersion: '',
                rendimiento: '',
                potencia: '',

            }
        ],
        caracteristicas: [],
    });
}
function removeVersion(index) {
    formNuevos.versiones.splice(index, 1);

        formVersion.delete(route('nuevos.eliminarImagenVersiones', { id: props.nuevo.id, index }), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('La imagen se ha eliminado correctamente');
                // window.location.reload();
            },
            onError: (errors) => {
                console.log(errors);
            }
        });



}

const actualizaAuto = () => {
    formNuevos.put(route('nuevos.update', props.nuevo.id), {
        onSuccess: () => {
            formNuevos.reset();
            console.log('El formulario se ha actualizado correctamente');
            window.location.href = route('nuevos.index');
        }
    });
};


</script>

<template>

    <Head title="Inicio" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-vwtext text-xl text-gray-800 leading-tight">Editar Formulario de Autos Nuevos</h2>
        </template>

        <div class="py-12 font-vwtext">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="">
                            <form @submit.prevent="actualizaAuto" class="bg-white shadow-md rounded-lg overflow-hidden">
                                <div class="p-6 space-y-6">
                                    <!-- Informacion general -->
                                    <div class="space-y-4">
                                        <h2 class="text-xl font-semibold text-gray-800">Información general de {{ props.nuevo.modelo }} </h2>
                                        <!-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="modelo"
                                                    class="block text-sm font-medium text-gray-700">Modelo</label>
                                                <input type="text" id="modelo" v-model="formNuevos.modelo"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="eslogan"
                                                    class="block text-sm font-medium text-gray-700">Eslogan</label>
                                                <input type="text" id="eslogan" v-model="formNuevos.infoGeneral.eslogan"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label for="precio"
                                                    class="block text-sm font-medium text-gray-700">Precio</label>
                                                <input type="number" id="precio" v-model="formNuevos.infoGeneral.precio"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label for="motor"
                                                    class="block text-sm font-medium text-gray-700">Motor</label>
                                                <input type="text" id="motor" v-model="formNuevos.infoGeneral.motor"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label for="trans"
                                                    class="block text-sm font-medium text-gray-700">Transmisión</label>
                                                <input type="text" id="trans"
                                                    v-model="formNuevos.infoGeneral.transmision"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label for="pote"
                                                    class="block text-sm font-medium text-gray-700">Potencia</label>
                                                <input type="text" id="pote" v-model="formNuevos.infoGeneral.potencia"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label for="torque"
                                                    class="block text-sm font-medium text-gray-700">Torque</label>
                                                <input type="text" id="torque" v-model="formNuevos.infoGeneral.torque"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <!-- <div>
                                                <label for="stock"
                                                    class="block text-sm font-medium text-gray-700">Stock</label>
                                                <input type="number" min="1" id="torque" v-model="formNuevos.infoGeneral.stock"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div> -->
                                            <div>
                                                <label for="versiones"
                                                    class="block text-sm font-medium text-gray-700">Versiones</label>
                                                <input type="text" id="versiones"
                                                    v-model="formNuevos.infoGeneral.versiones"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Diseño -->
                                    <div class="space-y-4">
                                        <h2 class="text-xl font-semibold text-gray-800">Diseño</h2>
                                        <div class="space-y-4">
                                            <div>
                                                <label for="designHeader"
                                                    class="block text-sm font-medium text-gray-700">Encabezado</label>
                                                <input type="text" id="designHeader"
                                                    v-model="formNuevos.disenio.encabezado"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label for="designDescription"
                                                    class="block text-sm font-medium text-gray-700">Descripción</label>
                                                <textarea id="designDescription"
                                                    v-model="formNuevos.disenio.descripcion" rows="3"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Diseño Contenido -->
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center">
                                            <h2 class="text-xl font-semibold text-gray-800">Diseño contenido</h2>
                                            <button type="button" @click="addDesingContent"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Agregar contenido
                                            </button>
                                        </div>
                                        <div v-for="(content, index) in formNuevos.disenioContenido" :key="index"
                                            class="bg-gray-50 p-4 rounded-md space-y-4">
                                            <div>
                                                <label :for="'contentTitle' + index"
                                                    class="block text-sm font-medium text-gray-700">Titulo</label>
                                                <input type="text" :id="'contentTitle' + index" v-model="content.titulo"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label :for="'contentSubtitle' + index"
                                                    class="block text-sm font-medium text-gray-700">Subtitulo</label>
                                                <input type="text" :id="'contentSubtitle' + index"
                                                    v-model="content.subtitulo"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label :for="'contentDescription' + index"
                                                    class="block text-sm font-medium text-gray-700">Descripción</label>
                                                <textarea :id="'contentDescription' + index"
                                                    v-model="content.descripcion" rows="3"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                            </div>
                                            <button type="button" @click="removeDesingContent(index)"
                                                class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Eliminar
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Seguridad o tecnologia -->
                                    <div class="space-y-4">
                                        <h2 class="text-xl font-semibold text-gray-800">Seguridad-Tecnologia</h2>
                                        <div class="space-y-4">
                                            <div>
                                                <label for="designHeader"
                                                    class="block text-sm font-medium text-gray-700">Titulo</label>
                                                <input type="text" id="designTitle"
                                                    v-model="formNuevos.tecnologia.titulo"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label for="designHeader"
                                                    class="block text-sm font-medium text-gray-700">Encabezado</label>
                                                <input type="text" id="designHeader"
                                                    v-model="formNuevos.tecnologia.encabezado"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label for="designDescription"
                                                    class="block text-sm font-medium text-gray-700">Descripción</label>
                                                <textarea id="designDescription"
                                                    v-model="formNuevos.tecnologia.descripcion" rows="3"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tecnologia Contenido -->
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center">
                                            <h2 class="text-xl font-semibold text-gray-800"> Contenido de
                                                Seguridad-Tecnologia
                                            </h2>
                                            <button type="button" @click="addTecnologiaContenido"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Agregar contenido
                                            </button>
                                        </div>
                                        <div v-for="(content, index) in formNuevos.tecnologiaContenido" :key="index"
                                            class="bg-gray-50 p-4 rounded-md space-y-4">
                                            <div>
                                                <label :for="'contentTitle' + index"
                                                    class="block text-sm font-medium text-gray-700">Titulo</label>
                                                <input type="text" :id="'contentTitle' + index" v-model="content.titulo"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label :for="'contentSubtitle' + index"
                                                    class="block text-sm font-medium text-gray-700">Subtitulo</label>
                                                <input type="text" :id="'contentSubtitle' + index"
                                                    v-model="content.subtitulo"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label :for="'contentDescription' + index"
                                                    class="block text-sm font-medium text-gray-700">Descripción</label>
                                                <textarea :id="'contentDescription' + index"
                                                    v-model="content.descripcion" rows="3"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                            </div>
                                            <button type="button" @click="removeTecnologiaContenido(index)"
                                                class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Eliminar contenido
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Versiones -->
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center">
                                            <h2 class="text-xl font-semibold text-gray-800">Versiones</h2>
                                            <button type="button" @click="addVersion"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Agregar versión
                                            </button>
                                        </div>
                                        <div v-for="(version, index) in formNuevos.versiones" :key="index"
                                            class="bg-gray-50 p-4 rounded-md space-y-4">
                                            <div>
                                                <label :for="'versionName' + index"
                                                    class="block text-sm font-medium text-gray-700">Nombre
                                                    de la versión</label>
                                                <input type="text" :id="'versionName' + index"
                                                    v-model="version.nomVersion"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label :for="'versionPrice' + index"
                                                    class="block text-sm font-medium text-gray-700">Precio</label>
                                                <input type="number" :id="'versionPrice' + index"
                                                    v-model="version.infoGen[0].precioVersion"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label :for="'versionPerformance' + index"
                                                    class="block text-sm font-medium text-gray-700">Rendimiento</label>
                                                <input type="text" :id="'versionPerformance' + index"
                                                    v-model="version.infoGen[0].rendimiento"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <div>
                                                <label :for="'versionPower' + index"
                                                    class="block text-sm font-medium text-gray-700">Potencia</label>
                                                <input type="text" :id="'versionPower' + index"
                                                    v-model="version.infoGen[0].potencia"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                            <!-- <div>
                                                <label :for="'versionPower' + index"
                                                    class="block text-sm font-medium text-gray-700">En existencia</label>
                                                <input type="text" :id="'versionPower' + index"
                                                    v-model="version.infoGen[0].stock"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div> -->
                                            <!-- agregar caracteristicas -->
                                            <div class="flex justify-between items-center">
                                                <h2 class="text-xl font-semibold text-gray-800">Características</h2>
                                                <button type="button" @click="version.caracteristicas.push('')"
                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Agregar
                                                    Característica</button>
                                            </div>
                                            <div v-for="(caracteristica, carIndex) in version.caracteristicas"
                                                :key="carIndex" class="mb-4">
                                                <input type="text" :name="'caracteristica' + index + carIndex"
                                                    v-model="version.caracteristicas[carIndex]"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <button type="button"
                                                    @click="version.caracteristicas.splice(carIndex, 1)"
                                                    class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Eliminar</button>
                                            </div>
                                            <button type="button" @click="removeVersion(index)"
                                                class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Eliminar versión
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Boton de actualizar -->
                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Actualizar Información
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <!-- Form para cambiar la imagen del auto -->
                        <div class="mb-6 mt-10 border-t pt-6">
                            <p class="text-lg font-semibold text-gray-800">Foto principal del modelo</p>
                            <template v-if="props.nuevo.fotoAuto">
                                <div class="flex flex-col items-center space-y-4">
                                    <img :src="`/storage/${props.nuevo.fotoAuto}`" alt="Foto del auto"
                                        class="mt-4 w-full max-w-xs rounded-lg shadow-md object-cover h-auto">
                                    <button @click="eliminarFotoAuto"
                                        class="px-6 py-2 bg-red-500 text-white text-sm font-medium rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
                                        Eliminar Imagen
                                    </button>
                                </div>
                            </template>
                            <template v-else>
                                <form @submit.prevent="subirFotoAuto" class="space-y-6" enctype="multipart/form-data">
                                    <label for="fotoAuto" class="block text-sm font-medium text-gray-700">
                                        Foto del auto
                                    </label>
                                    <input type="file" @change="onfileUploadAuto"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-50 rounded-lg shadow-sm focus:outline-none
                                            focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <button type="submit"
                                        class="w-full sm:w-auto px-6 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                        Subir Imagen
                                    </button>
                                </form>
                            </template>
                        </div>


                        <!--Form para cambiar la imagen de Diseño contenido -->
                        <div class="mb-10 border-b pb-6">
                            <p class="pt-6 text-lg font-semibold text-gray-800">Imagen Diseño Contenido</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                                <div v-for="(imagenpromo, index) in props.nuevo.disenioContenido" :key="index"
                                    class="bg-white p-4 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                                    <template v-if="imagenpromo.imagen">
                                        <img :src="`/storage/${imagenpromo.imagen}`" alt="Imagen de promoción"
                                            class="w-full h-48 object-cover rounded-md mb-3">
                                        <div class="text-center font-medium text-gray-700 mb-3">{{ imagenpromo.titulo }}</div>
                                        <button @click.prevent="eliminarImagenDesingContent(index)"
                                            class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                            Eliminar Imagen
                                        </button>
                                    </template>
                                    <template v-else>
                                        <form @submit.prevent="subirImagenDesingContent(index)" class="space-y-4" enctype="multipart/form-data">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ imagenpromo.titulo }}</label>
                                            <input type="file" @change="event => onfileUploadDisenio(event, index)"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-50 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <button type="submit"
                                                class="w-full bg-blue-500 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out hover:bg-blue-600">
                                                Subir Imagen
                                            </button>
                                        </form>
                                    </template>
                                </div>
                            </div>
                        </div>


                        <!--Form para cambiar imagen de Colores -->
                        <div class="mb-10 border-b pb-6">
                            <p class="text-lg font-semibold text-gray-800">Imágenes de los colores</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                                <template v-if="props.nuevo.colores && props.nuevo.colores.length">
                                    <div v-for="(color, index) in props.nuevo.colores" :key="index"
                                        class="bg-white p-4 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                                        <img :src="`/storage/${color}`" alt="Color"
                                            class="w-full h-48 object-cover rounded-md mb-3">
                                        <button @click.prevent="eliminarImagenColor(index)"
                                            class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                            Eliminar Imagen
                                        </button>
                                    </div>
                                </template>
                                <template v-else>
                                    <p class="text-center text-gray-500 col-span-full">No hay imágenes en colores actualmente</p>
                                </template>
                            </div>
                            <form @submit.prevent="subirImagenColor" class="space-y-4 mt-6" enctype="multipart/form-data">
                                <label for="colores" class="block text-sm font-medium text-gray-700">
                                    Subir nueva imagen de color
                                </label>
                                <input type="file" @change="onfileUploadColores"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-50 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    accept="image/*">
                                <button type="submit"
                                    class="w-full sm:w-auto bg-blue-500 text-white font-medium py-2 px-4 rounded-md shadow-md hover:bg-blue-600 transition duration-300 ease-in-out">
                                    Subir Imagen del Color
                                </button>
                            </form>
                        </div>



                        <!-- Tecnologia Contenido -->
                        <div class="mb-10 border-b pb-6">
                            <p class="text-lg font-semibold text-gray-800">Imágenes del contenido de Tecnología-Seguridad</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                                <div v-for="(content, index) in props.nuevo.tecnologiaContenido" :key="index"
                                    class="bg-white p-4 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                                    <template v-if="content.imagen">
                                        <img :src="`/storage/${content.imagen}`" alt="Imagen de contenido"
                                            class="w-full h-48 object-cover rounded-md mb-3">
                                        <div class="text-center text-gray-700 font-medium mb-2">{{ content.titulo }}</div>
                                        <button @click.prevent="eliminarImagenTecnologiaContenido(index)"
                                            class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                            Eliminar Imagen
                                        </button>
                                    </template>
                                    <template v-else>
                                        <form @submit.prevent="subirImagenTecnologiaContenido(index)" class="space-y-4"
                                            enctype="multipart/form-data">
                                            <label for="" class="block text-sm font-medium text-gray-700 text-center">
                                                {{ content.titulo }}
                                            </label>
                                            <input type="file"
                                                @change="event => onfileUploadTecnologiaContenido(event, index)"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-50 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <button type="submit"
                                                class="w-full bg-blue-500 text-white font-medium py-2 px-4 rounded-md shadow-md hover:bg-blue-600 transition duration-300 ease-in-out">
                                                Subir Imagen
                                            </button>
                                        </form>
                                    </template>
                                </div>
                            </div>
                        </div>


                        <!-- Versiones falta-->
                        <div class="mb-10 border-b pb-6">
                            <p class="text-lg font-semibold text-gray-800">Imagen de la versión del modelo</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                                <div v-for="(version, index) in props.nuevo.versiones" :key="index"
                                    class="bg-white p-4 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                                    <template v-if="version.imagen">
                                        <div class="text-center text-gray-700 font-medium mb-2">{{ version.nomVersion }}</div>
                                        <img :src="`/storage/${version.imagen}`" alt="Imagen de versión"
                                            class="w-full h-40 object-cover rounded-md mb-3">
                                        <button @click.prevent="eliminarImagenVersion(index)"
                                            class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                            Eliminar Imagen
                                        </button>
                                    </template>
                                    <template v-else>
                                        <form @submit.prevent="subirImagenVersion(index)" class="space-y-4" enctype="multipart/form-data">
                                            <label for="versiones" class="block text-sm font-medium text-gray-700 text-center">
                                                {{ version.nomVersion }}
                                            </label>
                                            <input type="file" @change="event => onfileUploadVersion(event, index)"
                                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-50 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <button type="submit"
                                                class="w-full bg-blue-500 text-white font-medium py-2 px-4 rounded-md shadow-md hover:bg-blue-600 transition duration-300 ease-in-out">
                                                Subir Imagen a la versión
                                            </button>
                                        </form>
                                    </template>
                                </div>
                            </div>
                        </div>







                        <!-- Form para cambiar imagenes del carrusel galeria -->
                        <div class="mb-10 border-b pb-6">
                            <p class="text-lg font-semibold text-gray-800">Galería</p>
                            <template v-if="props.nuevo.galeria && props.nuevo.galeria.length">
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                                    <div v-for="(galeria, index) in props.nuevo.galeria" :key="index"
                                        class="bg-white p-4 rounded-lg shadow-md transition duration-300 ease-in-out hover:shadow-xl">
                                        <img :src="`/storage/${galeria}`" alt="Imagen de galería"
                                            class="w-full h-48 object-cover rounded-md mb-3">
                                        <button @click.prevent="eliminarImagenGaleria(index)"
                                            class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md transition duration-300 ease-in-out">
                                            Eliminar Imagen
                                        </button>
                                    </div>
                                </div>
                            </template>
                            <template v-else>
                                <p class="text-gray-500 text-center mt-4">No hay imágenes en la galería actualmente</p>
                            </template>
                            <form @submit.prevent="subirImagenGaleria" class="space-y-4 mt-6" enctype="multipart/form-data">
                                <label for="galeria" class="block text-sm font-medium text-gray-700">
                                    Subir nueva imagen a la galería
                                </label>
                                <input type="file" @change="onfileUploadGaleria"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-50 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    accept="image/*">
                                <button type="submit"
                                    class="w-full sm:w-auto bg-blue-500 text-white font-medium py-2 px-4 rounded-md shadow-md hover:bg-blue-600 transition duration-300 ease-in-out">
                                    Subir Imagen
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
