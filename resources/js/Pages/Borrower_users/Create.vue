<!-- resources/js/Pages/Users/create.vue -->
<template>
  <Head title="Crear Usuario" />
  <AuthenticatedLayout>
      <template #header>
          Crear Usuario
      </template>

      <Form :index_cards="index_cards" /> <!-- Asegúrate de pasar las props -->
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "./form.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
  index_cards: {
      type: Array,
      required: true
  }
});
</script>
