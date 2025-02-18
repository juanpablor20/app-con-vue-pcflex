<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Head, usePage } from "@inertiajs/vue3";

import { ref, computed, onMounted } from "vue";
import NavLink from "@/Components/NavLink.vue";
import CreateButton from "@/Components/CreateButton.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import EditButton from "@/Components/EditButton.vue";
import ShowButton from "@/Components/ShowButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

import { useForm } from "@inertiajs/vue3";
import SearchUser from "@/Components/SearchUser.vue";
import GreenButton from "@/Components/GreenButton.vue";

const props = defineProps({
    success: String,
    users: Object,
});

const page = usePage();

const successMessage = computed(() => page.props.flash.success);

onMounted(() => {
    if (successMessage.value) {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: successMessage.value,
            showConfirmButton: false,
            timer: 7000,
            toast: true,
        });
    }
});

const searchTerm = ref("");
const filteredUsers = computed(() => {
    if (!searchTerm.value) {
        return props.users.data;
    }
    return props.users.data.filter((user) => {
        return (
            user.name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
            user.last_name
                .toLowerCase()
                .includes(searchTerm.value.toLowerCase()) ||
            user.number_identification.includes(searchTerm.value)
        );
    });
});

const showModalDel = ref(false);
const userToDelete = ref(null);
const form = useForm({
    names: "",
    last_name: "",
    type_identification: "",
    number_identification: "",
});

const openModalDel = (user) => {
    showModalDel.value = true;
    userToDelete.value = user;
};

const closeModalDel = () => {
    showModalDel.value = false;
    userToDelete.value = null;
};

const deleteUser = async () => {
    try {
        await form.delete(
            route("Borrower_users.destroy", userToDelete.value.id)
        );
        showSuccessAlert("Usuario inactivado con éxito");
        closeModalDel();
    } catch (errors) {
        console.error("Error al inactivar usuario:", errors);
    }
};

const activateUser = async (user) => {
    try {
        await form.put(route("Borrower_users.activate", user.id));
        showSuccessAlert("Usuario activado con éxito");
    } catch (errors) {
        console.error("Error al activar usuario:", errors);
    }
};

const showSuccessAlert = (message) => {
    closeModalDel();
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: message,
        showConfirmButton: false,
        timer: 8000,
        toast: true,
    });
};

const showErrorAlert = (message) => {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: message,
    });
};

const downloadPdf = () => {
    window.location.href = route("pdfUsuarios");
};
</script>
<template>
    <Head title="Usuarios" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
            <i class="fas fa-users  text-indigo-600 mr-2"></i>
                Usuarios
            </h2>

            <div class="flex justify-between items-center">
                <div class="flex gap-x-4">
                    <button
                        @click="downloadPdf"
                        class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        <i class="fa fa-file" aria-hidden="true"></i>
                        PDF
                    </button>
                    <NavLink :href="route('Borrower_users.create')">
                        <CreateButton>
                            <i class="fas fa-plus mr-1"></i>
                            Crear
                        </CreateButton>
                    </NavLink>
                </div>
                <SearchUser
                    v-model:search="searchTerm"
                    @search="handleSearch"
                    class="ml-auto"
                />
            </div>
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">
            <div
                class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs"
            >
                <div class="overflow-x-auto w-full">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b"
                            >
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Apellido</th>
                                <th class="px-4 py-3">
                                    Número de Identificación
                                </th>
                                <th class="px-4 py-3">Sexo</th>
                                <th class="px-4 py-3">Roll</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="user in filteredUsers"
                                :key="user.id"
                                class="text-gray-700"
                            >
                                <td class="px-4 py-3 text-sm">
                                    {{ user.name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ user.last_name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ user.number_identification }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ user.sex_user }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ user.roll }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <span
                                        :class="{
                                            'text-green-500':
                                                user.status === 'activo',
                                            'text-red-500':
                                                user.status === 'inactivo',
                                                'text-red-600':
                                                 user.status === 'conEquipo',
                                        }"
                                    >
                                        {{ user.status }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    <!-- Si el estado es "activo", muestra todos los botones -->
                                    <div
                                        v-if="user.status === 'activo'"
                                        class="flex space-x-2"
                                    >
                                        <NavLink
                                            :href="
                                                route(
                                                    'Borrower_users.show',
                                                    user.id
                                                )
                                            "
                                        >
                                            <ShowButton>Info</ShowButton>
                                        </NavLink>
                                        <NavLink
                                            :href="
                                                route(
                                                    'Borrower_users.edit',
                                                    user.id
                                                )
                                            "
                                        >
                                            <EditButton>Editar</EditButton>
                                        </NavLink>
                                        <DeleteButton
                                            @click="openModalDel(user)"
                                            >Inactivar</DeleteButton
                                        >
                                    </div>

                                    <!-- Si el estado es "conEquipo", solo muestra el botón de Info -->
                                    <div
                                        v-else-if="user.status === 'conEquipo'"
                                        class="flex space-x-2"
                                    >
                                        <NavLink
                                            :href="
                                                route(
                                                    'Borrower_users.show',
                                                    user.id
                                                )
                                            "
                                        >
                                            <ShowButton>Info</ShowButton>
                                        </NavLink>
                                    </div>

                                    <!-- Si el estado es "inactivo", solo muestra el botón de Reactivar -->
                                    <div
                                        v-else-if="user.status === 'inactivo'"
                                        class="flex space-x-2"
                                    >
                                        <GreenButton @click="activateUser(user)"
                                            >Reactivar</GreenButton
                                        >
                                    </div>

                                    <!-- Opcional: Manejo de estados no esperados -->
                                    <div v-else class="text-gray-500">
                                        Estado no reconocido
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9"
                >
                    <Pagination :links="users.links" />
                </div>
            </div>
        </div>
        <Modal :show="showModalDel" @close="closeModalDel">
            <div class="p-6 text-center">
                <!-- Icono de advertencia -->
                <div class="flex justify-center mb-4">
                    <i
                        class="fas fa-exclamation-triangle text-4xl text-red-600"
                    ></i>
                </div>

                <!-- Título del modal -->
                <h1 class="text-lg font-semibold mb-2">
                    ¿Estás seguro de realizar esta acción?
                </h1>

                <!-- Mensaje de advertencia -->
                <p class="text-gray-600 mb-6">
                    Esta acción no se puede deshacer.
                </p>

                <!-- Botones de acción -->
                <div class="flex justify-end space-x-4">
                    <SecondaryButton @click="closeModalDel">
                        Cancelar
                    </SecondaryButton>

                    <DangerButton @click="deleteUser">
                        Sí, seguro
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
