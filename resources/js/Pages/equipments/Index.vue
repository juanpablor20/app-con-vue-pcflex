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
import GreenButton from "@/Components/GreenButton.vue";
import EditButton from "@/Components/EditButton.vue";
import CreateButton from "@/Components/CreateButton.vue";
import { useForm } from "@inertiajs/vue3";
import ShowButton from "@/Components/ShowButton.vue";
import SearchForm from "@/Components/SearchForm.vue";
const showModalvue = ref(false);
const showModalForm = ref(false);
const showModalDel = ref(false);
const showModalrepa = ref(false);
const showModalReactive = ref(false);

// Configuración del formulario
const form = useForm({
    type_equi: "",
    characteristics: "",
    serie_equi: "",
    errors: {}
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
    if (!searchTerm.value) {
        return props.equipments.data;
    }
    return props.equipments.data.filter(equipment => 
        equipment.serie_equi.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
        equipment.type_equi.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
        equipment.characteristics.toLowerCase().includes(searchTerm.value.toLowerCase())
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
const openModalDel = (equipment) => {
    showModalDel.value = true;
    v.value = { ...equipment };
};

const openModalrepa = (equipment) => {
    showModalrepa.value = true;
    v.value = { ...equipment };
};
const openModalReactive = (equipment) => {
    showModalReactive.value = true;
    v.value = { ...equipment };
};


const closeModalForm = () => {
    showModalForm.value = false;
    errors: {}
    form.reset();
};
const closeModaldel = () => {
    showModalDel.value = false;
};

const closeModalrepa = () => {
    showModalrepa.value = false;
};
const closeModalReactive = () => {
    showModalReactive.value = false;
};


// Guardar equipo (crear o editar)
const save = () => {
    if (operation.value === 1) {
        form.post(route("equipments.store"), {
            onSuccess: () => {
                showSuccessAlert("Equipo creado con éxito");
            },
        });
    } else {
        form.put(route("equipments.update", v.value.id), {
            onSuccess: () => {
                showSuccessAlert("Equipo editado con éxito");
            },
            onError: (errors) => {

                closeModalForm();

showErrorAlert(errors.error);
}
        });
    }
};

// Mostrar mensaje de éxito


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
  
// Eliminar equipo
// Eliminar equipo
const deleteprogram = () => {
    form.delete(route("equipments.destroy", v.value.id), {
        onSuccess: () => {
            closeModaldel(); // Cerrar el modal de eliminación
            showSuccessAlert("Equipo inactivado con éxito"); // Mostrar el mensaje de éxito
        },
        onError: (errors) => {


            closeModaldel(); // Cerrar el modal de eliminación
        
        showErrorAlert(errors.error);
        }
        
    });
};

// Enviar a reparación
const reparationEquipment = (equipments) => {
    form.put(route("equipments.reparation", equipments.id), {
        onSuccess: () => {
            closeModalrepa(); // Cerrar el modal de reparación
            showSuccessAlert("Equipo enviado a reparación"); // Mostrar el mensaje de éxito
        },
        onError: (errors) => {
            closeModalrepa(); 
        showErrorAlert(errors.error);
        }
    });
};


const showErrorAlert = (message) => {
	Swal.fire({
	  icon: 'error',
	  title: 'Oops...',
	  text: message,
	});
  };

const activateProgram = (equipments) => {
    form.put(route("equipments.activate", equipments.id), {
        onSuccess: () => {
            closeModalReactive(); 
            showSuccessAlert("Equipo activado con éxito");
        },
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
               <div class="flex gap-x-4">
                <button @click="downloadPdf" class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fa fa-file" aria-hidden="true"></i>
                    PDF
                </button>
                <CreateButton @click="openModalForm(1)">
                    <i class="fas fa-plus mr-1"></i>
                    Crear
                </CreateButton>
               </div>
                <SearchForm v-model:search="searchTerm" />


            </div>
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">
           
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
                                        'text-red-700': equipment.status === 'prestado',
                                        'text-green-500': equipment.status === 'disponible',
                                        'text-purple-800': equipment.status === 'reparacion',
                                    }">{{ equipment.status }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex space-x-2">
                                        <template v-if="equipment.status === 'disponible' || equipment.status === 'prestado'">
                                            <EditButton @click="openModalForm(2, equipment)">Editar</EditButton>
                                            <ShowButton @click="openModalrepa(equipment)">Reparación</ShowButton>
                                            <DeleteButton @click="openModalDel(equipment)">Inactivar</DeleteButton>
                                        </template>
                                        <template v-else>
                                            <GreenButton @click="openModalReactive(equipment)">Reactivar</GreenButton>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between p-4">
                   <Pagination :links="props.equipments.links" :query="searchTerm.value" />

                </div>
            </div>
        </div>
        <Modal :show="showModalForm" @close="closeModalForm">
            <div class="p-6 space-y-4">
                <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
                <InputLabel for="type_equi" value="Tipo de Equipo" />
                <TextInput v-model="form.type_equi" required placeholder="ejemplo: portatil" />
                <InputError class="mt-1" :message="form.errors.type_equi" />
                
                <InputLabel for="characteristics" value="Características" />
                <TextInput v-model="form.characteristics" required  placeholder="ejemplo: lenovo gaming"/>
                <InputError class="mt-1" :message="form.errors.characteristics" />
                
                <InputLabel for="serie_equi" value="Número de Serie" />
                <TextInput v-model="form.serie_equi" required />
               <InputError class="mt-1" :message="form.errors.serie_equi" /> 
                <!-- <InputError class="mt-1" :message="!isSerieEquiValid ? 'El número de serie debe contener al menos 3 dígitos.' : ''" /> -->
                <div class="flex justify-end gap-x-2">
                    <SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
    
                    <CreateButton @click="save">Guardar</CreateButton>
                </div>
            </div>

            
        </Modal>

        <!-- Modal para eliminación -->
        <Modal :show="showModalDel" @close="closeModaldel">

            <div class="p-6 space-y-4">

            
            <div class="p-6 space-y-4">
                <h1>¿Estás seguro de realizar esta acción?</h1>
                <p>Tenga en cuenta que esta información no se eliminará, solo se cambia el estado a inactivo.</p>
            </div>
            <div class="flex justify-end gap-x-2">
                <SecondaryButton @click="closeModaldel">Cancelar</SecondaryButton>
                <DangerButton @click="deleteprogram">Sí, seguro</DangerButton>
            </div>
        </div>
        </Modal>

        <!-- Modal para reparación -->
        <Modal :show="showModalrepa" @close="closeModalrepa">
            <div class="p-6 space-y-4">

            <div class="p-6">
                <h1>¿Estás seguro de enviar a reparación?</h1>
                <p>Tenga en cuenta que este equipo no se prestará nuevamente, y su estado se cambia manualmente.</p>
            </div>
            <div class="flex justify-end gap-x-2">
                <SecondaryButton @click="closeModalrepa">Cancelar</SecondaryButton>
                <DangerButton @click="activateProgram(v)">Sí, seguro</DangerButton>
            </div>
        </div>

        </Modal>





        <Modal :show="showModalReactive" @close="closeModalReactive">
            <div class="p-6 space-y-4">

            <div class="p-6">
                <h1>¿Estás seguro de  que el Equipo se ecuentra en biblioteca?</h1>
                <p>Tenga en cuenta que al reactivar el equipo, El sistema asume que el equipo Esta en Biblioteca.</p>
            </div>
            <div class="flex justify-end gap-x-2">
                <SecondaryButton @click="closeModalReactive">Cancelar</SecondaryButton>
                <DangerButton @click="activateProgram(v)">Sí, Reactivar</DangerButton>
            </div>
        </div>

        </Modal>


    </AuthenticatedLayout>
</template>
