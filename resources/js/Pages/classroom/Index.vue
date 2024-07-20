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
    names: '',
   
});

const v = ref({ id: '',  names: '' });

const title = ref('');
const operation = ref(1);
const msj = ref('');
const classMsj = ref('hidden');

const openModalvue = (indexCard) => {
    showModalvue.value = true;
    v.value = { ...environments };
};

const openModalForm = (op, environments) => {
    showModalForm.value = true;
    operation.value = op;
    if (op === 1) {
        title.value = 'Crear Ficha';
        form.reset();
    } else {
        title.value = 'Editar Ficha';
        v.value = { ...environments };
        form.names = environments.names;
    }
};

const openModalDel = (environments) => {
    showModalDel.value = true;
    v.value = { ...environments };
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
    environments: {
        type: Object,
        required: true
    },
    programs: Array
});

const save = () => {
    if (operation.value === 1) {
        form.post(route('environments.store'), {
            onSuccess: () => { ok('Ambiente Creada con éxito') }
        });
    } else {
        form.put(route('environments.update', v.value.id), {
            onSuccess: () => { ok('Ambiente Editada con éxito') }
        });
    }
};

const ok = (m) => {
    closeModalForm();
    closeModaldel();
    form.reset();
    msj.value = m;
    classMsj.value = 'Ambiente'; 
    setTimeout(() => {
        classMsj.value = 'hidden';
    }, 8000);
};

const deleteprogram = () => {
    form.delete(route('environments.destroy', v.value.id), {
        onSuccess: () => { ok('Ambiente inactivado con éxito') }
    });
};

const activateProgram = (indexCard) => {
    form.put(route('environments.activate', indexCard.id), {
        onSuccess: () => { ok('Ambiente activado con éxito') }
    });
};
</script>

<template>
    <Head title="Programas" />
    <AuthenticatedLayout>
        <template #header>
            Ficha 
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
                                <th class="px-4 py-3">Ambientes</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            <tr v-for="environments in environments.data" :key="environments.id" class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ environments.names }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span :class="{'text-red-500': environments.status === 'inactivo', 'text-green-500': environments.status === 'activo'}">
                                        {{ environments.status }}
                                    </span>
                                </td>
                               
                                <td class="px-4 py-3 text-sm">
                                    <template v-if="environments.status === 'activo'">
                                        <WarningButton @click="openModalForm(2, environments)">Editar</WarningButton>
                                        <DangerButton @click="openModalDel(environments)">Inactivar</DangerButton>
                                    </template>
                                    <template v-else>
                                        <GreenButton @click="activateProgram(environments)">Reactivar</GreenButton>
                                    </template>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                    <Pagination :links="environments.links" />
                </div>
            </div>
        </div>

        <!-- Modal para el formulario -->
        <Modal :show="showModalForm" @close="closeModalForm">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
                <InputLabel for="number" value="Número de Ficha" />
                <TextInput v-model="form.names" required />
                <InputError class="mt-1" :message="form.errors.names" />

                
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
                Tenga en cuenta que esta informacion no se Eliminara,
                solo se cambia el estado a Inactivo..
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModaldel">Cancelar</SecondaryButton>
                <DangerButton @click="deleteprogram">Sí, seguro</DangerButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
