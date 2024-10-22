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
import GreenButton from '@/Components/GreenButton.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import EditButton from '@/Components/EditButton.vue';
import CreateButton from '@/Components/CreateButton.vue';

const showModalvue = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);

const form = useForm({
    names_pro: '',
    code_pro: '',
    version: '',
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
        title.value = 'Crear Ficha';
        form.reset();
    } else {
        title.value = 'Editar Ficha';
        v.value = { ...program };
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
    },
    programs: Array
});

const showSuccessAlert = (message) => {
    closeModalForm();
	Swal.fire({
	  position: 'top-end',
	  icon: 'success',
	  title: message,
	  showConfirmButton: false,
	  timer: 8000,
	  toast: true,
	});
  };
  const showErrorAlert = (message) => {
	Swal.fire({
	  icon: 'error',
	  title: 'Oops...',
	  text: message,
	});
  };

const save = () => {
    if (operation.value === 1) {
        form.post(route('programs.store'), {
            onSuccess: () => {
                showSuccessAlert("Programa creado con éxito");
            },
            onError: (errors) => {
        showErrorAlert(errors.error);
        }
        });
    } else {
        form.put(route('programs.update', v.value.id), {
            onSuccess: () => {
                showSuccessAlert("Programa Editado con éxito");
            },
            onError: (errors) => {
        showErrorAlert(errors.error);
            }
        });
    }
};

const deleteprogram = () => {
    form.delete(route('programs.destroy', v.value.id), {
        onSuccess: () => {
            showSuccessAlert("Programa Editado con éxito");
        },
        onError: (errors) => {
        showErrorAlert(errors.error);
            }
    });
};

const activateProgram = (program) => {
    form.put(route('programs.activate', program.id), {
        onSuccess: () => {
            showSuccessAlert("Programa Activado con éxito");
        },
        onError: (errors) => {
        showErrorAlert(errors.error);
            }
    });
};

</script>

<template>
    <Head title="Programas" />
    <AuthenticatedLayout>
        <template #header>
            Programas 
            <div class="flex justify-between items-center">
                <div class="flex gap-x-4">
                
                 <CreateButton @click="openModalForm(1)">
                     <i class="fas fa-plus mr-1"></i>
                     Crear
                 </CreateButton>
                </div>
 
             </div>
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
                                <th class="px-4 py-3">Nombre del programa</th>
                                <th class="px-4 py-3">Código</th>
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
                                <td class="px-4 py-3 text-sm">
                                    <span :class="{'text-red-500': program.status === 'inactivo', 'text-green-500': program.status === 'activo'}">
                                        {{ program.status }}
                                    </span>
                                </td>
                                <td class="flex  gap-x-2">
                                    <template v-if="program.status === 'activo'">
                                        <EditButton @click="openModalForm(2, program)">Editar</EditButton>
                                        <DangerButton @click="openModalDel(program)">Inactivar</DangerButton>
                                    </template>
                                    <template v-else>
                                        <GreenButton @click="activateProgram(program)">Reactivar</GreenButton>
                                    </template>
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

        <!-- Modal para el formulario -->
        <Modal :show="showModalForm" @close="closeModalForm">
            <div class="p-6 space-y-4">
                <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
                <InputLabel for="names_pro" value="Nombre del Programa" />
                <TextInput v-model="form.names_pro" required />
                <InputError class="mt-1" :message="form.errors.names_pro" />

                <InputLabel for="code_pro" value="Código del Programa" />
                <TextInput v-model="form.code_pro" required />
                <InputError class="mt-1" :message="form.errors.code_pro" />

                <InputLabel for="version" value="Versión" />
                <TextInput v-model="form.version" required />
                <InputError class="mt-1" :message="form.errors.version" />
                <div class="flex justify-end gap-x-2">
                    <SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
                    <CreateButton @click="save">Guardar</CreateButton>
                </div>
            </div>

            
        </Modal>

        <!-- Modal para eliminación -->
        <Modal :show="showModalDel" @close="closeModaldel">
            <div class="p-6">
                <h1>¿Estás seguro de realizar esta acción?</h1>
                Tenga en cuenta que esta información no se eliminará, solo se cambia el estado a Inactivo.
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModaldel">Cancelar</SecondaryButton>
                <DangerButton @click="deleteprogram">Sí, seguro</DangerButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<style>
/* Personalizar el tamaño y posición de las alertas */
.swal2-popup-small {
    width: 300px !important; /* Ajusta el tamaño aquí */
}

.swal2-container-right {
    right: 10px !important; /* Ajusta la posición aquí */
    top: 10px !important;
}
</style>
