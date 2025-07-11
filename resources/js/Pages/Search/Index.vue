<script setup>
import { ref, watch } from 'vue';
import { router } from "@inertiajs/vue3";

let query = ref('');
let timeout = null

defineProps({
  results: {
    type: Array,
    default: () => []
  }
})

watch(query, function(newQuery){
  clearTimeout(timeout)
  timeout = setTimeout(() => {
    router.reload({
      data: {
        q: newQuery
      }
    })
  }, 400)
})
</script>

<template>
  <div class="">
    <h1>Search</h1>
    <input type="search" v-model="query">

    <div v-if="results.length">
      <h2>Results:</h2>
      <ul>
        <li v-for="result in results" :key="result.id" v-html="result" />
      </ul>
  </div>
  </div>
</template>

<style scoped></style>
