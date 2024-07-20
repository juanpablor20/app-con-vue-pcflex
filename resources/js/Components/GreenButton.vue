<template>
  <button :type="type" class="rounded-lg border border-transparent bg-green-600 px-4 py-2 text-center text-sm font-medium leading-5  duration-150 hover:bg-green-400 focus:outline-none focus:ring active:bg-green-600">
    <slot/>
  </button>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>
