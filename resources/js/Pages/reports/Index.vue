<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import NavLink from "@/Components/NavLink.vue";
import CreateButton from "@/Components/CreateButton.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import EditButton from "@/Components/EditButton.vue";
import ShowButton from "@/Components/ShowButton.vue";
import GreenButton from '@/Components/GreenButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    repors: Object,
});

const v = ref({ id: '' });
const showModalDel = ref(false);

const form = useForm({
    names: '',
});

const openModalDel = (repor) => {
    showModalDel.value = true;
    v.value = { ...repor };
};

const closeModalDel = () => {
    showModalDel.value = false;
};

const deleteReport = () => {
    form.delete(route('repors.destroy', v.value.id), {
        onSuccess: () => {
            closeModalDel();
            showSuccessAlert("Reporte Inactivado con éxito");
        },
        onError: (errors) => {
            closeModalDel();
            showErrorAlert(errors.error);
        }
    });
};

const activateRepor = (repor) => {
    form.put(route('repors.activate', repor.id), {
        onSuccess: () => {
            showSuccessAlert("Reporte Activado con éxito");
        },
        onError: (errors) => {
            showErrorAlert(errors.error);
        }
    });
};

const showSuccessAlert = (message) => {
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
</script>

<template>
    <Head title="Reportes" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reportes</h2>
                <NavLink :href="route('Repors.crear')">
                    <CreateButton>
                        <i class="fas fa-plus mr-1"></i>
                        Crear
                    </CreateButton>
                </NavLink>
            </div>
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">
            <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                                <th class="px-4 py-3">Descripción</th>
                                <th class="px-4 py-3">Fecha Inicio</th>
                                <th class="px-4 py-3">Fecha Fin</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            <tr v-for="repor in repors.data" :key="repor.id" class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ repor.description }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ repor.punishment_date }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ repor.end_date }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ repor.status }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <!-- Mostrar botón de Inactivar o Reactivar según el estado -->
                                    <template v-if="repor.status === 'activo'">
                                        <DeleteButton @click="openModalDel(repor)">Inactivar</DeleteButton>
                                    </template>
                                    <template v-else>
                                        <GreenButton @click="activateRepor(repor)">Reactivar</GreenButton>
                                    </template>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                    <Pagination :links="repors.links" />
                </div>
            </div>
        </div>

       <Modal :show="showModalDel" @close="closeModalDel">
    <div class="p-6 bg-white rounded-lg shadow-lg">
        <!-- Encabezado del modal con icono -->
        <div class="flex items-center space-x-3 mb-4">
            <i class="fas fa-exclamation-circle text-2xl text-yellow-500"></i> <!-- Icono de advertencia -->
            <h1 class="text-lg font-semibold text-gray-800">¿Estás seguro de realizar esta acción?</h1>
        </div>

        <!-- Mensaje del modal -->
        <p class="text-gray-600 mb-6">
            Esta acción no se puede deshacer. ¿Deseas continuar?
        </p>

        <!-- Botones de acción -->
        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
            <SecondaryButton @click="closeModalDel" class="w-full sm:w-auto">
                <i class="fas fa-times mr-2"></i> <!-- Icono de cancelar -->
                Cancelar
            </SecondaryButton>
            <DangerButton @click="deleteReport" class="w-full sm:w-auto">
                <i class="fas fa-check mr-2"></i> <!-- Icono de confirmar -->
                Sí, seguro
            </DangerButton>
        </div>
    </div>
</Modal>
    </AuthenticatedLayout>
</template>  