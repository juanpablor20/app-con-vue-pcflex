<template>
    <div>
      <h1>Resultados de búsqueda para "{{ query }}"</h1>
      <ul>
        <li v-for="result in results" :key="result.id">{{ result.name }}</li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      results: Array,
      query: String,
    },
  };
  </script>
  
  <style scoped>
  /* Puedes agregar estilos aquí */
  </style>
  