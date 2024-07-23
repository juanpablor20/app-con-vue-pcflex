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
    services: Object,
});

const showModalDel = ref(false);
const userToDelete = ref(null);


const openModalDel = (user) => {
    showModalDel.value = true;
    userToDelete.value = user;
};

const closeModalDel = () => {
    console.log('Cerrando modal');
    showModalDel.value = false;
    userToDelete.value = null;
};




</script>

<template>
    <Head title="Historial" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Historial</h2>
                <NavLink :href="route('dashboard')">
                    <SecondaryButton>
                        
                        Volver
                    </SecondaryButton>
                </NavLink>
            </div>
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">
           

            <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                                <th class="px-4 py-3">Fecha de Prestamo</th>
                                <th class="px-4 py-3">Facha de Devolucion</th>
                                <th class="px-4 py-3">Número De serie de Equipo</th>
                                <th class="px-4 py-3">Numero de Documento del  solicitante</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            <tr v-for="service in services.data" :key="service.id" class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ service.date_ser }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ service.return_ser }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ service.equipment.serie_equi }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ service.users.number_identification }}
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    <span :class="{'text-green-500': service.status === 'devuelto', 'text-red-500': service.status === 'pendiente'}">
                                        {{ service.status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <NavLink :href="route('info.details', service.id)">
                                        <ShowButton>Info</ShowButton>
                                    </NavLink>
                                </td>
                              
                              
                               
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                    <Pagination :links="services.links" />
                </div>
            </div>
        </div>
        
    </AuthenticatedLayout>
</template>
