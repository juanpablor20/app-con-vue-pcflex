<template>
  <Head title="Crear Reporte" />
  <AuthenticatedLayout>
    <template #header>
      Crear Reporte
    </template>

    <div class="form-group mb-3">
      <label class="form-label">Descripción</label>
      <div>
        <textarea 
          v-model="form.description" 
          class="form-control" 
          :class="{'is-invalid': form.errors.description}" 
          placeholder="Descripción"
        ></textarea>
        <div v-if="form.errors.description" class="invalid-feedback">{{ form.errors.description }}</div>
      </div>
    </div>
    
    <input type="hidden" v-model="form.service_id" />

    <div class="form-group mb-3">
      <label class="form-label">Fecha de Finalización</label>
      <div>
        <input 
          type="date" 
          v-model="form.end_date" 
          class="form-control" 
          :class="{'is-invalid': form.errors.end_date}" 
        />
        <div v-if="form.errors.end_date" class="invalid-feedback">{{ form.errors.end_date }}</div>
      </div>
    </div>

    <div class="form-footer">
      <div class="text-end">
        <div class="d-flex">
          <SecondaryButton @click="cancel" class="btn btn-danger">Cancelar</SecondaryButton>
          <button @click="submit" class="btn btn-primary ms-auto">Submit</button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Head, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const { props } = usePage();
const serviceId = props.serviceId || '';  // Aseguramos que serviceId está presente en props

const form = useForm({
  description: '',
  service_id: serviceId,  // Asigna el service_id desde los props
  end_date: ''
});

const submit = () => {
  form.post(route('repors.store'), {
    onSuccess: () => {
      form.reset();
      showSuccessAlert('Reporte registrado con éxito');
    },
    onError: (errors) => showErrorAlert(errors.error),
  });
};

const cancel = () => {
  form.reset();
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
