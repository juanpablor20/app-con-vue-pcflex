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
        localSearch: this.search, // Inicializa con el valor de búsqueda
      };
    },
    watch: {
      search(newValue) {
        // Actualiza localSearch si la prop search cambia
        this.localSearch = newValue;
      },
      localSearch(newValue) {
        this.$emit('update:search', newValue);
  
        // Si el campo de búsqueda está vacío, realizar la búsqueda automáticamente
        if (newValue.trim() === '') {
          this.submitSearch();
        }
      },
    },
    methods: {
      submitSearch() {
        // Si el campo está vacío, enviamos una búsqueda sin parámetros para restablecer los resultados
        const searchQuery = this.localSearch.trim() === '' ? {} : { search: this.localSearch };
  
        // Realizamos la petición al servidor con el valor de búsqueda (o sin ella si está vacío)
        this.$inertia.get(this.route('equipments.index'), searchQuery);
      },
    },
  };
  </script>
  
  <style scoped>
  /* Puedes agregar tus estilos aquí */
  </style>
  