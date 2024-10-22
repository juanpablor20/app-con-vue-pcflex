<template>
    <form @submit.prevent="submitSearch">
      <input 
        v-model="localSearch"
        type="text" 
        class="form-input" 
        placeholder="Buscar equipo..."
      />
      <button type="submit" class="bg-blue-500 text-white rounded p-2 ml-2">
        Buscar
      </button>
    </form>
  </template>
  
  <script>
  export default {
    props: {
      search: {
        type: String,
        default: '',
      },
    },
    data() {
      return {
        localSearch: this.search, // Inicializa una propiedad local con el valor de la prop
      };
    },
    watch: {
      localSearch(newValue) {
        this.$emit('update:search', newValue); // Emitimos el evento cuando cambie el valor
      },
    },
    methods: {
      submitSearch() {
        // Usamos la propiedad local para enviar la búsqueda
        this.$inertia.get(this.route('equipments.index'), { search: this.localSearch });
      },
    },
  };
  </script>
  
  <style scoped>
  /* Puedes agregar tus estilos aquí */
  </style>
  