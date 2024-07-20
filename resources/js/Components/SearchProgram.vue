<template>
    <div>
      <input
        type="text"
        v-model="query"
        @input="search"
        placeholder="Buscar..."
      />
      <ul v-if="results.length">
        <li v-for="result in results" :key="result.id">{{ result.name }}</li>
      </ul>
    </div>
  </template>
  
  <script>
import { Inertia } from '@inertiajs/inertia';
  import { ref, watch } from 'vue';
  
  export default {
    setup() {
      const query = ref('');
      const results = ref([]);
  
      const search = () => {
        if (query.value.length > 2) {
          Inertia.get('/search_program', { query: query.value }, {
            preserveState: true,
            replace: true,
            onSuccess: (page) => {
              results.value = page.props.results;
            },
          });
        } else {
          results.value = [];
        }
      };
  
      watch(query, (newQuery) => {
        search();
      });
  
      return {
        query,
        results,
        search,
      };
    },
  };
  </script>
  
  <style scoped>
  /* Puedes agregar estilos aquí */
  </style>
  