<template>
  <form @submit.prevent="submit" class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nombre:</label>
        <input type="text" v-model="form.name" id="name" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
        <InputError class="mt-1" :message="form.errors.name" />
      </div>
      <div>
        <label for="last_name" class="block text-sm font-medium text-gray-700">Apellido:</label>
        <input type="text" v-model="form.last_name" id="last_name" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
        <InputError class="mt-1" :message="form.errors.last_name" />
      </div>
      <div>
        <label for="telephone_con" class="block text-sm font-medium text-gray-700">Teléfono:</label>
        <input type="text" v-model="form.telefono" id="telephone_con" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
        <InputError class="mt-1" :message="form.errors.telefono" />
      </div>
      <div>
        <label for="address_add" class="block text-sm font-medium text-gray-700">Dirección:</label>
        <input type="text" v-model="form.direccion" id="address_add" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
        <InputError class="mt-1" :message="form.errors.direccion" />
      </div>
      <div>
        <label for="email_con" class="block text-sm font-medium text-gray-700">Correo:</label>
        <input type="email" v-model="form.email" id="email_con" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
        <InputError class="mt-1" :message="form.errors.email" />
      </div>
      <div>
        <label for="type_identification" class="block text-sm font-medium text-gray-700">Tipo de identificación:</label>
        <select v-model="form.type_identification" id="type_identification" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
          <option value="">Seleccione el tipo de identidad</option>
          <option value="Cédula de ciudadanía">Cédula de ciudadanía</option>
          <option value="Targeta de identidad">Targeta de identidad</option>
          <option value="Permiso por proteccion temporal">Permiso por proteccion temporal</option>
        </select>
        <InputError class="mt-1" :message="form.errors.type_identification" />
      </div>
      <div>
        <label for="number_identification" class="block text-sm font-medium text-gray-700">Número de
          Identificación:</label>
        <input type="text" v-model="form.number_identification" id="number_identification" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
        <InputError class="mt-1" :message="form.errors.number_identification" />
      </div>
      <div>
        <label for="sex_user" class="block text-sm font-medium text-gray-700">Sexo:</label>
        <select v-model="form.sexo" id="sex_user" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
          <option value="masculino">Masculino</option>
          <option value="femenino">Femenino</option>
        </select>
        <InputError class="mt-1" :message="form.errors.sexo" />
      </div>
      <div v-if="!isEdit" class="mt-4">
        <InputLabel for="password" value="Password" />
        <TextInput id="password" type="password" class="block w-full mt-1" v-model="form.password" required
          autocomplete="new-password" />
        <InputError class="mt-2" :message="form.errors.password" />
      </div>
      <div v-if="!isEdit" class="mt-4">
        <InputLabel for="password_confirmation" value="Confirm Password" />
        <TextInput id="password_confirmation" type="password" class="block w-full mt-1"
          v-model="form.password_confirmation" required autocomplete="new-password" />
        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>
    </div>
    <div class="flex justify-between items-center">
      <NavLink :href="route('users.index')">
        <SecondaryButton>Volver</SecondaryButton>
      </NavLink>
      <div class="space-y-6">
        <GreenButton type="submit">{{ isEdit ? 'Actualizar' : 'Crear' }}</GreenButton>
      </div>
    </div>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputError from '@/Components/InputError.vue';
import NavLink from '@/Components/NavLink.vue';
import GreenButton from '@/Components/GreenButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

// Props
const props = defineProps({
  user: {
    type: Object,
    default: () => ({
      name: '',
      last_name: '',
      type_identification: '',
      number_identification: '',
      sexo: '',
      telefono: '',
      direccion: '',
      email: '',
      password: '',
      password_confirmation: ''
    }),
  },
  isEdit: {
    type: Boolean,
    default: false,
  },
});

// Form
const form = useForm({
  name: props.user.name,
  last_name: props.user.last_name,
  type_identification: props.user.type_identification,
  number_identification: props.user.number_identification,
  sexo: props.user.sexo,
  telefono: props.user.telefono,
  direccion: props.user.direccion,
  email: props.user.email,
  password: '',
  password_confirmation: ''
});

// Submit handler
const submit = () => {
  if (props.isEdit) {
    form.put(route('users.update', props.user.id), {
      onFinish: () => form.reset('password', 'password_confirmation'),
    });
  } else {
    form.post(route('users.store'), {
      onFinish: () => form.reset('password', 'password_confirmation'),
    });
  }
};
</script>
