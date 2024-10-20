<template>
    <div>
      <button @click="generatePdf">Generar PDF</button>
      <modal v-if="showModal" @close="showModal = false">
        <iframe :src="pdfUrl" width="100%" height="600px"></iframe>
        <button @click="downloadPdf">Descargar PDF</button>
      </modal>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        showModal: false,
        pdfUrl: ''
      };
    },
    methods: {
      generatePdf() {
        this.$inertia.post('/generate-pdf', { /* tus datos */ })
          .then(response => {
            this.pdfUrl = response.pdfUrl; // Asignar la URL del PDF
            this.showModal = true; // Mostrar el modal
          })
          .catch(error => {
            console.error("Error generando PDF:", error);
          });
      },
      downloadPdf() {
        const link = document.createElement('a');
        link.href = this.pdfUrl;
        link.download = 'reporte_equipos.pdf'; // Nombre del archivo a descargar
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      }
    }
  };
  </script>
  