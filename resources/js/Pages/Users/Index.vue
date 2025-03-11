<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Head, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import NavLink from "@/Components/NavLink.vue";
import CreateButton from "@/Components/CreateButton.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import EditButton from "@/Components/EditButton.vue";
import ShowButton from "@/Components/ShowButton.vue";
import ReactivateButton from "@/Components/ReactivateButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";

const props = defineProps({
    users: Object,
});

const showModalDel = ref(false);
const userToDelete = ref(null);
const form = useForm({
    name: "",
    last_name: "",
    type_identification: "",
    number_identification: "",
    sexo: "",
    telefono: "",
    direccion: "",
    email: "",
    errors: {},
});

// Observar los mensajes flash
const page = usePage();
watch(
    () => page.props.flash,
    (newFlash) => {
        if (newFlash.success) {
            showSuccessAlert(newFlash.success);
        }
        if (newFlash.error) {
            showErrorAlert(newFlash.error);
        }
    },
    { deep: true }
);

const openModalDel = (user) => {
    showModalDel.value = true;
    userToDelete.value = user;
};

const closeModalDel = () => {
    console.log("Cerrando modal");
    showModalDel.value = false;
    userToDelete.value = null;
};

const deleteUser = () => {
    console.log("Intentando eliminar usuario:", userToDelete.value);
    form.delete(route("users.destroy", userToDelete.value.id), {
        onSuccess: () => {
            closeModalDel();
        },
        onError: (errors) => {
            console.error("Error al eliminar usuario:", errors);
        },
    });
};

const showSuccessAlert = (message) => {
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: message,
        showConfirmButton: false,
        timer: 1500,
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
</script>

<template>
    <Head title="Usuarios" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Usuarios
                </h2>
                <NavLink :href="route('users.create')">
                    <CreateButton>
                        <i class="fas fa-plus mr-1"></i>
                        Crear
                    </CreateButton>
                </NavLink>
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
                                <th class="px-4 py-3">Nombre</th>
                                <th class="px-4 py-3">Apellido</th>
                                <th class="px-4 py-3">
                                    Número de Identificación
                                </th>
                                <th class="px-4 py-3">Sexo</th>
                                <th class="px-4 py-3">telefono</th>
                                <th class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            <tr
                                v-for="user in users.data"
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
                                    {{ user.sexo }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ user.telefono }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex space-x-2">
                                        <NavLink
                                            :href="route('users.show', user.id)"
                                        >
                                            <ShowButton>Info</ShowButton>
                                        </NavLink>
                                        <NavLink
                                            :href="route('users.edit', user.id)"
                                        >
                                            <EditButton>Editar</EditButton>
                                        </NavLink>
                                        <DeleteButton
                                            @click="openModalDel(user)"
                                            >Eliminar</DeleteButton
                                        >
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
            <!-- Contenedor principal del modal -->
            <div
                class="bg-white rounded-lg shadow-xl overflow-hidden w-full max-w-md mx-auto"
            >
                <!-- Icono de advertencia -->
                <div class="flex justify-center p-6 bg-red-50">
                    <i
                        class="fas fa-exclamation-triangle text-6xl text-red-600"
                    ></i>
                </div>

                <!-- Contenido del modal -->
                <div class="p-6">
                    <h1 class="text-xl font-bold text-gray-800 mb-2">
                        ¿Estás seguro de realizar esta acción?
                    </h1>
                    <p class="text-gray-600">
                        Esta acción no se puede deshacer.
                    </p>
                </div>

                <!-- Botones de acción -->
                <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-4">
                    <SecondaryButton
                        @click="closeModalDel"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Cancelar
                    </SecondaryButton>
                    <DangerButton
                        @click="deleteUser"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                    >
                        Sí, seguro
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
