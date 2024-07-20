<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    services: {
        type: Object,
    },
    
});
</script>

<template>
    <Head title="Usuario" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalles del Usuario</h2>
                <NavLink :href="route('dashboard')">
                    <SecondaryButton>
                        Volver
                    </SecondaryButton>
                </NavLink>
            </div>
        </template>

        <div class="p-6 bg-white rounded-lg shadow-sm">
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-user fa-lg mr-2"></i> Información Personal
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre:</label>
                        <p class="text-sm text-gray-900">{{ services.users.name }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Apellido:</label>
                        <p class="text-sm text-gray-900">{{ services.users.last_name }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Identificación:</label>
                        <p class="text-sm text-gray-900">{{ services.users.number_identification }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Sexo:</label>
                        <p class="text-sm text-gray-900">{{ services.users.sex_user }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email:</label>
                        <p class="text-sm text-gray-900">{{ services.users.contacts.email_con }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Teléfono:</label>
                        <p class="text-sm text-gray-900">{{ services.users.contacts.telephone_con }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Dirección:</label>
                        <p class="text-sm text-gray-900">{{ services.users.address.addres_add }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Estado:</label>
                        <p class="text-sm text-gray-900">{{ services.users.status === 'activo' ? 'Activo' : 'Inactivo' }}</p>
                    </div>
                </div>
                <hr class="my-6 border-gray-300">
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-laptop fa-lg mr-2"></i> Información Del Equipo
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tipo de Equipo:</label>
                        <p class="text-sm text-gray-900">{{ services.equipment.type_equi }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Características:</label>
                        <p class="text-sm text-gray-900">{{ services.equipment.characteristics }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Identificación:</label>
                        <p class="text-sm text-gray-900">{{ services.equipment.serie_equi }}</p>
                    </div>
                </div>
                <hr class="my-6 border-gray-300">
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-map-marker-alt fa-lg mr-2"></i> Información Del Lugar de Traslado
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Ambiente:</label>
                        <p class="text-sm text-gray-900">{{ services.environment.names }}</p>
                    </div>
                </div>
                <hr class="my-6 border-gray-300">

            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <i class="fas fa-user fa-lg mr-2"></i> Información Del Bibliotecario
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre:</label>
                        <p class="text-sm text-gray-900">{{ services.librarian.name }}</p>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
