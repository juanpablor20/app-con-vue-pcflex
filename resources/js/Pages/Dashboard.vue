<template>
	<AuthenticatedLayout>
	  <template #header>
		<div class="page-pretitle">Panel Principal</div>
		<h2 class="page-title">PcFlex</h2>
		<div  class="flex items-center space-x-4 ml-auto">
		  <GreenButton @click="openModalForm(1)">Registrar Prestamo</GreenButton>
		  <DangerButton @click="openModalForm(2)">Registrar Devolucion</DangerButton>

		</div>
	  </template>
  
	  <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
		<div class="overflow-x-auto w-full">
		  <table class="w-full whitespace-no-wrap">
			<thead>
			  <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
				<th class="px-4 py-3">Fecha prestamo</th>
				<th class="px-4 py-3">Numero documento</th>
				<th class="px-4 py-3">Numero de Serie</th>
				<th class="px-4 py-3">Ambientes</th>
				<th class="px-4 py-3">Estado</th>
				<th class="px-4 py-3">Acciones</th>
			  </tr>
			</thead>
			<tbody class="bg-white divide-y">
			  <tr v-for="service in services.data" :key="service.id" class="text-gray-700">
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
					<NavLink :href="route('detalles.show',service.id)">
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
  
	  <Modal :show="showModalForm" @close="closeModalForm">
		<div class="p-6">
		  <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
		  <InputLabel for="number" value="Número de Documento" />
		  <TextInput v-model="form.user_borrower_id" required />
		  <InputError class="mt-1" :message="form.errors.user_borrower_id" />
		  <InputLabel for="" value="Numero de Serie"/>
		  <TextInput v-model="form.equipment_id" required />
          <InputError class="mt-1" :message="form.errors.equipment_id" />

		  <InputLabel for="environment_id" value="Ambiente a Trasladar" class="mt-4" />
		  <select v-model="form.environment_id">
			  <option v-for="environment in environments" :key="environment.id" :value="environment.id">
				  {{ environment.names }}
			  </option>
		  </select>
		  <InputError class="mt-1" :message="form.errors.environment_id" />
		</div>
  
		<div class="mt-6 flex justify-end">
		  <SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
		  <PrimaryButton @click="save">Guardar</PrimaryButton>
		</div>
	  </Modal>

	  <!-- modal devolucion -->
	  <Modal :show="showModaldevolution" @close="closeModalForm">
		<div class="p-6">
		  <h2 class="text-lg font-medium text-gray-900">{{ title }}</h2>
		  <InputLabel for="number" value="Número de Documento" />
		  <TextInput v-model="form.user_returner_id" required />
		  <InputError class="mt-1" :message="form.errors.user_returner_id" />
		  <InputLabel for="" value="Numero de Serie"/>
		  <TextInput v-model="form.equipment_id" required />
          <InputError class="mt-1" :message="form.errors.equipment_id" />
		</div>
  
		<div class="mt-6 flex justify-end">
		  <SecondaryButton @click="closeModalForm">Cancelar</SecondaryButton>
		  <PrimaryButton @click="save">Guardar</PrimaryButton>
		</div>
	  </Modal>
	</AuthenticatedLayout>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  import { ref } from "vue";
  import { useForm } from '@inertiajs/vue3';
  
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import GreenButton from '@/Components/GreenButton.vue';
  import DangerButton from '@/Components/DangerButton.vue';
  import Pagination from '@/Components/Pagination.vue';
  import InputError from '@/Components/InputError.vue';
  import TextInput from '@/Components/TextInput.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import Modal from '@/Components/Modal.vue';
  import SecondaryButton from '@/Components/SecondaryButton.vue';
  import PrimaryButton from '@/Components/PrimaryButton.vue';
  import NavLink from '@/Components/NavLink.vue';
  import ShowButton from '@/Components/ShowButton.vue';
  
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
        required: true
    },
    environments: Array,
	
  });
  
  const title = ref('');
  const operation = ref(1);
  
  const openModalForm = (op) => {
	operation.value = op;
	if (op === 1) {
		showModalForm.value = true;
		title.value = 'Registrar Prestamo';
	} else {
		showModaldevolution.value = true;
		title.value = 'Registrar Devolucion';
	}
  };
  
  const closeModalForm = () => {
	showModalForm.value = false;
	showModaldevolution.value = false;
	form.reset();
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
 
