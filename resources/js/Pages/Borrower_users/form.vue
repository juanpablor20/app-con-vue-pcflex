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
        <input type="text" v-model="form.telephone_con" id="telephone_con" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
        <InputError class="mt-1" :message="form.errors.telephone_con" />
      </div>
      <div>
        <label for="address_add" class="block text-sm font-medium text-gray-700">Dirección:</label>
        <input type="text" v-model="form.address_add" id="address_add" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
        <InputError class="mt-1" :message="form.errors.address_add" />
      </div>
      <div>
        <label for="email_con" class="block text-sm font-medium text-gray-700">Correo:</label>
        <input type="email" v-model="form.email_con" id="email_con" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
        <InputError class="mt-1" :message="form.errors.email_con" />
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
        <label for="number_identification" class="block text-sm font-medium text-gray-700">Número de Identificación:</label>
        <input type="text" v-model="form.number_identification" id="number_identification" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
        <InputError class="mt-1" :message="form.errors.number_identification" />
      </div>
      <div>
        <label for="sex_user" class="block text-sm font-medium text-gray-700">Sexo:</label>
        <select v-model="form.sex_user" id="sex_user" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
          <option value="masculino">Masculino</option>
          <option value="femenino">Femenino</option>
        </select>
        <InputError class="mt-1" :message="form.errors.sex_user" />
      </div>
      <div>
        <InputLabel for="gender_sex" class="block text-sm font-medium text-gray-700">Género:</InputLabel>
        <select v-model="form.gender_sex" id="gender_sex" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
          <option value="Heterosexual">Heterosexual</option>
          <option value="Homosexual">Homosexual</option>
          <option value="no_binario">No Binario</option>
          <option value="prefiero no decir">Prefiero no decir</option>
        </select>
        <InputError class="mt-1" :message="form.errors.gender_sex" />
      </div>
      <div>
        <label for="roll" class="block text-sm font-medium text-gray-700">Roll:</label>
        <select v-model="form.roll" id="roll" required
          class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
          <option value="">Seleccione el tipo de roll</option>
          <option value="aprendiz">Aprendiz</option>
          <option value="instructor">Instructor</option>
          <option value="administrativo">Administrativo</option>
        </select>
        <InputError class="mt-1" :message="form.errors.roll" />
      </div>

      <div v-if="form.roll === 'aprendiz'">
        <InputLabel for="indexCard_id" value="index_card_id" class="mt-4" />
        <select v-model="form.index_card_id" id="index_card_id" class="mt-1 w-full">
            <option value="">Seleccione una ficha</option>
            <option v-for="index_card in index_cards" :key="index_card.id" :value="index_card.id">
                {{ index_card.number }}
            </option>
        </select>
        <InputError class="mt-1" :message="form.errors.index_card_id" />
    </div>
     
    </div>

    
    <div class="flex justify-between items-center">
      <NavLink :href="route('Borrower_users.index')">
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
// Props
const props = defineProps({
  user: {
    type: Object,
    default: () => ({
      name: '',
      last_name: '',
      type_identification: '',
      number_identification: '',
      sex_user: '',
      gender_sex: '',
      roll: '',
      contacts: {
        telephone_con: '',
        email_con: ''
      },
      address: {
        address_add: ''
      },
      indexCards: {
        index_card_id: ''
      }
    }),
  },
  isEdit: {
    type: Boolean,
    default: false,
  },
  index_cards: Array,

});
console.log(props.index_cards);
console.log(props.user);
// Form
const form = useForm({
  name: props.user.name,
  last_name: props.user.last_name,
  type_identification: props.user.type_identification,
  number_identification: props.user.number_identification,
  sex_user: props.user.sex_user,
  gender_sex: props.user.gender_sex,
  roll: props.user.roll,
  telephone_con: props.user.contacts?.telephone_con || '',
  email_con: props.user.contacts?.email_con || '',
  address_add: props.user.address?.addres_add || '',
 index_card_id: props.user.indexCards?.index_card_id || ''
 
});


// Submit handler
const submit = () => {
  if (props.isEdit) {
    form.put(route('Borrower_users.update', props.user.id));
    
  } else {
    form.post(route('Borrower_users.store'));
  }
};
</script>
