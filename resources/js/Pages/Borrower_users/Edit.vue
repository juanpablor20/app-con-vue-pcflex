<template>
  <Head title="Editar Usuario" />
  <AuthenticatedLayout>
      <template #header>
          Editar Usuario
      </template>
      <!-- Pasar `index_cards` a Form -->
      <Form :user="user" :isEdit="true" :index_cards="index_cards" />
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Form from "./form.vue";
import { Head, usePage } from "@inertiajs/vue3";

const page = usePage();
const { user, index_cards } = page.props;

</script>
