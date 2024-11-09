<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import NavLink from "@/Components/NavLink.vue";
const props = defineProps({
    user: Object,

});

console.log('users',  props.user);
</script>

<template>

    <Head title="Usuario" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalles del Usuario</h2>
                <NavLink :href="route('Borrower_users.index')">
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
                        <p class="text-sm text-gray-900">{{ user.sex_user }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Email:</label>
                        <p class="text-sm text-gray-900">{{ user.contacts.email_con }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Teléfono:</label>
                        <p class="text-sm text-gray-900">{{ user.contacts.telephone_con }}</p>
                    </div>
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Dirección:</label>
                        <p class="text-sm text-gray-900">{{ user.address.addres_add }}</p>
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Estado:</label>
                        <p class="text-sm text-gray-900">{{ user.status === 'activo' ? 'Activo' : 'Inactivo' }}</p>
                    </div>
                </div>
             
                <h3>Información de la ficha</h3>
                <div v-if="user.indexCards && user.indexCards.length > 0">
                    <div v-for="card in user.indexCards" :key="card.id" class="mb-2">
                        <label class="block text-sm font-medium text-gray-700">Número de ficha:</label>
                        <p class="text-sm text-gray-900">{{ card.number }}</p>
                        <label class="block text-sm font-medium text-gray-700">Programa ID:</label>
                        <p class="text-sm text-gray-900">{{ card.program_id }}</p>
                    </div>
                </div>
                
                
                
                
                
            </div>




        </div>
    </AuthenticatedLayout>
</template>
