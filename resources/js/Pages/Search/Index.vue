<script setup>
import TypesenseInstantSearchAdapter from "typesense-instantsearch-adapter";

const typesenseInstantsearchAdapter = new TypesenseInstantSearchAdapter({
  server: {
    apiKey: "xyz",
    nodes: [
      {
        host: "localhost",
        port: 8108,
        protocol: "http"
      }
    ]
  },

  additionalSearchParameters: {
    query_by: "title"
  }
});
const searchClient = adapter.searchClient;

// const search = instantsearch({
//   searchClient,
//   indexName: "books"
// });

</script>

<template>
  <div class="">
    <h1>Search</h1>
    <ais-instant-search :search-client="searchClient" index-name="books">
      <ais-search-box/>
      <ais-stats
        :class-names="object"
      />
      <ais-hits>
        <template #item="{ item }">
          <ais-highlight attribute="title" :hit="item" />
        </template>
      </ais-hits>
    </ais-instant-search>
  </div>
</template>

<style scoped></style>
