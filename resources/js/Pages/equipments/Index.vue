<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import WarningButton from "@/Components/WarningButton.vue";
import GreenButton from "@/Components/GreenButton.vue";
import { useForm } from "@inertiajs/vue3";
import ShowButton from "@/Components/ShowButton.vue";

const showModalvue = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);
const showModalrepa = ref(false);

const form = useForm({
    type_equi: "",
    characteristics: "",
    serie_equi: "",
});

const v = ref({ id: "", type_equi: "", characteristics: "", serie_equi: "" });
const title = ref("");
const operation = ref(1);
const msj = ref("");
const classMsj = ref("hidden");

const openModalvue = (equipment) => {
    showModalvue.value = true;
    v.value = { ...equipment };
};

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

const openModalDel = (equipment) => {
    showModalDel.value = true;
    v.value = { ...equipment };
};

const openModalrepa = (equipment) => {
    showModalrepa.value = true;
    v.value = { ...equipment };
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

const closeModalrepa = () => {
    showModalrepa.value = false;
};

const props = defineProps({
    equipments: {
        type: Object,
        required: true,
    },
});

const save = () => {
    if (operation.value === 1) {
        form.post(route("equipments.store"), {
            onSuccess: () => {
                ok("Equipo creado con éxito");
            },
        });
    } else {
        form.put(route("equipments.update", v.value.id), {
            onSuccess: () => {
                ok("Equipo editado con éxito");
            },
        });
    }
};

const ok = (message) => {
    closeModalForm();
    closeModaldel();
    closeModalrepa();
    form.reset();
    msj.value = message;
    classMsj.value = "Equipo";
    setTimeout(() => {
        classMsj.value = "hidden";
    }, 8000);
};

const deleteprogram = () => {
    form.delete(route("equipments.destroy", v.value.id), {
        onSuccess: () => {
            ok("Equipo inactivado con éxito");
        },
    });
};

const reparationEquipment = (equipments) => {
    form.put(route("equipments.reparation", equipments.id), {
        onSuccess: () => {
            ok("Equipo enviado a reparación");
        },
    });
};

const activateProgram = (equipments) => {
    form.put(route("equipments.activate", equipments.id), {
        onSuccess: () => {
            ok("Equipo activado con éxito");
        },
    });
};
</script>

<template>
    <Head title="Equipos" />
    <AuthenticatedLayout>
        <template #header>
            Equipos
            <GreenButton @click="openModalForm(1)">Crear</GreenButton>
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
                            <tr v-for="equipment in equipments.data" :key="equipment.id" class="text-gray-700">
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
                                    <template v-if="equipment.status === 'disponible'">
                                        <WarningButton @click="openModalForm(2, equipment)">Editar</WarningButton>
                                        <DangerButton @click="openModalDel(equipment)">Inactivar</DangerButton>
                                        <ShowButton @click="openModalrepa(equipment)">Reparación</ShowButton>
                                    </template>
                                    <template v-else>
                                        <GreenButton @click="activateProgram(equipment)">Reactivar</GreenButton>
                                    </template>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                    <Pagination :links="equipments.links" />
                </div>
            </div>
        </div>

        <!-- Modal para el formulario -->
        <Modal :show="showModalForm" @close="closeModalForm">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
                <InputLabel for="type_equi" value="Tipo de Equipo" />
                <TextInput v-model="form.type_equi" required />
                <InputError class="mt-1" :message="form.errors.type_equi" />
                
                <InputLabel for="characteristics" value="Características" />
                <TextInput v-model="form.characteristics" required />
                <InputError class="mt-1" :message="form.errors.characteristics" />
                
                <InputLabel for="serie_equi" value="Número de Serie" />
                <TextInput v-model="form.serie_equi" required />
                <InputError class="mt-1" :message="form.errors.serie_equi" />
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
                <p>Tenga en cuenta que esta información no se eliminará, solo se cambia el estado a inactivo.</p>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModaldel">Cancelar</SecondaryButton>
                <DangerButton @click="deleteprogram">Sí, seguro</DangerButton>
            </div>
        </Modal>

        <!-- Modal para reparación -->
        <Modal :show="showModalrepa" @close="closeModalrepa">
            <div class="p-6">
                <h1>¿Estás seguro de enviar a reparación?</h1>
                <p>Tenga en cuenta que este equipo no se prestará nuevamente, y su estado se cambia manualmente.</p>
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModalrepa">Cancelar</SecondaryButton>
                <DangerButton @click="reparationEquipment(v)">Sí, seguro</DangerButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
