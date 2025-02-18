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
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalles del Préstamo</h2>
                <NavLink :href="route('dashboard')">
                    <SecondaryButton>
                        Volver
                    </SecondaryButton>
                </NavLink>
            </div>
        </template>

        <div class="p-6 bg-white rounded-lg shadow-sm">
            <!-- Mensaje "Pendiente por entrega" en la parte derecha -->
            <div class="flex justify-end mb-6">
                <div class="flex items-center bg-red-50 p-4 rounded-lg border border-red-200">
                    <i class="fas fa-warning text-3xl text-red-600 mr-3"></i>
                    <div>
                        <h3 class="text-lg font-semibold text-red-600">Pendiente por entrega</h3>
                        <p class="text-sm text-red-500">El equipo aún no ha sido devuelto.</p>
                    </div>
                </div>
            </div>

            <!-- Información Personal -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center text-blue-600">
                    <i class="fas fa-user fa-lg mr-2"></i> Información Personal del Prestatario
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre:</label>
                        <p class="text-sm text-gray-900 font-semibold">{{ services.users.name }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Apellido:</label>
                        <p class="text-sm text-gray-900 font-semibold">{{ services.users.last_name }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Identificación:</label>
                        <p class="text-sm text-gray-900 font-semibold">{{ services.users.number_identification }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Sexo:</label>
                        <p class="text-sm text-gray-900 font-semibold">{{ services.users.sex_user }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email:</label>
                        <p class="text-sm text-gray-900 font-semibold">{{ services.users.contacts.email_con }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Teléfono:</label>
                        <p class="text-sm text-gray-900 font-semibold">{{ services.users.contacts.telephone_con }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Dirección:</label>
                        <p class="text-sm text-gray-900 font-semibold">{{ services.users.address.addres_add }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Estado:</label>
                        <p class="text-sm font-semibold">
                            {{ services.users.status }}
                        </p>
                    </div>
                </div>
                <hr class="my-6 border-gray-300">
            </div>

            <!-- Información del Equipo -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center text-blue-600">
                    <i class="fas fa-laptop fa-lg mr-2"></i> Información del Equipo
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tipo de Equipo:</label>
                        <p class="text-sm text-gray-900 font-semibold">{{ services.equipment.type_equi }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Características:</label>
                        <p class="text-sm text-gray-900 font-semibold">{{ services.equipment.characteristics }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Identificación:</label>
                        <p class="text-sm text-gray-900 font-semibold">{{ services.equipment.serie_equi }}</p>
                    </div>
                </div>
                <hr class="my-6 border-gray-300">
            </div>

            <!-- Información del Lugar de Traslado -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 flex items-center text-blue-600">
                    <i class="fas fa-map-marker-alt fa-lg mr-2"></i> Información del Lugar de Traslado
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Ambiente:</label>
                        <p class="text-sm text-gray-900 font-semibold">{{ services.environment.names }}</p>
                    </div>
                </div>
                <hr class="my-6 border-gray-300">
            </div>

            <!-- Información del Bibliotecario -->
            <div>
                <h3 class="text-lg font-semibold mb-4 flex items-center text-blue-600">
                    <i class="fas fa-user fa-lg mr-2"></i> Información del Bibliotecario que realizó el préstamo
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre:</label>
                        <p class="text-sm text-gray-900 font-semibold">{{ services.librarian.name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>