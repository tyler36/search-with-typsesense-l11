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
  <div class="max-w-5xl mx-auto">
    <ais-instant-search :search-client="searchClient" index-name="books" class="space-y-2">
      <div class="grid grid-cols-12 gap-8">
        <aside class="col-span-3 space-y-4">
          <ais-panel>
            <template #header>Authors</template>
            <ais-refinement-list attribute="authors" />
          </ais-panel>
          <ais-panel>
            <template #header>Publication Year</template>
            <ais-numeric-menu attribute="publication_year" :items="[
                { label: 'All' },
                { label : '2000 - Now', start: 2000},
                { label : '1980 - 1999', start: 1980, end: 1989},
                { label : '1900 - 1979', start: 1900, end: 1979},
                { label : 'Ancient', end: 1899},
            ]"></ais-numeric-menu>
          </ais-panel>
        </aside>
        <div class="col-span-9">
          <ais-search-box/>
          <ais-stats
            :class-names="object" class="my-4"
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
        </div>
      </div>
    </ais-instant-search>
  </div>
</template>

<style>
.ais-RefinementList-label,
.ais-NumericMenu-label{
  display: flex;
  gap: .5rem;
  padding: .1rem 0;
}
</style>
