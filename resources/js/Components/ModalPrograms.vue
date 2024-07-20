<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import GreenButton from '@/Components/GreenButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const showModal = ref(false);
const form = useForm({
    names: '',
    code_pro: '',
    version: ''
});
const isEditMode = ref(false);
const modalTitle = ref('');

const openModal = (program = null) => {
    if (program) {
        form.reset({
            names: program.names_pro,
            code_pro: program.code_pro,
            version: program.version
        });
        isEditMode.value = true;
        modalTitle.value = 'Editar Programa';
    } else {
        form.reset();
        isEditMode.value = false;
        modalTitle.value = 'Crear Programa';
    }
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const submitForm = () => {
    if (isEditMode.value) {
        form.put(route('programs.update', form.id), {
            onSuccess: () => closeModal()
        });
    } else {
        form.post(route('programs.store'), {
            onSuccess: () => closeModal()
        });
    }
};
</script>

<template>
    <Modal :show="showModal" @close="closeModal">
        <template #title>{{ modalTitle }}</template>
        <div class="p-6">
            <div class="mb-4">
                <label for="names" class="block text-sm font-medium text-gray-700">Nombre del Programa</label>
                <input v-model="form.names" id="names" type="text" class="mt-1 block w-full" />
                <InputError :message="form.errors.names" />
            </div>
            <div class="mb-4">
                <label for="code_pro" class="block text-sm font-medium text-gray-700">Código del Programa</label>
                <input v-model="form.code_pro" id="code_pro" type="text" class="mt-1 block w-full" />
                <InputError :message="form.errors.code_pro" />
            </div>
            <div class="mb-4">
                <label for="version" class="block text-sm font-medium text-gray-700">Versión</label>
                <input v-model="form.version" id="version" type="text" class="mt-1 block w-full" />
                <InputError :message="form.errors.version" />
            </div>
        </div>
        <template #footer>
            <SecondaryButton @click="closeModal">Cancelar</SecondaryButton>
            <GreenButton @click="submitForm">Guardar</GreenButton>
        </template>
    </Modal>
</template>
