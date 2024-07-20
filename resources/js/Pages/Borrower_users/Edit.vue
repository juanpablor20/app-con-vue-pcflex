<!-- resources/js/Pages/Users/edit.vue -->
<template>
    <Head title="Editar Usuario" />
    <AuthenticatedLayout>
      <template #header>
        Editar Usuario
      </template>
  
      <Form :user="user" :isEdit="true" />
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import Form from "./form.vue";
  import { Head, usePage } from "@inertiajs/vue3";
  
  const page = usePage();
  const user = page.props.user;
  </script>
  