<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from "vue";
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import WarningButton from '@/Components/WarningButton.vue';
import GreenButton from '@/Components/GreenButton.vue';
import { useForm } from '@inertiajs/vue3';

const showModalvue = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);

const form = useForm({
    names_pro: '',
    code_pro: '',
    version: ''
});
const v = ref({ id: '', names_pro: '', code_pro: '', version: '' });

const title = ref('');
const operation = ref(1);
const msj = ref('');
const classMsj = ref('hidden');

const openModalvue = (program) => {
    showModalvue.value = true;
    v.value = { ...program };
};

const openModalForm = (op, program) => {
    showModalForm.value = true;
    operation.value = op;
    if (op === 1) {
        title.value = 'Crear Programa';
        form.reset();
    } else {
        title.value = 'Editar Programa';
        form.names_pro = program.names_pro;
        form.code_pro = program.code_pro;
        form.version = program.version;
    }
};

const openModalDel = (program) => {
    showModalDel.value = true;
    v.value = { ...program };
};

const closeModalvue = () => {
    showModalvue.value = false;
};

const closeModalForm = () => {
    showModalForm.value = false;
    form.reset();
};

const closeModaldel = () => {
    showModalDel.value = false;
};

const props = defineProps({
    programs: {
        type: Object,
        required: true
    }
});

const save = () => {
    if (operation.value === 1) {
        form.post(route('programs.store'), {
            onSuccess: () => { ok('Programa Creado con éxito') }
        });
    } else {
        form.put(route('programs.update', v.value.id), {
            onSuccess: () => { ok('Programa Editado con éxito') }
        });
    }
};

const ok = (m) => {
    closeModalForm();
    closeModaldel();
    form.reset();
    msj.value = m;
    classMsj.value = 'programa'; 
    setTimeout(() => {
        classMsj.value = 'hidden';
    }, 8000);
};

const deleteprogram = () => {
    form.delete(route('programs.destroy', v.value.id), {
        onSuccess: () => { ok('Programa inactivado con éxito') }
    });
};

const activateProgram = (program) => {

    form.put(route('programs.activate', program.id), {
        onSuccess: () => { ok('Programa activado con éxito') }
    });
};

</script>

<template>
    <Head title="Programas" />
    <AuthenticatedLayout>
        <template #header>
            
            Programas
            <GreenButton @click="openModalForm(1)">Crear</GreenButton>
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">
            <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
                <div class="flex justify-center items-center w-12 bg-blue-500">
                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path>
                    </svg>
                </div>
                <div class="px-4 py-2 -mx-3">
                    <div class="mx-3">
                        <span class="font-semibold text-blue-500">Success</span>
                        <p class="text-sm text-gray-600">{{ msj }}</p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                                <th class="px-4 py-3">Nombre del Programa</th>
                                <th class="px-4 py-3">Código del Programa</th>
                                <th class="px-4 py-3">Versión</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Acciones</th>
                                
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            <tr v-for="program in programs.data" :key="program.id" class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ program.names_pro }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ program.code_pro }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ program.version }}
                                </td>
                                <th class="px-4 py-3 text-sm">
                                    <span :class="{'text-red-500': program.status === 'inactivo', 'text-green-500': program.status === 'activo'}">
                                        {{ program.status }}
                                    </span>
                                </th>
                                <td class="px-4 py-3 text-sm" v-if="program.status === 'activo'">
                                    <WarningButton @click="openModalForm(2, program)">Editar</WarningButton>
                                </td>
                                <td class="px-4 py-3 text-sm" v-if="program.status === 'activo'">
                                    <DangerButton @click="openModalDel(program)">Inactivar</DangerButton>
                                </td>
                                <td class="px-4 py-3 text-sm" v-if="program.status === 'inactivo'">
                                    <GreenButton @click="activateProgram(program)">Reactivar</GreenButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                    <Pagination :links="programs.links" />
                </div>
            </div>
        </div>

        <!-- Modal para ver -->
        <Modal :show="showModalvue" @close="closeModalvue">
            <div class="p-6">
                <p>Nombre del programa: <span class="text-lg font-medium text-gray-900">{{ v.names_pro }}</span></p>
                <p>Código del programa: <span class="text-lg font-medium text-gray-900">{{ v.code_pro }}</span></p>
                <p>Versión: <span class="text-lg font-medium text-gray-900">{{ v.version }}</span></p>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModalvue">Cancelar</SecondaryButton>
            </div>
        </Modal>

        <!-- Modal para el formulario -->
        <Modal :show="showModalForm" @close="closeModalForm">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
                <InputLabel for="names_pro" value="Nombre del Programa" />
                <TextInput v-model="form.names_pro" required />
                <InputError class="mt-1" :message="form.errors.names_pro" />
            </div>
            <div class="p-6">
                <InputLabel for="code_pro" value="Código del Programa" />
                <TextInput v-model="form.code_pro" required />
                <InputError class="mt-1" :message="form.errors.code_pro" />
            </div>
            <div class="p-6">
                <InputLabel for="version" value="Versión" />
                <TextInput v-model="form.version" required />
                <InputError class="mt-1" :message="form.errors.version" />
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
                <PrimaryButton @click="save">Guardar</PrimaryButton>
            </div>
        </Modal>

        <!-- Modal para eliminación -->
        <Modal :show="showModalDel" @close="closeModaldel">
            <div class="p-6">
                <h1>¿Estás seguro de realizar esta acción?</h1>
                <!-- Contenido de confirmación de eliminación -->
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModaldel">Cancelar</SecondaryButton>
                <DangerButton @click="deleteprogram">Sí, seguro</DangerButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
