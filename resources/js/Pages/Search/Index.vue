<script setup>
import TypesenseInstantSearchAdapter from "typesense-instantsearch-adapter";
import "instantsearch.css/themes/algolia-min.css";

const adapter = new TypesenseInstantSearchAdapter({
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
    <ais-instant-search :search-client="searchClient" index-name="books" class="space-y-2">
      <ais-search-box/>
      <ais-stats
        :class-names="object"
      />
      <ais-hits>
        <template #item="{ item }">
          <h3 class="font-bold">
            <ais-highlight attribute="title" :hit="item" />
          </h3>
          <div>
            Author(s): <ais-highlight attribute="authors" :hit="item" />
          </div>
          <div>
            Publish Date: {{ item.publication_year }}
          </div>
        </template>
      </ais-hits>
    </ais-instant-search>
  </div>
</template>

<style scoped></style>
