<template>
	<AuthenticatedLayout>
		<template #header>
			<div class="flex items-center justify-between">
				<!-- Título con icono (centro) -->
				<div class="flex items-center space-x-3">
					<i class="fas fa-tachometer-alt text-2xl text-blue-500"></i> <!-- Icono de dashboard -->
					<div>
						<div class="page-pretitle text-gray-500">Panel Principal</div>
						<h2 class="page-title text-gray-800">PcFlex</h2>
					</div>
				</div>

				<!-- Botones de Préstamo y Devolución (ocultos para bibliotecario) -->
				<template v-if="hasRole('bibliotecario')">
					<GreenButton @click="openModalForm(1)">
						<i class="fas fa-hand-holding mr-2"></i> <!-- Icono de préstamo -->
						Registrar Préstamo
					</GreenButton>
					<DangerButton @click="openModalForm(2)">
						<i class="fas fa-undo-alt mr-2"></i> <!-- Icono de devolución -->
						Registrar Devolución
					</DangerButton>
				</template>

				<!-- Buscador y botón PDF (derecha) -->
				<div class="flex items-center space-x-4">
					<button
						@click="downloadPdf"
						class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
					>
						<i class="fas fa-file-pdf mr-2"></i> <!-- Icono de PDF -->
						PDF
					</button>
					<div class="flex items-center space-x-2">
						<SearchService
							v-model:search="searchTerm"
							@search="handleSearch"
							class="ml-auto"
						/>
					</div>
				</div>
			</div>
		</template>

		<!-- Resto del código de la tabla y modales -->
		<div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
			<div class="overflow-x-auto w-full">
				<table class="w-full whitespace-no-wrap">
					<thead>
						<tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
							<th class="px-4 py-3">Fecha préstamo</th>
							<th class="px-4 py-3">Número documento</th>
							<th class="px-4 py-3">Número de Serie</th>
							<th class="px-4 py-3">Ambientes</th>
							<th class="px-4 py-3">Estado</th>
							<th class="px-4 py-3">Acciones</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y">
						<tr v-for="service in filteredservices" :key="service.id" class="text-gray-700">
							<td class="px-4 py-3 text-sm">
								{{ service.date_ser }}
							</td>
							<th class="px-4 py-3 text-sm">
								{{ service.users.number_identification }}
							</th>
							<td class="px-4 py-3 text-sm">
								{{ service.equipment.serie_equi }}
							</td>
							<th class="px-4 py-3 text-sm">
								{{ service.environment.names }}
							</th>
							<td class="px-4 py-3 text-sm">
								<span :class="{'text-red-500': service.status === 'pendiente'}">
									{{ service.status }}
								</span>
							</td>
							<td class="px-4 py-3 text-sm">
								<NavLink :href="route('detalles.show', service.id)">
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

		<!-- Modales (sin cambios) -->
		<Modal :show="showModalForm" @close="closeModalForm">
			<!-- Contenido del modal de préstamo -->
		</Modal>
		<Modal :show="showModaldevolution" @close="closeModalForm">
			<!-- Contenido del modal de devolución -->
		</Modal>
	</AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from "vue";
import { useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GreenButton from '@/Components/GreenButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Pagination from '@/Components/Pagination.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import NavLink from '@/Components/NavLink.vue';
import ShowButton from '@/Components/ShowButton.vue';
import SearchService from '@/Components/SearchService.vue';

// Obtener los roles del usuario autenticado
const page = usePage();
const roles = computed(() => page.props.auth.roles || []);

// Función para verificar si el usuario tiene un rol específico
const hasRole = (role) => roles.value.includes(role);

// Resto del código (sin cambios)
const showModalForm = ref(false);
const showModaldevolution = ref(false);
const form = useForm({
	equipment_id: '',
	user_borrower_id: '',
	user_returner_id: '',
	environment_id: '',
});

const props = defineProps({
	services: {
		type: Object,
		required: true,
	},
	environments: Array,
});

const title = ref('');
const operation = ref(1);
const searchTerm = ref("");

const filteredservices = computed(() => {
	if (!searchTerm.value) {
		return props.services.data;
	}
	const lowerCaseSearchTerm = searchTerm.value.toLowerCase();
	return props.services.data.filter((service) => {
		return (
			service.equipment.serie_equi.toLowerCase().includes(lowerCaseSearchTerm) ||
			service.users.number_identification.toLowerCase().includes(lowerCaseSearchTerm) ||
			service.environment.names.toLowerCase().includes(lowerCaseSearchTerm)
		);
	});
});

const openModalForm = (op) => {
	operation.value = op;
	if (op === 1) {
		showModalForm.value = true;
		title.value = 'Registrar Préstamo';
	} else {
		showModaldevolution.value = true;
		title.value = 'Registrar Devolución';
	}
};

const closeModalForm = () => {
	showModalForm.value = false;
	showModaldevolution.value = false;
	form.reset();
	form.clearErrors();
};

const save = () => {
	if (operation.value === 1) {
		form.post(route('prestamos.store'), {
			onSuccess: () => {
				showSuccessAlert('Préstamo registrado con éxito');
				closeModalForm();
			},
			onError: (errors) => showErrorAlert(errors.error),
		});
	} else {
		form.put(route('devolucion.resivir'), {
			onSuccess: () => {
				showSuccessAlert('Devolución registrada con éxito');
				closeModalForm();
    },
			onError: (errors) => showErrorAlert(errors.error),
		});
	}
};

const showSuccessAlert = (message) => {
	Swal.fire({
		position: 'top-end',
		icon: 'success',
		title: message,
		showConfirmButton: false,
		timer: 1500,
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