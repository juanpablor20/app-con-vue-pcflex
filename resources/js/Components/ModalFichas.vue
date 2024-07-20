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
    names: '',
    program_id: '',
});

watch(() => props.equipo, (newVal) => {
    form.reset({
        id: newVal.id || '',
        names: newVal.names || '',
        program_id: newVal.program_id || '',
    });
}, { immediate: true });

const save = () => {
    if (form.id) {
        form.put(route('indexCard.update', form.id), {
            onSuccess: () => closeModal()
        });
    } else {
        form.post(route('indexCard.store'), {
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
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="names">Nombre</label>
                    <input v-model="form.names" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="names" type="text" placeholder="Nombre">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="program_id">Programa</label>
                    <input v-model="form.program_id" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="program_id" type="text" placeholder="Program ID">
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 mr-2">Cancelar</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</template>
