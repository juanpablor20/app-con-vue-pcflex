<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <!-- Título con icono -->
        <div class="flex items-center space-x-3">
          <i class="fas fa-exclamation-triangle text-2xl text-yellow-500"></i> <!-- Icono de alerta -->
          <div>
            <div class="page-pretitle text-gray-500">Reportes</div>
            <h2 class="page-title text-gray-800">Crear Reporte</h2>
          </div>
        </div>
      </div>
    </template>

    <!-- Alerta de inconsistencia (estática) -->
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-md shadow-sm">
      <p class="font-bold">¡Inconsistencia detectada!</p>
      <p>Este usuario no es el mismo que realizó el préstamo. Por favor, completa el reporte.</p>
    </div>

    <!-- Formulario de creación de reporte -->
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
      <!-- Campo: Descripción -->
      <div class="mb-6">
        <InputLabel for="description" value="Descripción" class="font-medium text-gray-700" />
        <div class="relative">
          <i class="fas fa-align-left absolute left-3 top-3 text-gray-400"></i> <!-- Icono de descripción -->
          <textarea
            v-model="form.description"
            id="description"
            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            :class="{'border-red-500': form.errors.description}"
            placeholder="Describe la inconsistencia..."
          ></textarea>
        </div>
        <InputError class="mt-1 text-sm text-red-600" :message="form.errors.description" />
      </div>

      <!-- Campo oculto para el service_id -->
      <input type="hidden" v-model="form.service_id" />

      <!-- Campo: Fecha de Finalización -->
      <div class="mb-6">
        <InputLabel for="end_date" value="Fecha de Finalización" class="font-medium text-gray-700" />
        <div class="relative">
          <i class="fas fa-calendar-alt absolute left-3 top-3 text-gray-400"></i> <!-- Icono de calendario -->
          <input
            type="date"
            v-model="form.end_date"
            id="end_date"
            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            :class="{'border-red-500': form.errors.end_date}"
          />
        </div>
        <InputError class="mt-1 text-sm text-red-600" :message="form.errors.end_date" />
      </div>

      <!-- Botones de acción -->
      <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
        <SecondaryButton @click="cancel" class="bg-gray-300 hover:bg-gray-400 text-gray-700">
          <i class="fas fa-times mr-2"></i> Cancelar
        </SecondaryButton>
        <PrimaryButton @click="submit" class="bg-blue-600 hover:bg-blue-700 text-white">
          <i class="fas fa-save mr-2"></i> Guardar Reporte
        </PrimaryButton>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

// Accedemos a los props
const { service } = defineProps({
  service: Object, // Objeto del servicio
});

// Inicializamos el formulario
const form = useForm({
  description: '',
  service_id: service.id, // Usamos el ID del servicio pasado desde el controlador
  end_date: ''
});

// Función para enviar el formulario
const submit = () => {
  form.post(route('reports.store'), {
    onSuccess: () => {
      form.reset();
      showSuccessAlert('Reporte registrado con éxito');
    },
    onError: (errors) => {
      showErrorAlert('Hubo un error al registrar el reporte');
    },
  });
};

// Función para cancelar
const cancel = () => {
  form.reset();
};

// Función para mostrar alerta de éxito
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

// Función para mostrar alerta de error
const showErrorAlert = (message) => {
  Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: message,
  });
};
</script>