<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    equipo: { type: Object, default: () => ({}) },
    showModal: Boolean,
    onClose: Function,
    title: String
});

const form = useForm({
    id: '',
    type_equi: '',
    characteristics: '',
    serie_equi: '',
    
});

watch(() => props.equipo, (newVal) => {
    form.reset({
        id: newVal.id || '',
        type_equi: newVal.type_equi || '',
        characteristics: newVal.characteristics || '',
        serie_equi: newVal.serie_equi || '',
       
    });
}, { immediate: true });

const save = () => {
    if (form.id) {
        form.put(route('equipments.update', form.id), {
            onSuccess: () => closeModal()
        });
    } else {
        form.post(route('equipments.store'), {
            onSuccess: () => closeModal()
        });
    }
};

const closeModal = () => {
    form.reset();
    props.onClose();
};
</script>

<template>
    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">{{ title }}</h2>
            <form @submit.prevent="save">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="type_equi">Tipo de equipo</label>
                    <input v-model="form.type_equi" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type_equi" type="text" placeholder="Tipo de equipo">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="characteristics">Características</label>
                    <input v-model="form.characteristics" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="characteristics" type="text" placeholder="Características">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="serie_equi">Número de Serie</label>
                    <input v-model="form.serie_equi" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="serie_equi" type="text" placeholder="Número de Serie">
                    <div v-if="form.errors.serie_equi" class="text-red-500 text-sm mt-1">{{ form.errors.serie_equi }}</div>
               </div>
               
                <div class="flex justify-end">
                    <button type="button" @click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</template>
