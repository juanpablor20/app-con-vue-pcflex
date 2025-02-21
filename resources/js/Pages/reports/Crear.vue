<template>
    <div>
        <Head title="Crear Reporte" />
        <AuthenticatedLayout>
            <template #header> Crear Reporte </template>

            <form @submit.prevent="submit" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Descripción -->
                    <div>
                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-700"
                            >Descripción:</label
                        >
                        <textarea
                            id="description"
                            v-model="form.description"
                            class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        ></textarea>
                        <InputError
                            class="mt-1"
                            :message="form.errors.description"
                        />
                    </div>

                    <!-- Número de Documento -->
                    <div>
                        <label
                            for="numero_documento"
                            class="block text-sm font-medium text-gray-700"
                            >Número de Documento:</label
                        >
                        <input
                            type="text"
                            v-model="form.numero_documento"
                            id="numero_documento"
                            class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                        <InputError
                            class="mt-1"
                            :message="form.errors.numero_documento"
                        />
                    </div>

                    <!-- Número de Serie -->
                    <div>
                        <label
                            for="numero_serie"
                            class="block text-sm font-medium text-gray-700"
                            >Número de Serie:</label
                        >
                        <input
                            type="text"
                            v-model="form.numero_serie"
                            id="numero_serie"
                            class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                        <InputError
                            class="mt-1"
                            :message="form.errors.numero_serie"
                        />
                    </div>

                    <!-- Fecha de Finalización -->
                    <div>
                        <label
                            for="end_date"
                            class="block text-sm font-medium text-gray-700"
                            >Fecha de Finalización:</label
                        >
                        <input
                            type="date"
                            v-model="form.end_date"
                            id="end_date"
                            class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            required
                        />
                        <InputError
                            class="mt-1"
                            :message="form.errors.end_date"
                        />
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <NavLink :href="route('repors.index')">
                        <SecondaryButton>Volver</SecondaryButton>
                    </NavLink>
                    <GreenButton type="submit">Enviar</GreenButton>
                </div>
            </form>
        </AuthenticatedLayout>
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import GreenButton from "@/Components/GreenButton.vue";
import InputError from "@/Components/InputError.vue";
import NavLink from "@/Components/NavLink.vue";

// Props
const props = defineProps({
    user: {
        type: Object,
        default: () => ({
            description: "",
            numero_documento: "",
            numero_serie: "",
            end_date: "",
        }),
    },
    isEdit: {
        type: Boolean,
        default: false,
    },
});

// Form
const form = useForm({
    description: props.user.description,
    numero_documento: props.user.numero_documento,
    numero_serie: props.user.numero_serie,
    end_date: props.user.end_date,
});

// Submit handler
const submit = () => {
    form.post(route("Repors.creacion"), {
        onSuccess: () => {
            form.reset();
            showSuccessAlert("Reporte registrado con éxito");
        },
        onError: (errors) => showErrorAlert(errors.error),
    });
};

// Cancel handler
const cancel = () => {
    form.reset();
};

const showSuccessAlert = (message) => {
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: message,
        showConfirmButton: false,
        timer: 1500,
        toast: true,
    });
};

const showErrorAlert = (message) => {
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: message,
    });
};
</script>
