<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import NavLink from "@/Components/NavLink.vue";
const props = defineProps({
    user: Object,

});
</script>

<template>

    <Head title="Bibliotecario" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalles del Bibliotecario</h2>
                <NavLink :href="route('users.index')">
                    <SecondaryButton>

                        Volver
                    </SecondaryButton>
                </NavLink>
            </div>
        </template>

        <div class="p-4 bg-white rounded-lg shadow-xs">
            <div class="mb-4">
                <h3 class="text-lg font-semibold mb-2">Información Personal</h3>
                <div class="grid grid-cols-2 gap-x-4">
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Nombre:</label>
                        <p class="text-sm text-gray-900">{{ user.name }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Apellido:</label>
                        <p class="text-sm text-gray-900">{{ user.last_name }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Identificación:</label>
                        <p class="text-sm text-gray-900">{{ user.number_identification }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Sexo:</label>
                        <p class="text-sm text-gray-900">{{ user.sexo }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Email:</label>
                        <p class="text-sm text-gray-900">{{ user.email }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Teléfono:</label>
                        <p class="text-sm text-gray-900">{{ user.telefono }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Direccion:</label>
                        <p class="text-sm text-gray-900">{{ user.direccion }}</p>
                    </div>
                </div>
            </div>




        </div>
    </AuthenticatedLayout>
</template>
