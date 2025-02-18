<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed } from "vue";
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
import SearchHistorico from '@/Components/SearchHistorico.vue';

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

const downloadPdf = () => {
    window.location.href = route('pdfhistorico');
};

const searchTerm = ref("");
const filteredservices = computed(() => {
  if (!searchTerm.value) {
    return props.services.data;
  }
  const lowerCaseSearchTerm = searchTerm.value.toLowerCase();
  return props.services.data.filter((service) => {
    return (
      service.equipment.serie_equi.toLowerCase().includes(lowerCaseSearchTerm) ||
      service.users.number_identification.toLowerCase().includes(lowerCaseSearchTerm) 
    );
  });
});
</script>

<template>
    <Head title="Historial" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <button
                    @click="downloadPdf"
                    class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    <i class="fas fa-file-pdf mr-2"></i> <!-- Icono de PDF -->
                    PDF
                </button>
                <div class="flex items-center space-x-2">
                    <SearchHistorico
                        v-model:search="searchTerm"
                        @search="handleSearch"
                        class="ml-auto"
                    />
                </div>
            </div>
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
                            <tr v-for="service in filteredservices" :key="service.id" class="text-gray-700">
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