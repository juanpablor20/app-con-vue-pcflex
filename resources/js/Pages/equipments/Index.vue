<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed } from "vue"; // Importar 'computed' de Vue
import DangerButton from "@/Components/DangerButton.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import GreenButton from "@/Components/GreenButton.vue";
import EditButton from "@/Components/EditButton.vue";
import CreateButton from "@/Components/CreateButton.vue";
import { useForm } from "@inertiajs/vue3";
import ShowButton from "@/Components/ShowButton.vue";

const showModalvue = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);
const showModalrepa = ref(false);

// Configuración del formulario
const form = useForm({
    type_equi: "",
    characteristics: "",
    serie_equi: "",
});

// Información de equipo seleccionada
const v = ref({ id: "", type_equi: "", characteristics: "", serie_equi: "" });
const title = ref("");
const operation = ref(1);
const msj = ref("");
const classMsj = ref("hidden");
const searchTerm = ref("");

// Propiedades pasadas desde el componente padre
const props = defineProps({
    equipments: {
        type: Object,
        required: true,
    },
});

// Filtrar equipos en base al término de búsqueda
const filteredEquipments = computed(() => {
    return props.equipments.data.filter(equipment => 
        equipment.serie_equi.includes(searchTerm.value)
    );
});

// Métodos para abrir y cerrar modales
const openModalForm = (op, equipment) => {
    showModalForm.value = true;
    operation.value = op;
    if (op === 1) {
        title.value = "Crear Equipo";
        form.reset();
    } else {
        title.value = "Editar Equipo";
        v.value = { ...equipment };
        form.type_equi = equipment.type_equi;
        form.characteristics = equipment.characteristics;
        form.serie_equi = equipment.serie_equi;
    }
};

const closeModalForm = () => {
    showModalForm.value = false;
    form.reset();
};

// Guardar equipo (crear o editar)
const save = () => {
    const action = operation.value === 1 ? form.post : form.put;
    action(route("equipments.store"), {
        data: operation.value === 1 ? form : { ...form, id: v.value.id },
        onSuccess: () => ok(`${operation.value === 1 ? 'Equipo creado' : 'Equipo editado'} con éxito`),
    });
};

// Mostrar mensaje de éxito
const ok = (message) => {
    closeModalForm();
    msj.value = message;
    classMsj.value = "";
    setTimeout(() => {
        classMsj.value = "hidden";
    }, 8000);
};

// Eliminar equipo
const deleteprogram = () => {
    form.delete(route("equipments.destroy", v.value.id), {
        onSuccess: () => ok("Equipo inactivado con éxito"),
    });
};

// Enviar a reparación
const reparationEquipment = (equipments) => {
    form.put(route("equipments.reparation", equipments.id), {
        onSuccess: () => ok("Equipo enviado a reparación"),
    });
};

// Activar equipo
const activateProgram = (equipments) => {
    form.put(route("equipments.activate", equipments.id), {
        onSuccess: () => ok("Equipo activado con éxito"),
    });
};

// Descargar PDF
const downloadPdf = () => {
    window.location.href = route('pdfequipos');
};
</script>

<template>
    <Head title="Equipos" />
    <AuthenticatedLayout>
        <template #header>
            Equipos
            <div class="flex justify-between items-center">
                <button @click="downloadPdf" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fa fa-file" aria-hidden="true"></i>
                    PDF
                </button>
                <CreateButton @click="openModalForm(1)">
                    <i class="fas fa-plus mr-1"></i>
                    Crear
                </CreateButton>
                <TextInput
                    v-model="searchTerm"
                    placeholder="Buscar por número de Serie"
                    class="border border-gray-300 rounded-md px-4 py-2"
                />
            </div>
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">
            <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md" :class="classMsj">
                <div class="flex justify-center items-center w-12 bg-blue-500">
                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z" />
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
                                <th class="px-4 py-3">Tipo de Equipo</th>
                                <th class="px-4 py-3">Características</th>
                                <th class="px-4 py-3">Número de Serie</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y">
                            <tr v-for="equipment in filteredEquipments" :key="equipment.id" class="text-gray-700">
                                <td class="px-4 py-3 text-sm">{{ equipment.type_equi }}</td>
                                <td class="px-4 py-3 text-sm">{{ equipment.characteristics }}</td>
                                <td class="px-4 py-3 text-sm">{{ equipment.serie_equi }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span :class="{
                                        'text-red-500': equipment.status === 'inactivo',
                                        'text-green-500': equipment.status === 'disponible',
                                        'text-purple-800': equipment.status === 'reparacion',
                                    }">{{ equipment.status }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex space-x-2">
                                        <template v-if="equipment.status === 'disponible'">
                                            <EditButton @click="openModalForm(2, equipment)">Editar</EditButton>
                                            <ShowButton @click="openModalrepa(equipment)">Reparación</ShowButton>
                                            <DeleteButton @click="openModalDel(equipment)">Inactivar</DeleteButton>
                                        </template>
                                        <template v-else>
                                            <GreenButton @click="activateProgram(equipment)">Reactivar</GreenButton>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between p-4">
                    <Pagination :links="props.equipments.links" />
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
