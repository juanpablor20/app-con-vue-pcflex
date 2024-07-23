<!-- resources/js/Pages/Users/create.vue -->
<template>
    <Head title="Crear Usuario" />
    <AuthenticatedLayout>
      <template #header>
        Crear Usuario
      </template>
  
      <Form />
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import Form from "./FormC.vue";
  import { Head } from "@inertiajs/vue3";
  </script>
  