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
import ReactivateButton from "@/Components/ReactivateButton.vue";
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    repors: Object,
});

const showModalDel = ref(false);
const userToDelete = ref(null);
const form = useForm({
    names: '',
   
});

const openModalDel = (user) => {
    showModalDel.value = true;
    userToDelete.value = user;
};

const closeModalDel = () => {
    console.log('Cerrando modal');
    showModalDel.value = false;
    userToDelete.value = null;
};

const deleteUser = () => {
    console.log('Intentando eliminar usuario:', userToDelete.value);
    form.delete(route('Borrower_users.destroy', userToDelete.value.id), {
        onSuccess: () => {
            console.log('Usuario eliminado con éxito');
            closeModalDel();
        },
        onError: (errors) => {
            console.error('Error al eliminar usuario:', errors);
        }
    });
};

const activateUser = (user) => {
    form.put(route('Borrower_users.activate', user.id), {
        onSuccess: () => { 
            alert('Usuario activado con éxito'); 
        },
        onError: (errors) => {
            console.error('Error al activar usuario:', errors);
        }
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
            <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md">
                <div class="flex justify-center items-center w-12 bg-blue-500">
                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z">
                        </path>
                    </svg>
                </div>

               
            </div>

            <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
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
            <div class="p-6">
                <h1 class="text-lg font-semibold">¿Estás seguro de realizar esta acción?</h1>
                <p>Esta acción no se puede deshacer.</p>
            </div>
            <div class="mt-6 flex justify-end space-x-4">
                <SecondaryButton @click="closeModalDel">Cancelar</SecondaryButton>
                <DangerButton @click="deleteUser">Sí, seguro</DangerButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
